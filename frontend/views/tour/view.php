<?php

use yii\helpers\Html;
use frontend\assets\SwiperAsset;
use frontend\assets\PhotoSwipeAsset;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tour */

SwiperAsset::register($this);
PhotoSwipeAsset::register($this);
$webroot=Yii::getAlias('@webroot');

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dao=Yii::$app->db;
$lowest_price=0;
$isAdmin=Yii::$app->user->can('userIndex');
$lowest_currency='';
?>
<div class="tour-view">
    <p class="pull-right mr5a xs-block">
        <?php
            if($isAdmin){
                echo Html::a(Yii::t('app', 'Add price'), ['price/create', 'tour_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
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


    <div class="tour_params row mb20 mt20">
        <?php if($model->destination){
            ?>
            <div class="col-sm-3 col-xs-4">
                <div><?=Yii::t('app','Country')?>:</div>
                <span><?=$model->destination->title?></span>
            </div>
            <?php
        } ?>

        <div class="col-sm-3 col-xs-4">
            <div><?=Yii::t('app','Tour type')?>:</div><span><?=$model->category->title?></span>
        </div>
        <div class="col-sm-3 col-xs-4">
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
                <div class="banner-container swiper-container js_photoswipe_wrap mb20" data-count="<?=count($banners)?>">
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
            <h3 class="bb"><span><?=Yii::t('app','Tour description')?></span></h3>
            <p><?=$model->description?></p>

            <?php
            if($days=$model->day){
                $d=1;
                echo "<h3 class='bb'><span>".Yii::t('app','Tour program')."</span></h3>";
                echo "<div class='full_content closed clearfix mb20 '>";
                    foreach($days as $day){
                        ?>
                        <div class="mt15 mb15">
                            <div class="pull-left">
                                <div class="tour_day"><?=Yii::t('app','Day')?><span><?=$d?></span></div>
                                <div class="tour_action">
                                    <?= Html::a("<span class='glyphicon glyphicon-pencil'></span>", ['/day/update', 'id' => $day->id]) ?>
                                    <?= Html::a("<span class='glyphicon glyphicon-trash'></span>", ['/day/delete', 'id' => $day->id], [
                                        'class' => 'red',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </div>
                            </div>

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
                    ?>

                    <div class="gradient" style="display: block;"></div>
                    <div class="full_toggle link more js_more"><?=Yii::t('app','Show more')?></div>
                    <div class="full_toggle link less js_less"><?=Yii::t('app','Show less')?></div>
                </div>
            <?php
            }
            if($isAdmin){
                echo "<div class='clearfix mt5 mb5'>".Html::a(Yii::t('app','Add day'),['/day/create','tour_id'=>$model->id],['class'=>'btn btn-default btn-sm'])."</div>";
            }

            if($model->package && ($model->package->included || $model->package->not_included)){
                echo "<h3 class='bb'><span>".Yii::t('app','Tour package')."</span></h3>";
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
            if($isAdmin){
                if($model->package){$pact='Update';  $pck_link_ar=["/package/update",'id'=>$model->package->id];}
                else {$pact='Add'; $pck_link_ar=["/package/create",'tour_id'=>$model->id];}
                echo "<div class='clearfix mt5 mb5'>".Html::a(Yii::t('app',"{$pact} package"),$pck_link_ar,['class'=>'btn btn-default btn-sm'])."</div>";
            }
            if($model->prices){
                echo "<h3 class='bb' id='prices'><span>".Yii::t('app','Tour offers')."</span></h3>";
                foreach($model->prices as $price){
                    $booked_text='';$dates='';
                    if($lowest_price){if($price->price<$lowest_price){$lowest_price=$price->price; $lowest_currency=$price->currency;}}
                    else{
                        $lowest_price=$price->price;
                        $lowest_currency=$price->currency;
                    }
                    if($price->date_start){
                        $dates=date('d.m.Y',strtotime($price->date_start)).' - '.date('d.m.Y',strtotime($price->date_end));
                    }
                    $books = $dao->createCommand("SELECT id, group_of FROM book WHERE price_id='{$price->id}'")->queryAll();
                    if($books){
                        $booked=0;
                        foreach($books as $book){
                            if($book['group_of']){$booked+=$book['group_of'];}
                            else{$booked++;}
                        }
                        $booked_text=$booked.' '.Yii::t('app', 'people booked');
                    }
                    ?>
                    <div class="book_box_wrap mb20">
                        <div class="col-sm-8 book_box book_box_info rel">
                            <?php
                            if($isAdmin){
                                echo "<div class='abs price_menu'>";
                                echo Html::a(Yii::t('app', 'Update'),['price/update','id'=>$price->id,'ref'=>'view']);
                                echo Html::a(Yii::t('app', 'Delete'), ['price/delete', 'id' => $price->id,'ref'=>'view'], [
                                    'class' => 'text-danger',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]);
                                echo "</div>";
                            }
                            ?>
                            <h3><?=$price->title?><div class='date pull-right'><?=$dates?></div></h3>
                            <div class="note"><?=$price->note?></div>
                            <div class="booked"><?=$booked_text?></div>
                        </div>
                        <div class="col-sm-4 book_box book_box_price">
                            <h3><?=$price->price?><span class="text-uppercase ml5"><?=$price->currency?></span> </h3>
                            <?=Html::a(Yii::t('app', 'Book Now'), ['book/create', 'price_id' => $price->id], ['class' => 'btn btn-success']);?>
                        </div>
                    </div>
                <?php
                    }
            }

            if($isAdmin){
                echo Html::a(Yii::t('app', 'Add price'), ['price/create', 'tour_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
            }
            ?>
        </div>
        <div class="col-sm-4 sm-hidden"><?php
            if($model->prices){
                ?>
                <div class="right_book_box book_box_price">
                <h3><span><?=Yii::t('app','from')?></span><?=$lowest_price?> <?=$lowest_currency?></h3>
                <?=Html::a(Yii::t('app', 'Book Now'), '#prices', ['class' => 'btn btn-success']);?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include_once($webroot.'/photoswipe/_swipe.php');?>