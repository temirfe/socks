<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\models\Lookup;
use frontend\models\Category;
use frontend\models\Destination;

$categories = Yii::$app->cache->getOrSet('category', function () {
    return Category::find()->all();
}, 0);
$destinations = Yii::$app->cache->getOrSet('destination', function () {
    return Destination::find()->all();
}, 0);
$ctgItems=[];$countryItems=[];
foreach($categories as $category){
    if($ctgItems){$ctgItems[]='<li class="divider"></li>';}
    $ctgItems[]=['label' => $category->title, 'url' => ['/category/view','id'=>$category->id, 't'=>$category->title]];
}
foreach($destinations as $dest){
    if($countryItems){$countryItems[]='<li class="divider"></li>';}
    $countryItems[]=['label' => $dest->title, 'url' => ['/destination/view','id'=>$dest->id, 't'=>$dest->title]];
}

$menuItems = [
    ['label' => Yii::t('app','About us'), 'url' => ['/about']],
    [
        'label' => Yii::t('app','Countries'),
        //'url' => ['/countries'],
        'items' => $countryItems,
    ],
    [
        'label' => Yii::t('app','Type of tours'),
        //'url' => ['/tours'],
        'items' => $ctgItems,
    ],
    ['label' => Yii::t('app','Contact us'), 'url' => ['/contact']],
];

$lookups = Yii::$app->cache->getOrSet('lookup', function () {
    return Lookup::find()->all();
}, 0);
$phone='';$email='';
foreach($lookups as $lookup){
    if($lookup->title=='phone'){
        $phones=explode(',',$lookup->text);
        foreach($phones as $ph){
            $phone.="<a href='tel:".preg_replace("/[^\+\d]/", "", $ph)."'>".$ph."</a>";
        }
    }
    else if($lookup->title=='email'){
        $emails=explode(',',$lookup->text);
        foreach($emails as $em){
            $email.="<a href='mailto:".$em."'>".$em."</a>";
        }
    }
}

//if(Yii::$app->user->can('userIndex')){include_once('adminpanel.php');}
$curLang=Yii::$app->language;
$eng=Html::a(Html::img('/images/gbr.png'),['site/lang','to'=>'en-US'],['title'=>'English']);
$ru=Html::a(Html::img('/images/rus.png'),['site/lang','to'=>'ru-RU'],['title'=>'Русский']);
$ko=Html::a(Html::img('/images/kor.png'),['site/lang','to'=>'ko-KR'],['title'=>'한국어']);
if($curLang=='en-US'){$eng='';}
else if($curLang=='ru-RU'){$ru='';}
else if($curLang=='ko-KR'){$ko='';}

$isAdmin=Yii::$app->user->can('userIndex');
if($isAdmin){$adminPanel="<div class='pull-right phone'>".Html::a('Admin panel',['/admin'])."</div>";}
else{$adminPanel='';}

?>
<div class="top_contact rubik">
    <div class="container">
        <div class="lang pull-right"><?=$eng?><?=$ru?><?=$ko?></div>
        <div class="email pull-right"><span class="glyphicon glyphicon-envelope mr5"></span><?=$email?></div>
        <div class="phone pull-right"><span class="glyphicon glyphicon-earphone mr5"></span><?=$phone?></div>
        <?=$adminPanel?>
    </div>
</div>
<?php
NavBar::begin([
    'brandLabel' => Html::img('/images/ok_logo2.png'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar mynav',
    ],
]);

?>

<div class="nav_flex">
    <?=Nav::widget([
        'options' => ['class' => 'navbar-nav rubik upper'],
        'items' => $menuItems,
    ]);?>
</div>
<?php NavBar::end(); ?>
