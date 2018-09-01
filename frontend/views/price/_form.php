<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Tour;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Price */
/* @var $form yii\widgets\ActiveForm */
$tour=Yii::$app->request->get('tour_id');
if($tour){$model->tour_id=$tour;}
?>

<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'tour_id')->dropDownList(Tour::getList()) ?>



    <div class="row">
        <div class="col-sm-3"><?= $form->field($model, 'group_of')->textInput() ?></div>
        <div class="col-sm-9"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'price')->textInput() ?></div>
        <div class="col-sm-3"><?= $form->field($model, 'currency')->dropDownList(['usd'=>'USD','kgs'=>'KGS']) ?></div>
        <div class="col-sm-3">
            <?= $form->field($model, 'date_start')->widget(DatePicker::className(), [
                'type' => DatePicker::TYPE_INPUT,
                //'convertFormat'=>true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    //'format'=>'dd/mm/yyyy',
                    'format'=>'yyyy-mm-dd',
                ]
            ])->hint('Leave blank if any date') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'date_end')->widget(DatePicker::className(), [
                'type' => DatePicker::TYPE_INPUT,
                //'convertFormat'=>true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    //'format'=>'dd/mm/yyyy',
                    'format'=>'yyyy-mm-dd',
                ]
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form_wrap wrap_ru">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ru">
            <img src="/images/blank.gif" class="flag flag-ru" alt="Russian" />
            <span class="dotted_link arrow_toggle">Text in Russian</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ru">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'note_ru')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'note_ko')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
