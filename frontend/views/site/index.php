<?php

/* @var $this yii\web\View */
/* @var $page \frontend\models\Page */

use yii\helpers\Html;
use frontend\models\Destination;
use frontend\models\Category;

$this->title = 'OK Tour - Unforgettable tours';
$alias=Yii::getAlias('@web');
$file=$alias."/images/page/".$page->id.'/'.$page->image;
$banner=Html::img($file,['class'=>'img-responsive']);
$destinations = Yii::$app->cache->getOrSet('destination', function () {
    return Destination::find()->all();
}, 0);
$categories= Yii::$app->cache->getOrSet('category', function () {
    return Category::find()->all();
}, 0);
?>
<div class="site-index">
    <div class="jumbotron rel">
        <div class="banner"><?=$banner;?></div>
        <div class="dimmer zind2"></div>
        <div class="rel zind3 welcome rubik">
            <h1><?=$page->title;?></h1>

            <p class="lead"><?=$page->text?></p>
        </div>
    </div>

    <div class="body-content container">

        <div class="main_item_box">
            <?php
            foreach($destinations as $destination){
                ?>
                <div class="country_card pull-left rel">
                    <?=Html::a($destination->getImage(),['/destination/view','id'=>$destination->id])?>
                    <div class="card_bottom abs rubik">
                        <?=$destination->title?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="main_item_box">
            <?php
            foreach($categories as $ctg){
                ?>
                <div class="country_card pull-left rel">
                    <?=Html::a($ctg->getImage(),['/category/view','id'=>$ctg->id])?>
                    <div class="card_bottom abs rubik">
                        <?=$ctg->title?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

    </div>
</div>
