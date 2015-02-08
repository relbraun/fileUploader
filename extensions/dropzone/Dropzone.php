<?php

class Dropzone extends CInputWidget
{
    const DOMAIN='Dropzone';

    public function init()
    {
        $assets = Yii::app()->assetManager->publish(__DIR__);
        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/dropzone.js');
        $cs->registerCssFile($assets . '/dropzone.css');
    }

    public function run()
    {
        $url = $this->controller->createUrl("{$this->controller->id}/ajaxUpload");
        $id=get_class($this->model) . '-' . $this->attribute;
        $script = '$(\'#'.$id.'\').dropzone({ url: "'.$url.'", paramName: "'.get_class($this->model).'['.$this->attribute.']"});';
        Yii::app()->clientScript->registerScript(__FILE__, $script);
        echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#dz-modal">'.
                    Yii::t(self::DOMAIN,'Upload Files')
                .'</button>';
        echo '<!-- Modal -->
<div class="modal fade" id="dz-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">'.Yii::t(self::DOMAIN,'Upload Files').'</h4>
      </div>
      <div class="modal-body" id="'.$id.'">
          <h3>'.Yii::t(self::DOMAIN,'Drop Files Here.').'</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">'.Yii::t(self::DOMAIN,'Close').'</button>
      </div>
    </div>
  </div>
</div>';
       // echo CHtml::activeFileField($this->model, $this->attribute, $this->htmlOptions);
    }
}