<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    public function __invoke(Request $request): Response {
        $schedules = $request->user()->schedules()->whereDate('scheduled_at', '>', now())->paginate(10);
        return Inertia::render('User/Schedule', compact('schedules'));
    }
}
