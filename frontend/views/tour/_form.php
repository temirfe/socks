<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use frontend\models\Category;
use frontend\models\Destination;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tour */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tour-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category_id')->dropDownList(Category::getList()) ?>
    <?= $form->field($model, 'destination_id')->dropDownList(Destination::getList()) ?>

    <?= $form->field($model, 'days')->textInput() ?>

    <?= $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>

    <?php
    $model_name='tour';
    $url = Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>$model_name]);


    //secondary images
    $iniImg2=false;
    $initialPreviewConfig2=[];
    if(!$model->isNewRecord) {
        if($model->images && is_dir("images/{$model_name}/".$model->id)){
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
            <?= $form->field($model, 'description_ru')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
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
            <?= $form->field($model, 'description_ko')->widget(Widget::className(), [
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
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
