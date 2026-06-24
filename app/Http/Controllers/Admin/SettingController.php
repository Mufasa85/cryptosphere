<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        $defaults = [
            'default_interest_rate' => '12',
            'max_loan_duration' => '24',
            'currency' => 'CDF',
        ];

        return view('admin.settings.system', compact('settings', 'defaults'));
    }

    public function update(Request $request)
    {
        $data = $request->input('settings', []);

        foreach ($data as $key => $value) {
            SystemSetting::setValue($key, $value, 'general', $key);
        }

        ActivityLog::record('settings.updated', null, 'Paramètres système mis à jour');

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
