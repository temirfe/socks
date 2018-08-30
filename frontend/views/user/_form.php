<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */;
$dao=Yii::$app->db;
$roles = ArrayHelper::map($dao->createCommand("SELECT id,title FROM roles")->queryAll(),'id','title');
?>

<div class="user-form row">

    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?php if(Yii::$app->controller->action->id=='create'){echo $form->field($model, 'password')->passwordInput();} ?>
        <?= $form->field($model, 'email')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
