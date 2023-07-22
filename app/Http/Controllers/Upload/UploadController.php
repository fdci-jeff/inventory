<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function dropzoneUpload(Request $request) {
        $file = $request->file('file');
        
        $filename = now()->timestamp . '.' . trim($file->getClientOriginalExtension());

        Storage::disk('public')->putFileAs('temp/dropzone/', $file, $filename);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function dropzoneDelete(Request $request) {
        Storage::disk('public')->delete('temp/dropzone/' . $request->name);

        return response()->json($request->name, 200);
    }
}
