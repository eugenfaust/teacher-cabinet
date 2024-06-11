<?php

namespace App\Http\Controllers\FileController;

use App\Http\Controllers\Controller;
use App\Models\HomeworkFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeworkController extends Controller
{
    public function __invoke(Request $request, $file_id): StreamedResponse {
        $file = HomeworkFile::find($file_id);
        return Storage::download($file->path, $file->original_name);
    }
}
