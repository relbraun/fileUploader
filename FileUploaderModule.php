<?php

class FileUploaderModule extends CWebModule
{

    public static $upload_path;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'fileUploader.models.*',
			'fileUploader.components.*',
		));

        if(!self::$upload_path){
            self::$upload_path = __DIR__ . '/../uploads';
        }
        if(!file_exists(self::$upload_path)){
            @mkdir(self::$upload_path);
        }

	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
