<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\NoteFile;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{

    private $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
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
        $uploaded_files = $data['files'];
        unset($data['files']);
        DB::beginTransaction();
        $note = Note::create($data);
        try {
            foreach ($uploaded_files as $file) {
                $path = $file->store('documents');
                NoteFile::create(['original_name' => $file->getClientOriginalName(), 'path' => $path, 'note_id' => $note->id]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $validator->errors()->add('files', 'Загружамые файлы повреждены или неверный формат');
            return to_route('admin.note.create', ['id' => $data['user_id']])->withErrors($validator);
        }
        DB::commit();
        $this->telegram->sendNotesNotify($note->user->tg_id, $note->title);
        return to_route('admin.note.index', ['user' => $data['user_id']]);
    }

    public function destroy(Request $request, Note $note)
    {
        $note->delete();
        return to_route('admin.note.index', ['user' => $note->user_id]);
    }
}
