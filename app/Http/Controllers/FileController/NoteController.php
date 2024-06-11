<?php

namespace App\Http\Controllers\FileController;

use App\Http\Controllers\Controller;
use App\Models\HomeworkFile;
use App\Models\NoteFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NoteController extends Controller
{
    public function __invoke(Request $request, $file_id): StreamedResponse {
        $file = NoteFile::find($file_id);
        return Storage::download($file->path, $file->original_name);
    }
}
