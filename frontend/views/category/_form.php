<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */
/* @var $form yii\widgets\ActiveForm */
$rows=Yii::$app->db->createCommand("SELECT id, title FROM category WHERE parent_id IS NULL")->queryAll();
$ctg=ArrayHelper::map($rows,'id','title');
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <?=$form->field($model, "parent_id")->dropDownList($ctg,['prompt'=>Yii::t('app','Select')."..",]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, "public")->dropDownList(['1'=>'Да','0'=>'Нет']);?>
    <?= $form->field($model, 'weight')->textInput() ?>
    <?php
    $key = $model->id;
    $model_name='category';
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>$model_name]);

    $initialPreviewConfig =[];
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/".$model_name."/".$model->id."/s_".$main_img, ['class'=>'file-preview-image', 'alt'=>''])];
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
            'uploadUrl' => Url::to(['/site/img-upload','id'=>$model->id]),
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
