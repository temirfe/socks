<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
/* @var $page frontend\models\Page */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use frontend\models\Page;
use frontend\models\Lookup;

$page=Page::find()->where(['category'=>'contacts'])->one();
$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;
$lookups = Yii::$app->cache->getOrSet('lookup', function () {
    return Lookup::find()->all();
}, 0);
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-7">
           <!-- <ul class="fa-ul contact_ul">
                <?php
/*                foreach($lookups as $lookup){
                    if($lookup->text && in_array($lookup->title,['phone','email','address'])){
                        if($lookup->title=='address'){$fas='map-marker-alt';$ftitle=Html::a($lookup->text,'https://2gis.kg/search/'.$lookup->text,['target'=>'_blank']);}
                        else if($lookup->title=='phone'){$fas='phone';$ftitle=Html::a($lookup->text,'tel:'.$lookup->text);}
                        else if($lookup->title=='email'){$fas='at';$ftitle=Html::a($lookup->text,'mailto:'.$lookup->text);}
                        echo "<li><span class='fa-li'><i class='fas fa-{$fas} fa-lg'></i></span>".$ftitle."</li>";
                    }
                }
                */?>
            </ul>-->
            <?=$page->text?>
        </div>

    </div>

</div>
