<?php

namespace App\Http\Controllers\Counsellor;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Result;
use App\Models\Intervention;
use App\Models\Psychologist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterventionAppointmentMail;
use PDF;

class CaseController extends Controller
{
    public function unanswered(Request $request)
    {
        $search = $request->input('search');
    
        $unansweredStudents = Student::whereNotIn('ic', function($query) {
            $query->select('ic')->from('results');
        })
        ->when($search, function ($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('ic', 'like', '%' . $search . '%')
                      ->orWhere('class', 'like', '%' . $search . '%');
            });
        })
        ->get();
    
        return view('counsellor.unanswered', ['unansweredStudents' => $unansweredStudents, 'search' => $search]);
    }     

    public function passed(Request $request)
    {
        $search = $request->input('search');
    
        $passedStudents = Result::join('students', 'results.ic', '=', 'students.ic')
            ->where('results.status', 1)
            ->where('results.assessment_round', 1)
            ->when($search, function ($query, $search) {
                return $query->where(function($query) use ($search) {
                    $query->where('students.name', 'like', '%' . $search . '%')
                          ->orWhere('students.ic', 'like', '%' . $search . '%')
                          ->orWhere('students.class', 'like', '%' . $search . '%');
                });
            })
            ->get(['students.ic', 'students.name', 'students.class', 'results.created_at', 'results.marks_d', 'results.marks_a', 'results.marks_s']);
    
        return view('counsellor.passed', ['passedStudents' => $passedStudents, 'search' => $search]);
    }    

    public function intervention(Request $request)
    {
        $search = $request->input('search');
    
        $interventionStudents = Result::join('students', 'results.ic', '=', 'students.ic')
            ->leftJoin('interventions', 'students.ic', '=', 'interventions.ic')
            ->leftJoin('results as round2', function($join) {
                $join->on('students.ic', '=', 'round2.ic')
                     ->where('round2.assessment_round', 2);
            })
            ->where('results.status', 2)
            ->where('results.assessment_round', 1)
            ->when($search, function ($query, $search) {
                return $query->where(function($query) use ($search) {
                    $query->where('students.name', 'like', '%' . $search . '%')
                          ->orWhere('students.ic', 'like', '%' . $search . '%')
                          ->orWhere('students.class', 'like', '%' . $search . '%');
                });
            })
            ->get([
                'students.ic',
                'students.name',
                'students.class',
                'results.created_at',
                'results.marks_d',
                'results.marks_a',
                'results.marks_s',
                'interventions.intervention_appt',
                'interventions.sec_assessment_approval',
                'round2.status as round2_status'
            ]);
    
        return view('counsellor.intervention', ['interventionStudents' => $interventionStudents, 'search' => $search]);
    }    

    public function updateInterventionDate(Request $request)
    {
        Log::info('Request data:', $request->all());
    
        try {
            $ic = $request->input('ic');
            $interventionAppt = $request->input('intervention_appt');
    
            $request->validate([
                'ic' => 'required|string|exists:students,ic',
                'intervention_appt' => 'required|date|after_or_equal:now',
            ]);
    
            $result = Result::where('ic', $ic)->first();
            if ($result) {
                // Update or create the intervention record
                $intervention = Intervention::updateOrCreate(
                    ['ic' => $ic],
                    ['intervention_appt' => $interventionAppt]
                );
    
                Log::info('Intervention data:', $intervention->toArray());
    
                $student = $result->student;
                if ($student) {
                    $counsellorName = auth()->user()->name; // Assuming the counsellor is the logged-in user
                    Mail::to($student->email)->send(new InterventionAppointmentMail($student->name, $interventionAppt, $counsellorName));
                    Log::info('Email sent to:', ['email' => $student->email]);
                } else {
                    Log::warning('Student not found for IC:', ['ic' => $ic]);
                }
    
                return response()->json(['message' => 'Intervention date updated and email sent successfully.']);
            }
    
            return response()->json(['message' => 'Student not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating intervention date:', ['exception' => $e]);
            return response()->json(['message' => 'Error updating intervention date.'], 500);
        }
    }    

    public function updateAllowSecondAssessment(Request $request)
    {
        try {
            $ic = $request->input('ic');
            $sec_assessment_approval = $request->input('sec_assessment_approval');

            $result = Result::where('ic', $ic)->first();
            if ($result) {
                Intervention::updateOrCreate(
                    ['ic' => $ic],
                    ['sec_assessment_approval' => $sec_assessment_approval]
                );

                return response()->json(['message' => 'Second assessment approval updated successfully.']);
            }
            return response()->json(['message' => 'Student not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating second assessment approval.'], 500);
        }
    }

    public function secondPassed(Request $request)
    {
        $search = $request->input('search');
    
        $secondPassedStudents = Result::join('students', 'results.ic', '=', 'students.ic')
            ->where('results.status', 1)
            ->where('results.assessment_round', 2)
            ->when($search, function ($query, $search) {
                return $query->where(function($query) use ($search) {
                    $query->where('students.name', 'like', '%' . $search . '%')
                          ->orWhere('students.ic', 'like', '%' . $search . '%')
                          ->orWhere('students.class', 'like', '%' . $search . '%');
                });
            })
            ->get([
                'students.ic',
                'students.name',
                'students.class',
                'results.created_at as second_created_at',
                'results.marks_d as second_marks_d',
                'results.marks_a as second_marks_a',
                'results.marks_s as second_marks_s',
            ]);
    
        // Fetch the first assessment marks for each student
        foreach ($secondPassedStudents as $student) {
            $firstAssessment = Result::where('ic', $student->ic)
                ->where('assessment_round', 1)
                ->first(['marks_d as first_marks_d', 'marks_a as first_marks_a', 'marks_s as first_marks_s']);
    
            $student->first_marks_d = $firstAssessment->first_marks_d ?? null;
            $student->first_marks_a = $firstAssessment->first_marks_a ?? null;
            $student->first_marks_s = $firstAssessment->first_marks_s ?? null;
        }
    
        return view('counsellor.second-passed', ['secondPassedStudents' => $secondPassedStudents, 'search' => $search]);
    }    

    public function secondIntervention(Request $request)
    {
        $search = $request->input('search');
    
        $secondInterventionStudents = Result::join('students', 'results.ic', '=', 'students.ic')
            ->where('results.status', 2)
            ->where('results.assessment_round', 2)
            ->when($search, function ($query, $search) {
                return $query->where(function($query) use ($search) {
                    $query->where('students.name', 'like', '%' . $search . '%')
                          ->orWhere('students.ic', 'like', '%' . $search . '%')
                          ->orWhere('students.class', 'like', '%' . $search . '%');
                });
            })
            ->get([
                'students.ic',
                'students.name',
                'students.class',
                'results.created_at as second_created_at',
                'results.marks_d as second_marks_d',
                'results.marks_a as second_marks_a',
                'results.marks_s as second_marks_s',
            ]);
    
        // Fetch the first assessment marks for each student
        foreach ($secondInterventionStudents as $student) {
            $firstAssessment = Result::where('ic', $student->ic)
                ->where('assessment_round', 1)
                ->first(['marks_d as first_marks_d', 'marks_a as first_marks_a', 'marks_s as first_marks_s']);
    
            $student->first_marks_d = $firstAssessment->first_marks_d ?? null;
            $student->first_marks_a = $firstAssessment->first_marks_a ?? null;
            $student->first_marks_s = $firstAssessment->first_marks_s ?? null;
        }
    
        return view('counsellor.second-intervention', ['secondInterventionStudents' => $secondInterventionStudents, 'search' => $search]);
    }    

    public function selectPsychologist($studentIc)
    {
        $student = Student::where('ic', $studentIc)->firstOrFail(); // Fetch student by IC
        $psychologists = Psychologist::all();

        return view('counsellor.select-psychologist', [
            'student_name' => $student->name, // Pass student's name to the view
            'student_ic' => $studentIc,
            'psychologists' => $psychologists,
        ]);
    }

    public function generatePdf(Request $request)
    {
        $studentIc = $request->input('student_ic');
        $psychologistId = $request->input('psychologist_id');
        $customMessage = $request->input('customMessage');
    
        $student = Student::where('ic', $studentIc)->first();
        $psychologist = Psychologist::find($psychologistId);
    
        // Fetch the counsellor's details (assuming the logged-in user is the counsellor)
        $counsellor = auth()->user();
    
        // Fetch first and second assessment marks
        $firstAssessment = Result::where('ic', $studentIc)
            ->where('assessment_round', 1)
            ->first(['marks_d as first_marks_d', 'marks_a as first_marks_a', 'marks_s as first_marks_s']);
    
        $secondAssessment = Result::where('ic', $studentIc)
            ->where('assessment_round', 2)
            ->first(['marks_d as second_marks_d', 'marks_a as second_marks_a', 'marks_s as second_marks_s']);
    
        $data = [
            'student' => $student,
            'psychologist' => $psychologist,
            'date' => now()->format('d M Y'),
            'counsellor' => $counsellor,
            'customMessage' => $customMessage,
            'firstAssessment' => $firstAssessment,
            'secondAssessment' => $secondAssessment,
        ];
    
        $pdf = PDF::loadView('pdf.letter', $data);
    
        $filename = $student->name . ' intervention letter.pdf';
    
        return $pdf->download($filename);
    }     

}
