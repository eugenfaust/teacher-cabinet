<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkFile;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class HomeworkController extends Controller
{
    private $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function index(Request $request, User $user): Response
    {
        $homeworks = $user->homeworks()->paginate(10);
        return Inertia::render('Admin/Homework/Index', compact('user', 'homeworks'));
    }

    public function create(Request $request, $id): Response
    {
        return Inertia::render('Admin/Homework/Create', [
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
        $homework = Homework::create($data);
        try {
            foreach ($uploaded_files as $file) {
                $path = $file->store('documents');
                HomeworkFile::create(['original_name' => $file->getClientOriginalName(), 'path' => $path, 'homework_id' => $homework->id]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $validator->errors()->add('files', 'Загружамые файлы повреждены или неверный формат');
            return to_route('admin.homework.create', ['id' => $data['user_id']])->withErrors($validator);
        }
        DB::commit();
        $this->telegram->sendHomeworkNotify($homework->user->tg_id, $homework->title);
        return to_route('admin.homework.index', ['user' => $data['user_id']]);
    }

    public function destroy(Request $request, Homework $homework)
    {
        $homework->delete();
        return to_route('admin.homework.index', ['user' => $homework->user_id]);
    }
}
