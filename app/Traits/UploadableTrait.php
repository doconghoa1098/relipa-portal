<?php

namespace App\Traits;

trait UploadableTrait

{
    protected function upload($model, $file, $request)
    {
        if ($request->has($file)) {
            $image = $request->file($file)->storeAs( 'public/uploads/members', uniqid() . $request->$file->getClientOriginalName() );
            $avatar = uniqid() .'-'. $request->$file->getClientOriginalName();
        } else {
            $avatar = $model->$file;
        }

        return $avatar;
    }
}
