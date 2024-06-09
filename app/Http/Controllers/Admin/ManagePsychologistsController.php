<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Image;

class ManagePsychologistsController extends Controller
{

    public function getPsychologistList(Request $request)
    {
        $query = Psychologist::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('qualifications', 'LIKE', "%{$search}%")
                ->orWhere('specialization', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhere('availability', 'LIKE', "%{$search}%");
            });
        }
    
        $psychologists = $query->latest()->paginate(5);
    
        // Format phone numbers
        $psychologists->getCollection()->transform(function ($psychologist) {
            $psychologist->phone = preg_replace('/(\d{3})(\d+)/', '$1-$2', $psychologist->phone);
            return $psychologist;
        });
    
        return view('admin.manage_psychologists', compact('psychologists'));
    }    
   
    public function getPsychologistForm()
    {
        return view('admin.psychologist-form');
    }

    public function postAddPsychologist(Request $request)
    {
        $this->validate($request, [
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => ['nullable', 'regex:/^0?\d{9,10}$/'],
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
        ]);

        // Handle file upload if an icon file is provided
        if ($request->hasFile('icon')) {
            $imageName = time() . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(public_path('images/psychologists'), $imageName);
        } else {
            $imageName = null; // Set default image name to null if no file uploaded
        }

        // Create a new Psychologist instance
        $psychologist = Psychologist::create([
            'icon' => $imageName,
            'name' => $request['name'],
            'qualifications' => $request['qualifications'],
            'specialization' => $request['specialization'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'location' => $request['location'],
            'availability' => $request['availability'],
        ]);

        session()->flash('message', 'Psychologist added successfully!');

        return redirect()->route('admin.manage_psychologists');
    }

    public function getEditPsychologist($id)
    {
        $psychologist = Psychologist::find($id);

        if (!$psychologist) {
            return redirect()->route('admin.manage_psychologists')->with('error', 'Psychologist not found');
        }

        return view('admin.edit-psychologist-form', compact('psychologist'));
    }

    public function putEditPsychologist(Request $request, $id)
    {
        $this->validate($request, [
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => ['nullable', 'regex:/^0?\d{9,10}$/'],
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
        ]);
    
        $psychologist = Psychologist::find($id);
    
        if (!$psychologist) {
            return redirect()->route('admin.manage_psychologists')->with('error', 'Psychologist not found');
        }
    
        // Handle file upload if a new image is provided
        if ($request->hasFile('icon')) {
            $psychologistIcon = $request->file('icon');
            $imageName = 'psychologist_icon' . time() . '.' . $psychologistIcon->getClientOriginalExtension();

            // Ensure the directory exists
            $path = public_path('images/psychologists');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Resize and save the image using GD
            $image = imagecreatefromstring(file_get_contents($psychologistIcon->getPathname()));
            $resizedImage = imagescale($image, 300, 300);
            imagejpeg($resizedImage, $path . '/' . $imageName);

            // Free up memory
            imagedestroy($image);
            imagedestroy($resizedImage);

            // Delete the old image if exists
            if ($psychologist->icon && File::exists($path . '/' . $psychologist->icon)) {
                File::delete($path . '/' . $psychologist->icon);
            }

            $psychologist->icon = $imageName;
        }
    
        $psychologist->name = $request['name'];
        $psychologist->qualifications = $request['qualifications'];
        $psychologist->specialization = $request['specialization'];
        $psychologist->email = $request['email'];
        $psychologist->phone = $request['phone'];
        $psychologist->location = $request['location'];
        $psychologist->availability = $request['availability'];
        $psychologist->updated_at = now();
    
        $psychologist->save();
    
        session()->flash('message', 'Psychologist updated successfully!');
    
        return redirect()->route('admin.manage_psychologists');
    }    

    public function deletePsychologist($id)
    {
        $psychologist = Psychologist::find($id);

        if ($psychologist) {
            $path = public_path('images/psychologists');
            if (File::exists($path . '/' . $psychologist->icon)) {
                File::delete($path . '/' . $psychologist->icon);
            }
            $psychologist->delete();
            session()->flash('message', 'Psychologist has been successfully deleted');
        } else {
            session()->flash('error', 'Psychologist not found');
        }

        return redirect()->route('admin.manage_psychologists');
    }
}
