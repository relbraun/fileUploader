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
            $path = $attachment->getFullPath() . $file->name;
            if ($file->saveAs($path)) {
                $attachment->path = $attachment->getFileDir() . $file->name;
                $attachment->save();
            }
        }
    }

    public function actionIndex()
    {
        $attachment = Attachment::model()->findByPk(1);
        //var_dump($this->module->upload_path);
        var_dump($attachment->getAttachmentUrl());
    }


}