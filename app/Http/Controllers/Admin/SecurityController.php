<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LoginHistory;

class SecurityController extends Controller
{
    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(25);

        return view('admin.security.activity_logs', compact('logs'));
    }

    public function loginHistories()
    {
        $histories = LoginHistory::with('user')->latest()->paginate(25);

        return view('admin.security.login_histories', compact('histories'));
    }
}
