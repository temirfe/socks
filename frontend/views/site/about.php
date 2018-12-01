<?php

/* @var $this yii\web\View */
/* @var $page frontend\models\Page */

use yii\helpers\Html;
use frontend\models\Page;

$page=Page::find()->where(['category'=>'about_us'])->one();
$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;
?>
<div class="site-about white_thang">
    <h1><?= Html::encode($page->title) ?></h1>

    <?=$page->text?>

</div>
