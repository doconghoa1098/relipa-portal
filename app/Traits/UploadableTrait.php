<?php

namespace App\Traits;

trait UploadableTrait

{
    protected function upload($model, $file, $request)
    {
        if ($request->has($file)) {
            $avatar = uniqid() .'-'. $request->$file->getClientOriginalName();
            $request->file($file)->storeAs( 'public/uploads/members', $avatar );
        } else {
            $avatar = $model->$file;
        }

        return $avatar;
    }
}
