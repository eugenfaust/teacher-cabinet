<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeworkController extends Controller
{
    public function __invoke(Request $request): Response {
        $homeworks = $request->user()->homeworks()->orderByDesc('created_at')->paginate(10);
        return Inertia::render('User/Homework', compact('homeworks' ));
    }
}
