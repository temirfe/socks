<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\models\Lookup;

$menuItems = [
    ['label' => Yii::t('app','About us'), 'url' => ['/about']],
    ['label' => Yii::t('app','Countries'), 'url' => ['/countries']],
    ['label' => Yii::t('app','Type of tours'), 'url' => ['/tours']],
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

NavBar::begin([
    'brandLabel' => Html::img('/images/ok_logo.jpg'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar mynav',
    ],
]);

?>
    <div class="top_contact rubik">
        <div class="phone pull-left"><span class="glyphicon glyphicon-earphone mr5"></span><?=$phone?></div>
        <div class="email pull-left"><span class="glyphicon glyphicon-envelope mr5"></span><?=$email?></div>
        <div class="lang pull-right"><?=$eng?><?=$ru?><?=$ko?></div>
    </div>
<div class="nav_flex">
    <?=Nav::widget([
        'options' => ['class' => 'navbar-nav rubik upper'],
        'items' => $menuItems,
    ]);?>
</div>
<?php NavBar::end(); ?>
