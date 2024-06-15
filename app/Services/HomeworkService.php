<?php

namespace App\Services;

use App\Jobs\ProcessTelegram;
use App\Models\Homework;
use App\Models\HomeworkFile;
use App\Models\Note;
use App\Models\NoteFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;


class HomeworkService
{

    public function __construct() {

    }

    public function store(array $data, Validator $validator): bool
    {
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
            return false;
        }
        DB::commit();
        ProcessTelegram::dispatch($homework->user->tg_id, 'homework', $homework->title);
        return true;
    }
}
