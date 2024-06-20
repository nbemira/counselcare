<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Database\QueryException;

class ManageStudentController extends Controller
{
    public function getStudentList(Request $request)
    {
        $search = $request->get('search', '');

        $students = Student::query();

        if (!empty($search)) {
            $students->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('ic', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('class', 'LIKE', "%{$search}%");
            });
        }

        $students = $students->latest()->paginate(50); // Order by creation time in descending order

        return view('admin.manage-students', compact('students'));
    }

    public function getStudentForm()
    {
        return view('admin.student-form');
    }

    public function postAddStudent(Request $request)
    {
        try {
            $this->validate($request, [
                'ic' => 'required|string|digits:12|unique:students',
                'password' => 'required|string|max:255',
                'name' => 'required|string|max:255|regex:/^[a-zA-Z@ ]+$/',
                'email' => 'required|email|max:255|unique:students',
                'class' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
            ]);

            $student = new Student();
            
            $student->password = bcrypt($request['password']);
            $student->ic = $request['ic'];
            $student->name = $request['name'];
            $student->email = $request['email'];
            $student->class = $request['class'];
            $student->gender = $request['gender'];
            $student->pass_status = 0;
            $student->created_at = now();
            $student->updated_at = now();

            $student->save();

            session()->flash('message', 'Student added successfully!');

            return redirect()->route('admin.manage-students');
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                return redirect()->route('admin.student-form')->with('error', 'Student with this IC already exists.')->withInput();
            } else {
                return redirect()->route('admin.manage-students')->with('error', 'An error occurred while adding the Student.')->withInput();
            }
        }
    }

    public function getEditStudent($ic)
    {
        $student = Student::where('ic', $ic)->first();
    
        if (!$student) {
            return redirect()->route('admin.manage-students')->with('error', 'Student not found');
        }
    
        return view('admin.edit-student-form', compact('student'));
    }

    public function putEditStudent(Request $request, $ic)
    {
        $this->validate($request, [
            'ic' => 'required|string|digits:12',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z@ ]+$/',
            'email' => 'required|email|max:255|unique:students,email,' . $ic . ',ic',
            'class' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        $student = Student::find($ic);

        if (!$student) {
            return abort(404, 'Student not found');
        }

        $student->ic = $request['ic'];
        $student->name = $request['name'];
        $student->email = $request['email'];
        $student->class = $request['class'];
        $student->gender = $request['gender'];
        $student->updated_at = now();

        $student->save();

        session()->flash('message', 'Student updated successfully!');

        return redirect()->route('admin.manage-students');
    }

    public function deleteStudent(string $ic)
    {
        $student = Student::find($ic);
        
        if ($student) {
            $student->delete();
            session()->flash('message', 'Student has been successfully deleted');
        } else {
            session()->flash('error', 'Student not found');
        }
    
        // Redirect back to the manage students route
        return redirect()->route('admin.manage-students')->with('reload', true);
    }    
}
