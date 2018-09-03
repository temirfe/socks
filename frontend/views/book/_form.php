<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Book */
/* @var $form yii\widgets\ActiveForm */

if($model->isNewRecord){
    if(!$price=Yii::$app->request->get('price_id')){
        die('wrong input');
    }
    else {
        $model->price_id=$price;
    }
}

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price_id')->hiddenInput(['readonly' => true])->label(false) ?>

    <?php // $form->field($model, 'date_start')->textInput() ?>

    <?php // $form->field($model, 'group_of')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
