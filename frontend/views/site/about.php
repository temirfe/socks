<?php

/* @var $this yii\web\View */
/* @var $page frontend\models\Page */

use yii\helpers\Html;
use frontend\models\Page;

$page=Page::find()->where(['category'=>'about_us'])->one();
$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;
?>
<div class="site-about">
    <h1><?= Html::encode($page->title) ?></h1>

    <?=$page->text?>

</div>
<div class="rel" style="width:400px;">
    <img src="/images/logo.jpg" />
    <div class="the_logo_wrap">
        <div class="the_logo"></div>
        <div class="the_logo_line"></div>
    </div>
</div>