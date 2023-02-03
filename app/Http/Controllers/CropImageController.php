<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CropImageController extends Controller
{
    public function index()
    {
        return view('crop-image-upload');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cropImageUploadAjax(Request $request)
    {
        $folderPath = public_path('images/profile/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);
        User::where('id', auth()->user()->id)->update(['image' => $imageName]);
        

        return response()->json(['success'=>'Crop Image Uploaded Successfully']);
        return $imageFullPath;

        //  $saveFile = new CropImage;
        //  $saveFile->name = $imageName;
        //  $saveFile->save();

    }
}
