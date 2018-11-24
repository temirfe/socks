<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Login');
?>

<div class="bg_cover"></div>
<div class="site-login">
    <div class="col-md-5 white_box">
        <h2><?= Html::encode($this->title) ?></h2>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div style="color:#999;margin:1em 0">
            <?=Html::a(Yii::t('app','Forgot password'), ['site/request-password-reset']) ?> |
            <?=Html::a(Yii::t('app','Register'), ['site/signup']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Log in'), ['class' => 'btn btn-primary btn-lg2', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
