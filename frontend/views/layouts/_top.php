<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\models\Lookup;
use frontend\models\Category;
use frontend\models\Destination;

$user=Yii::$app->user;
require_once('_lookups.php');
if($user->can('userIndex')){require_once('adminpanel.php');}

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

$logo_clean=Html::tag('div','',['class'=>'the_logo']);
$logo_line=Html::tag('div','',['class'=>'the_logo_line']);
$logo=Html::tag('div',$logo_clean.$logo_line,['class'=>'the_logo_wrap']);

NavBar::begin([
    'brandLabel' => Html::tag('div',$logo,['class'=>'rel brand_wrap']),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar mynav',
    ],
]);

    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav upper'],
            'items' => $menuItems,
        ]);
    } catch (Exception $e) {}

    echo Html::a(Yii::t('app','Contact us'),['/contacts'],['class'=>'nav_link']);

 NavBar::end();