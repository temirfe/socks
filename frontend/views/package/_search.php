<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'included') ?>

    <?= $form->field($model, 'included_ru') ?>

    <?= $form->field($model, 'included_ko') ?>

    <?= $form->field($model, 'not_included') ?>

    <?php // echo $form->field($model, 'not_included_ru') ?>

    <?php // echo $form->field($model, 'not_included_ko') ?>

    <?php // echo $form->field($model, 'tour_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
