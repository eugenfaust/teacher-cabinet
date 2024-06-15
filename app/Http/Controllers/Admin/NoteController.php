<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTelegram;
use App\Models\Note;
use App\Models\NoteFile;
use App\Models\User;
use App\Services\NoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{

    private NoteService $service;
    public function __construct(NoteService $noteService)
    {
        $this->service = $noteService;
    }

    public function index(Request $request, User $user): Response
    {
        $notes = $user->notes()->paginate(10);
        return Inertia::render('Admin/Note/Index', compact('user', 'notes'));
    }

    public function create(Request $request, $id): Response
    {
        return Inertia::render('Admin/Note/Create', [
            'id' => $id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'files' =>
                'required|max:10000',
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        if ($this->service->store($data, $validator)) {
            return to_route('admin.note.index', ['user' => $data['user_id']]);
        } else {
            return to_route('admin.note.create', ['id' => $data['user_id']])->withErrors($validator);
        }
    }

    public function destroy(Request $request, Note $note)
    {
        $note->delete();
        return to_route('admin.note.index', ['user' => $note->user_id]);
    }
}
