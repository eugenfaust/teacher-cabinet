<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTelegram;
use App\Models\Homework;
use App\Models\HomeworkFile;
use App\Models\User;
use App\Services\HomeworkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class HomeworkController extends Controller
{

    private HomeworkService $service;
    public function __construct(HomeworkService $service)
    {
        $this->service = $service;
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
        if ($this->service->store($data, $validator)) {
            return to_route('admin.homework.index', ['user' => $data['user_id']]);
        } else {
            return to_route('admin.homework.create', ['id' => $data['user_id']])->withErrors($validator);
        }
    }

    public function destroy(Request $request, Homework $homework): RedirectResponse
    {
        $homework->delete();
        return to_route('admin.homework.index', ['user' => $homework->user_id]);
    }
}
