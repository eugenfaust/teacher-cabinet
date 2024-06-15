<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTelegram;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request, User $user): Response
    {
        $schedules = $user->schedules()->whereDate('scheduled_at', '>', now())->paginate(10);
        $closest_schedule = $user->schedules()->whereDate('scheduled_at', '>', now())->first();
        return Inertia::render('Admin/Schedule/Index', compact('user', 'schedules', 'closest_schedule'));
    }

    public function create(Request $request, $id): Response
    {
        return Inertia::render('Admin/Schedule/Create', [
            'id' => $id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'scheduled_at' => ['required', 'date', 'after:today'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        if ($validator->fails()) {
            return to_route('admin.schedule.create', ['id' => $validator->safe()->only('user_id')])->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $schedule = Schedule::create($data);
        ProcessTelegram::dispatch($schedule->user->tg_id, 'schedule', $schedule->scheduled_at->format('H:i d.m.Y'));
        return to_route('admin.schedule.index', ['user' => $data['user_id']]);
    }

    public function destroy(Request $request, Schedule $schedule)
    {
        $schedule->delete();
        return to_route('admin.schedule.index', ['user' => $schedule->user_id]);
    }
}
