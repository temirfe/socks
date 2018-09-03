<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'title_ru') ?>

    <?= $form->field($model, 'title_ko') ?>

    <?= $form->field($model, 'itinerary') ?>

    <?php // echo $form->field($model, 'itinerary_ru') ?>

    <?php // echo $form->field($model, 'itinerary_ko') ?>

    <?php // echo $form->field($model, 'meals') ?>

    <?php // echo $form->field($model, 'meals_ru') ?>

    <?php // echo $form->field($model, 'meals_ko') ?>

    <?php // echo $form->field($model, 'accommodation') ?>

    <?php // echo $form->field($model, 'accommodation_ru') ?>

    <?php // echo $form->field($model, 'accommodation_ko') ?>

    <?php // echo $form->field($model, 'tour_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
