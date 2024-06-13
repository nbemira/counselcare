<?php

namespace App\Http\Controllers;

use App\Models\StudentQuestion;
use App\Models\Question;
use App\Models\Student;
use App\Models\Result;
use App\Models\Setting;
use App\Services\ClassificationService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    public function index()
    {
        $questionsCount = Question::count(); // Count the number of questions
        return view('student.home', compact('questionsCount'));
    }    

    public function assessment()
    {
        $studentIC = auth('student')->user()->ic;
        $questions = Question::all();
        $assessmentEnabled = Setting::find(1)->assessment_enabled;
    
        // Check if the student has any entries in the 'results' table
        $studentInResults = Result::where('ic', $studentIC)->exists();
    
        // Check if the student has '1' for 'sec_assessment_approval' in the 'interventions' table
        $studentApprovedForAssessment = DB::table('interventions')
            ->where('ic', $studentIC)
            ->where('sec_assessment_approval', 1)
            ->exists();
    
        // Check if the student has completed the second assessment round
        $studentInResultsRound2 = Result::where('ic', $studentIC)
            ->where('assessment_round', 2)
            ->exists();
    
        // Determine if the student can access the assessment
        $canAccessAssessment = (!$studentInResults || $studentApprovedForAssessment) && !$studentInResultsRound2;
    
        return view('student.assessment', compact('questions', 'studentIC', 'assessmentEnabled', 'canAccessAssessment'));
    }      

    public function submitAssessment(Request $request)
    {
        try {
            $ic = $request->input('student_ic');
            $validated_data = $request->validate([
                'answers.*' => 'required|in:0,1,2,3',
            ]);
    
            $depressionWeightage = 0;
            $anxietyWeightage = 0;
            $stressWeightage = 0;
    
            foreach ($request->answers as $question_id => $weightage) {
                $question = Question::find($question_id);
                switch ($question->category->category) {
                    case 'Depression':
                        $depressionWeightage += $weightage;
                        break;
                    case 'Anxiety':
                        $anxietyWeightage += $weightage;
                        break;
                    case 'Stress':
                        $stressWeightage += $weightage;
                        break;
                }
                StudentQuestion::create([
                    'ic' => $ic,
                    'question_id' => $question_id,
                    'weightage' => $weightage,
                ]);
            }
    
            $depressionSeverity = $this->getCategorySeverity('Depression', $depressionWeightage);
            $anxietySeverity = $this->getCategorySeverity('Anxiety', $anxietyWeightage);
            $stressSeverity = $this->getCategorySeverity('Stress', $stressWeightage);
    
            $status = $this->calculateStatus($depressionSeverity, $anxietySeverity, $stressSeverity);
    
            // Determine the assessment round
            $assessmentRound = 1;
            $studentApprovedForAssessment = DB::table('interventions')
                ->where('ic', $ic)
                ->where('sec_assessment_approval', 1)
                ->exists();
    
            if ($studentApprovedForAssessment) {
                $assessmentRound = 2;
            }
    
            Result::create([
                'ic' => $ic,
                'marks_d' => $depressionWeightage,
                'marks_a' => $anxietyWeightage,
                'marks_s' => $stressWeightage,
                'status' => $status,
                'assessment_round' => $assessmentRound,
            ]);
    
            return Redirect::route('student.dashboard')->with('message', 'Assessment submitted successfully.');
        } catch (ValidationException $e) {
            return Redirect::back()->withErrors($e->validator->errors());
        } catch (QueryException $e) {
            Log::error('Failed to save assessment answers: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to save assessment answers. ' . $e->getMessage());
        }
    }    
    
    private function calculateStatus($depressionSeverity, $anxietySeverity, $stressSeverity)
    {
        if ($depressionSeverity === 'Normal' || $depressionSeverity === 'Mild') {
            if ($anxietySeverity === 'Normal' || $anxietySeverity === 'Mild') {
                if ($stressSeverity === 'Normal' || $stressSeverity === 'Mild') {
                    return 1; // Passed
                }
            }
        }
    
        if ($depressionSeverity === 'Moderate' || $depressionSeverity === 'Severe' || $depressionSeverity === 'Very Severe' ||
            $anxietySeverity === 'Moderate' || $anxietySeverity === 'Severe' || $anxietySeverity === 'Very Severe' ||
            $stressSeverity === 'Moderate' || $stressSeverity === 'Severe' || $stressSeverity === 'Very Severe') {
            return 2; // Intervention needed
        }
    
        return 0;
    }

    public function dashboard()
    {
        $studentIC = auth('student')->user()->ic;
    
        // Fetch the latest created_at timestamp for the student
        $latestCreatedAt = DB::table('student_question')
            ->where('ic', $studentIC)
            ->max('created_at');
    
        // Fetch the category weightages for the latest created_at timestamp
        $categoryWeightages = DB::table('student_question')
            ->join('questions', 'student_question.question_id', '=', 'questions.id')
            ->join('category', 'questions.category_id', '=', 'category.category_id')
            ->where('student_question.ic', $studentIC)
            ->where('student_question.created_at', $latestCreatedAt)
            ->select('category.category', DB::raw('SUM(student_question.weightage) as total_weightage'))
            ->groupBy('category.category')
            ->get();

        $interventionNeeded = false;

        foreach ($categoryWeightages as $weightage) {
            $weightage->severity = $this->getCategorySeverity($weightage->category, $weightage->total_weightage);
            if (in_array($weightage->severity, ['Moderate', 'Severe', 'Very Severe'])) {
                $interventionNeeded = true;
            }
        }

        return view('student.dashboard', compact('categoryWeightages', 'interventionNeeded'));
    }         

    private function getCategorySeverity($category, $weightage) {
        switch ($category) {
            case 'Depression':
                if ($weightage >= 0 && $weightage <= 5) {
                    return 'Normal';
                } elseif ($weightage >= 6 && $weightage <= 7) {
                    return 'Mild';
                } elseif ($weightage >= 8 && $weightage <= 10) {
                    return 'Moderate';
                } elseif ($weightage >= 11 && $weightage <= 14) {
                    return 'Severe';
                } else {
                    return 'Very Severe';
                }
                break;
            case 'Anxiety':
                if ($weightage >= 0 && $weightage <= 4) {
                    return 'Normal';
                } elseif ($weightage >= 5 && $weightage <= 6) {
                    return 'Mild';
                } elseif ($weightage >= 7 && $weightage <= 8) {
                    return 'Moderate';
                } elseif ($weightage >= 9 && $weightage <= 10) {
                    return 'Severe';
                } else {
                    return 'Very Severe';
                }
                break;
            case 'Stress':
                if ($weightage >= 0 && $weightage <= 7) {
                    return 'Normal';
                } elseif ($weightage >= 8 && $weightage <= 9) {
                    return 'Mild';
                } elseif ($weightage >= 10 && $weightage <= 13) {
                    return 'Moderate';
                } elseif ($weightage >= 14 && $weightage <= 17) {
                    return 'Severe';
                } else {
                    return 'Very Severe';
                }
                break;
            default:
                return '';

        return view('student.dashboard', compact('categoryWeightages'));
        }

    }
}