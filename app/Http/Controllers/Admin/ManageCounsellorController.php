<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ManageCounsellorController extends Controller
{

    public function getCounsellorList(Request $request)
    {
        $query = User::where('role', 'counsellor');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('ic', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
    
        $counsellors = $query->latest()->paginate(5);
    
        return view('admin.manage-counsellors', compact('counsellors'));
    }    

    public function getCounsellorForm()
    {
        return view('admin.counsellor-form');
    }

    public function postAddCounsellor(Request $request)
    {
        try {
            $this->validate($request, [
                'ic' => 'required|string|digits:12|unique:users',
                'password' => 'required|string|max:255',
                'name' => 'required|string|max:255|regex:/^[A-Za-z\s@]+$/',
                'email' => 'required|email|max:255|unique:users',
            ]);

            $counsellor = new User($request->all());
            $counsellor->password = bcrypt($request['password']);
            $counsellor->role = 'counsellor';
            $counsellor->pass_status = 0;
            $counsellor->save();

            session()->flash('message', 'Counsellor added successfully!');
            return redirect()->route('admin.manage-counsellors');
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                return redirect()->route('admin.counsellor-form')->with('error', 'Counsellor with this IC or email already exists.')->withInput();
            } else {
                return redirect()->route('admin.manage-counsellors')->with('error', 'An error occurred while adding the Counsellor.');
            }
        }
    }

    public function getEditCounsellor($ic)
    {
        $counsellor = User::where('ic', $ic)->firstOrFail();
        return view('admin.edit-counsellor-form', compact('counsellor'));
    }

    public function putEditCounsellor(Request $request, $ic)
    {
        $this->validate($request, [
            'ic' => 'required|string|digits:12',
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s@]+$/',
            'email' => 'required|email|max:255|unique:users,email,' . $ic . ',ic',
        ]);

        $counsellor = User::where('ic', $ic)->firstOrFail();
        $counsellor->update($request->all());

        session()->flash('message', 'Counsellor updated successfully!');
        return redirect()->route('admin.manage-counsellors');
    }

    public function deleteCounsellor(string $ic)
    {
        $counsellor = User::where('ic', $ic)->first();
    
        if ($counsellor) {
            $counsellor->delete();
            session()->flash('message', 'Counsellor has been successfully deleted');
        } else {
            session()->flash('error', 'Counsellor not found');
        }
    
        return redirect()->route('admin.manage-counsellors');
    }
}
