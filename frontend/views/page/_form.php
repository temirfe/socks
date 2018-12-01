<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropDownList(['main' =>'main','about_us'=>'about us','contacts'=>'contacts']) ?>

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
    $model_name='page';

    $initialPreviewConfig =[];
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/".$model_name."/".$model->id."/s_".$main_img, ['class'=>'file-preview-image img-responsive', 'alt'=>''])];
        $url=Url::to(['img-delete', 'id' => $model->id, 'model_name'=>$model_name]);
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
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
