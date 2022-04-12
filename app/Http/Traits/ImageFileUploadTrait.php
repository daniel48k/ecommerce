<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageFileUploadTrait
{

    public function saveFile(Request $request, $key_name, $path)
    {
        if (!$request->hasFile($key_name)) return '';
        $name = time() . $request->file($key_name)->getClientOriginalName();

        $filenameStore1 = time() . '.' . $name;
        $request->file($key_name)->move($path, $filenameStore1);
        return $path . '/' . $filenameStore1;
    }

    public function deleteFile($path)
    {
        Storage::delete($path);
        return true;
    }

}
