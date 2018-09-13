<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $tour frontend\models\Tour */
?>
<div class="rel">
    <div class="tour_card_dest"><?=$tour->destination->title?></div>
    <div class="image">
        <?=$tour->getImage()?>
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
