<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function handleImageUpload(Request $request, $currentImage = null, $directory = 'default_directory')
    {
        
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($currentImage) {
                Storage::delete($directory . '/' . $currentImage);
            }

            // Generate a unique filename
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFilename = Str::uuid() . '.' . $extension;

            // Store the new image
            $request->file('image')->storeAs($directory, $uniqueFilename);
            
            return $uniqueFilename;
        }

        return $currentImage;
    }
}
