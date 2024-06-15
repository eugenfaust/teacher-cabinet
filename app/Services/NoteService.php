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


class NoteService
{

    public function __construct() {

    }

    public function store(array $data, Validator $validator): bool
    {
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
            return false;
        }
        DB::commit();
        ProcessTelegram::dispatch($note->user->tg_id, 'note', $note->title);
        return true;
    }
}
