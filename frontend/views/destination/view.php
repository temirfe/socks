<?php

use yii\helpers\Html;
use frontend\assets\SwiperAsset;
use yii\widgets\ListView;
use frontend\assets\PhotoSwipeAsset;

/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */
/* @var $dataProvider yii\data\ActiveDataProvider */

SwiperAsset::register($this);
PhotoSwipeAsset::register($this);
$webroot=Yii::getAlias('@webroot');

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Destinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$isAdmin=Yii::$app->user->can('userIndex');
if(strlen($model->text)>555){
    $full='full_content closed mb20';
}
else{
    $full=false;
}
?>
<div class="destination-view">
    <p class="pull-right mr5a">
        <?php
        if($isAdmin){
            echo Html::a(Yii::t('app', 'Add tour'), ['tour/create', 'destination_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if($model->images){
        $banners=explode(';',$model->images);
        if(count($banners)>1){
            ?>
            <div class="country_swiper swiper-container mb20 js_photoswipe_wrap" data-count="<?=count($banners)?>">
                <div class="swiper-wrapper">
                    <?php
                    foreach($banners as $banner){
                        echo "<div class='swiper-slide'>".Html::img('/images/destination/'.$model->id.'/'.$banner)."</div>";
                    }
                    ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <?php
        }
        else echo "<div class='swiper-container country_banner mb20'>".Html::img('/images/destination/'.$model->id.'/'.$model->images,['class'=>'img-responsive'])."</div>";
    }
    ?>

    <div class="country_desc readable clearfix <?=$full?> js_more_less">

        <?=$model->text?>

        <?php
            if($full){
                ?>
                <div class="gradient" style="display: block;"></div>
                <div class="full_toggle more"><?=Html::a(Yii::t('app','Show more'),'#',['class'=>'js_more'])?></div>
                <div class="full_toggle less"><?=Html::a(Yii::t('app','Show less'),'#',['class'=>'js_less'])?></div>
        <?php
            }
        ?>
    </div>

    <h2 class="text-center mb25 mt35">Tours</h2>
    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'tour_card x-md-33 x-sm-33 x-xs-50'],
        'emptyText' => Yii::t('app', 'Tours are coming soon..'),
        'summary'=>'',
        'options'=>['class'=>'flex flex-wrap mr-30 xs-mr-15'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('/tour/_view',['tour' => $model]);
        },
    ]) ?>

</div>
<?php include_once($webroot.'/photoswipe/_swipe.php');?>