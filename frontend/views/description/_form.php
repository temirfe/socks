<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use frontend\models\Category;
use frontend\models\Destination;

/* @var $this yii\web\View */
/* @var $model frontend\models\Description */
/* @var $form yii\widgets\ActiveForm */
if($ctg=Yii::$app->request->get('category_id')){
    $model->category_id=$ctg;
}
?>

<div class="description-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getList()) ?>
    <?= $form->field($model, 'destination_id')->dropDownList(Destination::getList()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php // $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    $model_name='description';

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

    <div class="form_wrap wrap_ru">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ru">
            <img src="/images/blank.gif" class="flag flag-ru" alt="Russian" />
            <span class="dotted_link arrow_toggle">Text in Russian</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ru">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
            <?php //echo $form->field($model, 'intro_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>
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
            <?= $form->field($model, 'description_ko')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
