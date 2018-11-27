<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\SwiperAsset;
use frontend\assets\PhotoSwipeAsset;

SwiperAsset::register($this);
PhotoSwipeAsset::register($this);

$webroot=Yii::getAlias('@webroot');
include_once($webroot.'/photoswipe/_swipe.php');

/* @var $this yii\web\View */
/* @var $model frontend\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$imgs=explode(';',$model->images);
?>
<div class="product-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a(Yii::t('app', 'Products'), ['admin'], ['class' => 'btn btn-default pull-right']) ?>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success pull-right mr10']) ?>
    </p>
    <div class="row">
        <?php
        if($imgs){
            ?>
            <div class="col-sm-6 view_img_wrap">

                <?php
                if(count($imgs)>0){
                    ?>

                    <div class='thumbs_wrap pull-left'>
                        <ul>
                            <?php
                            $img_index = 0;
                            foreach ($imgs as $img){
                                if($img_index==0){$thumb_class='active_thumb js_prevent_default';}else{$thumb_class='js_open_thumb';}
                                $thumb=Html::img("@web/images/product/".$model->id.'/s_'.$img,['class'=>'img-responsive js_img']);
                                echo '<li>'.Html::a($thumb,'#',['class'=>$thumb_class, 'data-big'=>'/images/product/'.$model->id.'/'.$img, 'data-index'=>$img_index]).'</li>';
                                $img_index++;
                            }
                            ?>
                        </ul>
                    </div>
                <?php
                }
                ?>
                <div class="real_img_wrap">
                    <div class='abs open_gallery'><?=Html::a("<span class='glyphicon glyphicon-zoom-in'></span>", '#', ['class' => 'js_photo_swipe', 'data-index' => '0']);?></div>
                    <?=Html::img('/images/product/'.$model->id.'/'.$imgs[0],['class'=>'img-responsive js_main_img']); ?>
                </div>

            </div>
            <?php
        }
        ?>

        <div class="col-sm-6">
            <h2 class="mt0"><?= Html::encode($this->title) ?></h2>
            <?php if($model->price){echo Html::tag('h1 ',$model->price. ' сом');}?>
            <?=$model->description?>
        </div>

    </div>

</div>