<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\models\Lookup;
use frontend\models\Category;
use frontend\models\Destination;

require_once('_lookups.php');

$menuItems = [
    [
        'label' => Yii::t('app','Socks'),
        'url' => ['/socks'],
    ],
    [
        'label' => Yii::t('app','Singlets'),
        'url' => ['/singlets'],
    ],
    [
        'label' => Yii::t('app','Underwear'),
        'url' => ['/underwear'],
    ],
];


//if(Yii::$app->user->can('userIndex')){include_once('adminpanel.php');}

$isAdmin=Yii::$app->user->can('userIndex');
if($isAdmin){$adminPanel="<div class='pull-right phone'>".Html::a(Yii::t('app','Admin panel'),['/admin'])."</div>";}
else{$adminPanel='';}

?>
<div class="top_contact rubik">
    <div class="container">
        <div class="email pull-right"><?=$fa_email?><span><?=$email?></span></div>
        <div class="phone pull-right"><?=$fa_phone?><span><?=$phone?></span></div>
        <?=$adminPanel?>
    </div>
</div>
<?php
NavBar::begin([
    'brandLabel' => Html::img('/images/logo.jpg'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar mynav',
    ],
]);

?>
<?=Nav::widget([
    'options' => ['class' => 'navbar-nav upper'],
    'items' => $menuItems,
]);?>
<a class="pull-right" href="/contacts"><?=Yii::t('app','Contact us')?></a>
<?php NavBar::end(); ?>
