<?php

class DefaultController extends Controller
{
    public function actionUpload($model, $id)
    {
        $attachment = new Attachment();
        $attachment->model_name = $model;
        $attachment->model_id = $id;

        $files = CUploadedFile::getInstances($attachment, '_files');
        foreach ($files as $file) {
            $path = $attachment->makePath() . '/' . $file->name;
            if ($file->saveAs($path)) {
                $attachment->path = $path;
                $attachment->save();
            }
        }

        //$this->render('index');
    }


}