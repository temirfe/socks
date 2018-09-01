<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TourSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tour-search">

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

    <?= $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'description_ko') ?>

    <?php // echo $form->field($model, 'days') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'destination_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
