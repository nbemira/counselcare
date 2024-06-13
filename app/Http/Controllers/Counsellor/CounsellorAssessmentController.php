<?php

namespace App\Http\Controllers\Counsellor;

use App\Models\Question;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CounsellorAssessmentController extends Controller
{

    public function getQuestionList()
    {
        $questions = Question::all();
        $setting = Setting::firstOrNew([]);
        $assessmentEnabled = $setting->assessment_enabled ?? false;
        
        return view('counsellor.assessment', compact('questions', 'assessmentEnabled'));
    }

    public function getQuestionForm()
    {
        return view('counsellor.add-question');
    }

    public function postAddQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'category' => 'required|in:1,2,3',
        ]);

        $question = new Question();
        $question->question = $request->question;
        $question->category_id = $request->category;
        $question->save();

        return redirect()->route('counsellor.assessment')->with('message', 'Question added successfully.');
    }

    public function getEditQuestion(Question $question)
    {
        return view('counsellor.edit-question', compact('question'));
    }

    public function putEditQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required',
            'category' => 'required|in:1,2,3',
        ]);

        $question->question = $request->question;
        $question->category_id = $request->category;
        $question->save();

        return redirect()->route('counsellor.assessment')->with('message', 'Question updated successfully.');
    }

    public function deleteQuestion(Question $question)
    {
        $question->delete();

        return redirect()->back()->with('message', 'Question deleted successfully.');
    }

    public function toggleAssessment()
    {
        $setting = Setting::firstOrNew([]);
        $setting->assessment_enabled = !$setting->assessment_enabled;
        $setting->save();

        return response()->json(['enabled' => $setting->assessment_enabled]);
    }

}
