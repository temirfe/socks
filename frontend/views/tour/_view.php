<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $tour frontend\models\Tour */
?>

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
