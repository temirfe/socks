<?php

/* @var $this yii\web\View */
/* @var $page \frontend\models\Page */
/* @var $destinations \frontend\models\Destination */
/* @var $categories \frontend\models\Category */
/* @var $tours \frontend\models\Tour */

use yii\helpers\Html;

$this->title = 'OK Tour - '.Yii::t('app','Unforgettable tours');
$alias=Yii::getAlias('@web');
$file=$alias."/images/page/".$page->id.'/'.$page->image;
//$banner=Html::img($file,['class'=>'img-responsive']);
$lang=Yii::$app->language;
?>
<div class="site-index">
    <div class="jumbotron rel" style="background-image: url(<?=$file?>);">
        <!--<div class="banner"><?/*=$banner;*/?></div>-->
        <div class="dimmer zind2"></div>
        <div class="rel zind3 welcome rubik">
            <h1><?=$page->title;?></h1>

            <p class="lead"><?=$page->text?></p>
        </div>
    </div>

    <div class="body-content container">
        <h2 class="text-center mb25"><?=Yii::t('app','Destinations')?></h2>
        <div class="flex flex-wrap mr-8">
            <?php
            foreach($destinations as $destination){
                ?>
                <div class="country_card x-md-20 x-xs-50 x-sm-33">
                    <div class="rel ohidden">
                        <?=$destination->getImage()?>
                        <div class="card_bottom abs rubik">
                            <?=$destination->title?>
                        </div>
                        <?=Html::a("<span class='false_link'></span>",['/destination/view','id'=>$destination->id,'t'=>$destination->title])?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <h2 class="text-center mb25 mt35"><?=Yii::t('app','Adventures');?></h2>
        <div class="xrow">
            <?php
                $parent="x-md-20 x-sm-50 x-xs-100 flex x-md-col";
                $child="x-sm-50 x-xs-50 pad4";
                $normal="x-md-40 x-sm-25 x-xs-50 pad4";
                foreach($categories as $key=>$ctg){
                    $pb1='';
                    if($key==0){echo "<div class='{$parent}'>"; $pb1='x-pb1';}
                    if($key<=1){
                        echo "<div class='{$child} {$pb1}'><div class='adv_box'>";
                        echo $ctg->getImage();
                        echo "<span class='dimmer'>".Html::a("<span class='false_link'></span>",['/category/view','id'=>$ctg->id])."</span>";
                        echo "<h3 class='box_title box_title_{$lang}'><div>".$ctg->title."<span></span></div></h3>";
                        echo "</div></div>";
                    }
                    if($key==1){echo "</div>";}
                    if($key>1){
                        echo "<div class='{$normal}'><div class='adv_box'>";
                        echo $ctg->getImage();
                        echo "<span class='dimmer'>".Html::a("<span class='false_link'></span>",['/category/view','id'=>$ctg->id])."</span>";
                        echo "<h3 class='box_title box_title_{$lang}'><div>".$ctg->title."<span></span></div></h3>";
                        echo "</div></div>";
                    }
                }
            ?>
        </div>

        <h2 class="text-center mb25 mt35"><?=Yii::t('app','Tours')?></h2>
        <div class="flex flex-wrap mr-30 xs-mr-15">
            <?php
            foreach($tours as $tour){
                ?>
                <div class="tour_card x-md-33 x-sm-33 x-xs-50">
                    <div class="rel">
                        <div class="tour_card_dest"><?=$tour->destination->title?></div>
                        <div class="image">
                            <?=$tour->getImage()?>
                            <!--<div class="tour_card_intro">
                            <?/*=Html::a($tour->intro."<span class='false_link'></span>",['/tour/view','id'=>$tour->id,'t'=>$tour->slug])*/?>
                        </div>-->
                        </div>
                        <div class="tour_card_footer">
                            <h4><?=$tour->title?></h4>
                            <span class="price"><?=$tour->lowestPrice?></span>
                            <span class="days">
                            <?php if($tour->days){echo $tour->days.' '.Yii::t('app','days');}?>
                        </span>
                        </div>

                        <div class="tour_card_intro">
                            <?=$tour->intro?>
                        </div>
                        <?=Html::a("<span class='false_link'></span>",['/tour/view','id'=>$tour->id,'t'=>$tour->slug])?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
