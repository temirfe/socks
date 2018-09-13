<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destination-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            //'maxHeight' => 400,
            'imageUpload' => Url::to(['/site/editor-upload']),
            'imageManagerJson' => Url::to(['/site/editor-browse']),
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'table',
            ],
        ],
    ]); ?>

    <?php
    $model_name='destination';
    $url = Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>$model_name]);

    /*$initialPreviewConfig =[];
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/".$model_name."/".$model->id."/s_".$main_img, ['class'=>'file-preview-image img-responsive', 'alt'=>''])];
        $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>$model_name]);
        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => "s_".$main_img];
    }
    else {
        $iniImg=false;
    }
    echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'initialPreview'=>$iniImg,
            'previewFileType' => 'any',
            'initialPreviewConfig' => $initialPreviewConfig,
            'style'=>'height:200px;'
        ],
    ]);*/

    //secondary images
    $iniImg2=false;
    $initialPreviewConfig2=[];
    if(!$model->isNewRecord) {
        if($model->images && is_dir("images/{$model_name}/".$model->id)){
            /*$imgs=scandir("images/{$model_name}/".$model->id);
            foreach($imgs as $img){
                if($img!='.' && $img!='..'){
                    if(strpos($img,'s_' )!== false)
                    {
                        $iniImg2[]=Html::img("@web/images/{$model_name}/".$model->id."/".$img, ['class'=>'file-preview-image img-responsive', 'alt'=>'']);
                        $initialPreviewConfig2[] = ['width' => '80px', 'url' => $url, 'key' => $img, 'model_name'=>$model_name,'model_id'=>$model->id];
                    }
                }
            }*/
            $imgs=explode(';',$model->images);
            foreach($imgs as $img){
                $iniImg2[]=Html::img("@web/images/{$model_name}/".$model->id."/s_".$img, ['class'=>'file-preview-image img-responsive', 'alt'=>'']);
                $initialPreviewConfig2[] = ['width' => '80px', 'url' => $url, 'key' => $img, 'model_name'=>$model_name,'model_id'=>$model->id];
            }
        }
    }
    echo $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*','multiple'=>true],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'overwriteInitial'=>false,
            'initialPreview'=>$iniImg2,
            'previewFileType' => 'any',
            'initialPreviewConfig' => $initialPreviewConfig2,

        ],
        'pluginEvents' => [
            "filesorted" => "imgSorted",
        ],
    ]);
    ?>

    <div class="form_wrap wrap_ru">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ru">
            <img src="/images/blank.gif" class="flag flag-ru" alt="Russian" />
            <span class="dotted_link arrow_toggle">Text in Russian</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ru">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

            <?php //echo $form->field($model, 'intro_ru')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'text_ru')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    //'maxHeight' => 400,
                    'imageUpload' => Url::to(['/site/editor-upload']),
                    'imageManagerJson' => Url::to(['/site/editor-browse']),
                    'plugins' => [
                        'clips',
                        'fullscreen',
                        'imagemanager',
                        'table',
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <div class="form_wrap wrap_ko">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ko">
            <img src="/images/blank.gif" class="flag flag-kr" alt="Korean" />
            <span class="dotted_link arrow_toggle">Text in Korean</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ko">
            <?= $form->field($model, 'title_ko')->textInput(['maxlength' => true]) ?>

            <?php //echo $form->field($model, 'intro_ko')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'text_ko')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    //'maxHeight' => 400,
                    'imageUpload' => Url::to(['/site/editor-upload']),
                    'imageManagerJson' => Url::to(['/site/editor-browse']),
                    'plugins' => [
                        'clips',
                        'fullscreen',
                        'imagemanager',
                        'table',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
