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
else{
    echo "<div class=\"under_construction\">Внимание: сайт находится в стадии разработки!</div>";
}

$categories= Yii::$app->cache->getOrSet('category', function () {
    return Yii::$app->db->createCommand("SELECT * FROM category")->queryAll();
});
$parents=[];
$children=[];
foreach($categories as $category){
    $inner=['id'=>$category['id'],'title'=>$category['title'], 'weight'=>$category['weight']];
    if(!$category['parent_id']){$parents[]=$inner;}
    else{$children[$category['parent_id']][]=$inner;}
}
$ctgItems=[];
foreach($parents as $parent){
    $item=['label'=>$parent['title'], 'url'=>'/product/index?category_id='.$parent['id']];
    if(!empty($children[$parent['id']])){
        $items=[];
        foreach($children[$parent['id']] as $child){
            $items[]=['label'=>$child['title'],'url'=>'/product/index?category_id='.$child['id']];
            $items[]='<div class="dropdown-divider"></div>';
        }
        $item['items']=$items;
    }
    $ctgItems[]=$item;
}

$menuItems = [
    [
        'label' => Yii::t('app','Socks'),
        //'url' => ['/socks'],
        'items' => [
            ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
            '<div class="dropdown-divider"></div>',
            ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
        ],
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
            'items' => $ctgItems,
        ]);
    } catch (Exception $e) {}

    echo Html::a(Yii::t('app','Contact us'),['/contact'],['class'=>'nav_link']);

 NavBar::end();