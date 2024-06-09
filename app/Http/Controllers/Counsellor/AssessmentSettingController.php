<?php

namespace App\Http\Controllers\Counsellor;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentSettingController extends Controller
{
    public function toggleAssessment()
    {
        $setting = Setting::firstOrNew([]);
        $setting->assessment_enabled = !$setting->assessment_enabled;
        $setting->save();

        return response()->json(['enabled' => $setting->assessment_enabled]);
    }
}
