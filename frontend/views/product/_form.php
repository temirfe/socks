<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Product */
/* @var $form yii\widgets\ActiveForm */

use frontend\models\Category;
use yii\helpers\Url;
use kartik\file\FileInput;
use vova07\imperavi\Widget;

$ctgs=Category::find()->all();
$catsel=[]; $ctitles=[];
foreach($ctgs as $ctg){
    $ctitles[$ctg['id']]=$ctg['title'];
    $ctitle=$ctg['title'];
    if(!empty($ctg['parent_id'])){
        if(!empty($ctitles[$ctg['parent_id']])){$ctitle=$ctitles[$ctg['parent_id']].' / '.$ctg['title'];}
        else {$ctitle=' / '.$ctg['title'];}
    }
    $catsel[$ctg['id']]=$ctitle;
}
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category_id')->dropDownList($catsel,['prompt'=>'Выберите']); ?>
    <?= $form->field($model, 'description')->widget(Widget::className(), [
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

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'sex')->dropDownList(['м/ж','мужск.','женск.']); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'public')->dropDownList(['1'=>'Да','0'=>'Нет']); ?>
        </div>
    </div>

    <div class="clear mb20">
        <?php
        $model_name='product';
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
            'resizeImages'=>true,
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial'=>false,
                'initialPreview'=>$iniImg2,
                'previewFileType' => 'any',
                'initialPreviewConfig' => $initialPreviewConfig2,
                'maxImageWidth' => 1600,
                'resizeImage' => true,
            ],
            'pluginEvents' => [
                "filesorted" => "imgSorted",
            ],
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>