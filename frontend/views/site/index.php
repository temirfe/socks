<?php

/* @var $this yii\web\View */
/* @var $page \frontend\models\Page */
/* @var $destinations \frontend\models\Destination */
/* @var $categories \frontend\models\Category */
/* @var $tours \frontend\models\Tour */

use yii\helpers\Html;

$this->title = 'OK Tour - Unforgettable tours';
$alias=Yii::getAlias('@web');
$file=$alias."/images/page/".$page->id.'/'.$page->image;
$banner=Html::img($file,['class'=>'img-responsive']);

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


        <h2 class="text-center mb25">Destinations</h2>
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

        <h2 class="text-center mb25 mt35">Adventures</h2>

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

        <h2 class="text-center mb25 mt35">Tours</h2>

        <div class="main_item_box row">
            <?php
            foreach($tours as $tour){
                ?>
                <div class="tour_card col-sm-4 col-xs-6">
                    <div class="image rel">
                        <?=$tour->getImage()?>
                        <div class="tour_card_intro">
                            <?=Html::a($tour->intro."<span class='false_link'></span>",['/tour/view','id'=>$tour->id,'t'=>$tour->slug])?>
                        </div>
                        <div class='dimmer dimmer2 hiddeniraak'>
                            <?=Html::a("<span class='false_link'></span>",['/tour/view','id'=>$tour->id,'t'=>$tour->slug])?>
                        </div>"


                    </div>
                    <div class="tour_card_footer rel">
                        <h4>
                            <?=Html::a($tour->title."<span class='false_link'></span>",
                                ['/tour/view','id'=>$tour->id,'t'=>$tour->slug],['class'=>'no_decor'])?>
                        </h4>
                        <span class="price"><?=$tour->lowestPrice?></span>
                        <span class="days">
                            <?php if($tour->days){echo $tour->days.' '.Yii::t('app','days');}?>
                        </span>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

    </div>
</div>
