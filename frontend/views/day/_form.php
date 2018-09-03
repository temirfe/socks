<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Day */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'itinerary')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'meals')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'accommodation')->textInput(['maxlength' => true]) ?>

    <div class="form_wrap wrap_ru">
        <div class="js_rot_caret" data-toggle="collapse" data-target="#ru">
            <img src="/images/blank.gif" class="flag flag-ru" alt="Russian" />
            <span class="dotted_link arrow_toggle">Text in Russian</span>
            <i class="mrg-left-5 trans300 glyphicon glyphicon-triangle-bottom fs9" style="transform: rotate(0deg);"></i>
        </div>
        <div class="collapse" id="ru">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'itinerary_ru')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'meals_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'accommodation_ru')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'itinerary_ko')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'meals_ko')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'accommodation_ko')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'tour_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
