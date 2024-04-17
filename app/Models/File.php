<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $guarded = false;
    protected $table = 'files';

    public static function putAndCreate($data){

        $file = Storage::disk('public')->put('files/', $data['file']);

     File::create([
            'path' => $file,
            'mime_type' => $data['file']->getClientOriginalExtension(),
            'title' => $data['file']->getClientOriginalName()
        ]);

     return $file;
    }
}
