<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\ActivityLog;

class ActivityLogController extends AdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $query = ActivityLog::query();

        $query->orderBy('id', 'desc');

        $activity_logs = $query->paginate(50);

        return view('pages.admin.log.activity', ['activity_logs' => $activity_logs]);
    }
}
