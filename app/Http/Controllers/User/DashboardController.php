<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response {
        $scheduled = $request->user()->schedules()->orderBy('scheduled_at')->first();
        $homeworks = $request->user()->homeworks()->orderByDesc('created_at')->limit(5)->get();
        $notes = $request->user()->notes()->orderByDesc('created_at')->limit(5)->get();

        return Inertia::render('User/Dashboard', compact('scheduled', 'homeworks', 'notes'));
    }
}
