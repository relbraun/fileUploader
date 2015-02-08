<?php

/**
 * This is the model class for table "Attachments".
 *
 * The followings are the available columns in table 'Attachments':
 * @property integer $id
 * @property string $model_name
 * @property integer $model_id
 * @property string $path
 * @property string $date_add
 * @property string $date_modify
 * @property integer $user_upload
 * @property integer $user_modify
 */
class Attachment extends CActiveRecord
{
    public $_files;

    private $module = 'FileUploaderModule';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Attachments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_name, model_id, path, date_add, date_modify, user_upload, user_modify', 'required'),
			array('model_id, user_upload, user_modify', 'numerical', 'integerOnly'=>true),
			array('model_name', 'length', 'max'=>50),
			array('path', 'length', 'max'=>255),
            array('_files', 'file'),
            //array('_files', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_name, model_id, path, date_add, date_modify, user_upload, user_modify', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model_name' => 'Model Name',
			'model_id' => 'Model',
			'path' => 'Path',
			'date_add' => 'Date Add',
			'date_modify' => 'Date Modify',
			'user_upload' => 'User Upload',
			'user_modify' => 'User Modify',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_modify',$this->date_modify,true);
		$criteria->compare('user_upload',$this->user_upload);
		$criteria->compare('user_modify',$this->user_modify);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @throws CException
     */
    public function makePath()
    {
        if(!isset($this->model_name) || !isset($this->model_id)){
            throw new CException('I don\'t know where to save the files');
        }
        $upload_dir = $this->module;
        $upload_dir = $upload_dir::$upload_path;
        $upload_dir .= '/' . date('Y') . '/';
        if(!file_exists($upload_dir)){
            @mkdir($upload_dir);
        }
        $upload_dir .= $this->model_name;
        if(!file_exists($upload_dir)){
            @mkdir($upload_dir);
        }
    }

    public function getAttachmentUrl()
    {
        $upload_dir = $this->module;
        $upload_dir = $upload_dir::$upload_path;
        $path = str_replace(Yii::app()->basePath,'',$this->path);
        return '//' . $path;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeValidate()
    {
        if($this->isNewRecord){
            $this->date_add = new CDbExpression('NOW()');
            $this->user_upload = Yii::app()->user->id;
        }
        $this->date_modify = new CDbExpression('NOW()');
        $this->user_modify = Yii::app()->user->id;
    }
}
