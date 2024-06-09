<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Intervention;
use Illuminate\Http\Request;

class CounsellorController extends Controller
{
    public function dashboard()
    {
        $totalDepression = Result::where('marks_d', '>', 7)->distinct('ic')->count('ic');
        $totalAnxiety = Result::where('marks_a', '>', 6)->distinct('ic')->count('ic');
        $totalStress = Result::where('marks_s', '>', 9)->distinct('ic')->count('ic');
        $totalStudents = Student::count();
        $totalAssessedStudents = Result::distinct('ic')->count('ic');

        $totalDepressionSettled = Result::where('marks_d', '<', 8)
            ->where('assessment_round', 2)
            ->distinct('ic')
            ->count('ic');

        $totalAnxietySettled = Result::where('marks_a', '<', 7)
            ->where('assessment_round', 2)
            ->distinct('ic')
            ->count('ic');

        $totalStressSettled = Result::where('marks_s', '<', 10)
            ->where('assessment_round', 2)
            ->distinct('ic')
            ->count('ic');

        $unansweredStudents = Student::whereNotIn('ic', Result::pluck('ic'))->count();

        $studentsSecondIntervention = Result::where('status', 2)
            ->where('assessment_round', 2)
            ->distinct('ic')
            ->count('ic');

        $pendingInterventionAppointment = Result::where('assessment_round', 1)
            ->where('status', 2)
            ->whereNotIn('ic', Intervention::pluck('ic'))
            ->count();

        $pendingSecondAssessment = Intervention::where('sec_assessment_approval', 1)
            ->whereNotIn('ic', Result::where('assessment_round', 2)->pluck('ic'))
            ->count();

        return view('counsellor.dashboard', compact(
            'totalDepression',
            'totalAnxiety',
            'totalStress',
            'totalStudents',
            'totalAssessedStudents',
            'totalDepressionSettled',
            'totalAnxietySettled',
            'totalStressSettled',
            'unansweredStudents',
            'studentsSecondIntervention',
            'pendingInterventionAppointment',
            'pendingSecondAssessment'
        ));
    }

    public function case()
    {
        return view('counsellor.case-management');
    }

    public function screeningScoreReference()
    {
        return view('counsellor.screening-score-reference');
    }
}
