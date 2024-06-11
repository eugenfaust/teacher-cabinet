<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{
    public function __invoke(Request $request): Response {
        $notes = $request->user()->notes()->orderByDesc('created_at')->paginate(10);

        return Inertia::render('User/Note', compact('notes' ));
    }
}
