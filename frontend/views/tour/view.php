<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\SwiperAsset;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tour */

SwiperAsset::register($this);
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dao=Yii::$app->db;
?>
<div class="tour-view">
    <p class="pull-right">
        <?= Html::a(Yii::t('app', 'Add price'), ['price/create', 'tour_id' => $model->id], ['class' => 'btn btn-sm btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="tour_params row mb20 mt20">
        <?php if($model->destination){
            ?>
            <div class="col-sm-3">
                <div><?=Yii::t('app','Country')?>:</div>
                <span><?=$model->destination->title?></span>
            </div>
            <?php
        } ?>

        <div class="col-sm-3">
            <div><?=Yii::t('app','Tour type')?>:</div><span><?=$model->category->title?></span>
        </div>
        <div class="col-sm-3">
            <div><?=Yii::t('app','Duration')?>:</div><span><?=$model->days?> <?=Yii::t('app','days')?></span>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-8">
            <?php
            if($model->images){
                $banners=explode(';',$model->images);
                if(count($banners)>1){
                ?>
                <div class="banner-container swiper-container mb20" data-count="<?=count($banners)?>">
                    <div class="swiper-wrapper">
                        <?php
                        foreach($banners as $banner){
                            echo Html::img('/images/tour/'.$model->id.'/'.$banner,['class'=>'swiper-slide']);
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                <?php
                }
                else echo "<div class='swiper-container mb20'>".Html::img('/images/tour/'.$model->id.'/'.$model->images,['class'=>'img-responsive'])."</div>";
            }
            ?>
            <h3><?=Yii::t('app','Tour description')?></h3>
            <p><?=$model->description?></p>

            <?php
            if($days=$model->day){
                $d=1;
                echo "<h3>".Yii::t('app','Tour program')."</h3>";
                foreach($days as $day){
                    ?>
                    <div class="mt15 mb15">
                        <div class="day"><?=Yii::t('app','Day')?><span><?=$d?></span></div>
                        <div class="day_info">
                            <h4 class="title"><?=$day->title?></h4>
                            <?php if($day->itinerary){
                                echo "<h4>".Yii::t('app','Itinerary')."</h4>";
                                echo $day->itinerary;
                            }?>
                            <?php if($day->meals){
                                echo "<h4>".Yii::t('app','Meals')."</h4>";
                                echo $day->meals;
                            }?>
                            <?php if($day->accommodation){
                                echo "<h4>".Yii::t('app','Accommodation')."</h4>";
                                echo $day->accommodation;
                            }?>
                        </div>
                    </div>

            <?php
                    $d++;
                }
            }
            if($model->package){
                echo "<h3>".Yii::t('app','Tour package')."</h3>";
                ?>
                <div class="row clearfix mb20 full_content closed">
                    <div class='col-sm-6 included'>
                        <h4 class="title2 mt0">
                            <i class="glyphicon glyphicon-ok green"></i>
                            <?=Yii::t('app','Included')?>
                        </h4>
                        <?=$model->package->included ?>
                    </div>
                    <div class='col-sm-6 not_included'>
                        <h4 class="title2 mt0">
                            <i class="glyphicon glyphicon-remove red"></i>
                            <?=Yii::t('app','Not included')?>
                        </h4>
                        <?=$model->package->not_included ?>
                    </div>
                    <div class="gradient" style="display: block;"></div>
                    <div class="full_toggle link more js_more"><?=Yii::t('app','Show more')?></div>
                    <div class="full_toggle link less js_less"><?=Yii::t('app','Show less')?></div>
                </div>
            <?php
            }


            foreach($model->prices as $price){
                echo $price->title.' '.$price->price.' '.$price->currency.'<br />';
                echo $price->note.'<br />';
                if($price->date_start){
                    echo date('d.m.Y',$price->date_start).' '.date('d.m.Y',$price->date_end);
                }

                $books = $dao->createCommand("SELECT id, group_of FROM book WHERE price_id='{$price->id}'")->queryAll();
                if($books){
                    $booked=0;
                    foreach($books as $book){
                        if($book['group_of']){$booked+=$book['group_of'];}
                        else{$booked++;}
                    }
                    echo $booked.' '.Yii::t('app', 'people booked');
                }

                echo Html::a(Yii::t('app', 'Book'), ['book/create', 'price_id' => $price->id], ['class' => 'btn btn-success']);
                echo '<br /><br />';
            }
            ?>
        </div>
        <div class="col-sm-4"></div>
    </div>


</div>
