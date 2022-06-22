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

    protected function uploadNotice($model, $image, $request)
    {
        if ($request->has($image)) {
            $attachment = uniqid() .'-'. $request->$image->getClientOriginalName();
            $request->file($image)->storeAs( 'public/uploads/notifications', $attachment );
        } else {
            $attachment = $model->$image;
        }

        return $attachment;
    }
}
