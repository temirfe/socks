<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use frontend\models\Destination;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isAdmin=Yii::$app->user->can('userIndex');

$descs= Yii::$app->cache->getOrSet('descriptions'.$model->id, function () use($model) {
    return $model->descriptions;
}, 0);
$destinations = Yii::$app->cache->getOrSet('destination', function () {
    return Destination::find()->all();
}, 0);
$desc_ar=[];
$qcid=Yii::$app->request->get('cid');
$dest_id=$qcid;

foreach($descs as $desc){
    $desc_ar[$desc->destination_id]=[
            'id'=>$desc->id,
            'title'=>$desc->title,
            'image'=>$desc->image,
            'text'=>$desc->description,
            'country'=>$desc->destination->title
        ];
}
?>
<div class="category-view">
    <p class="pull-right mr5a xs-block">
        <?php
        if($isAdmin){
            echo Html::a(Yii::t('app', 'Add tour'), ['tour/create', 'category_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
            echo Html::a(Yii::t('app', 'Add description'), ['description/create', 'category_id' => $model->id, 'ref'=>'view'], ['class' => 'btn btn-sm btn-default']);
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

    <!--<h1 class="container"><?/*= Html::encode($this->title) */?></h1>-->

    <?php
        if(!empty($desc_ar[$dest_id])){
            $img=Yii::getAlias('@web')."/images/description/".$desc_ar[$dest_id]['id'].'/'.$desc_ar[$dest_id]['image'];
            ?>
            <div class="jumbotron jumbo rel" style="background-image:url(<?=$img?>)">
                <div class="dimmer dimmer2 zind2"></div>
                <div class="rel zind3 welcome">
                    <h2 class="white"><?=$desc_ar[$dest_id]['title'];?></h2>
                    <p class="lead font16"><?=$desc_ar[$dest_id]['text']?></p>
                </div>
            </div>
    <?php
        }
    ?>

    <div class="container">
        <?php
        if(count($desc_ar)>1){
            if($qcid){$btnClassAll='default';}else{$btnClassAll='success';}
            foreach($desc_ar as $cid=>$desc){
                if($cid==$qcid){$btnClass='success';}else{$btnClass='default';}
                echo Html::a(Yii::t('app','All'),['view','id'=>$model->id, 't'=>$model->title],['class'=>'btn btn-'.$btnClassAll.' mr10']);
                echo Html::a($desc['country'],['view','id'=>$model->id,'cid'=>$cid,'destination'=>$desc['country']],['class'=>'btn btn-'.$btnClass.' mr10']);
            }
        }
        ?>
        <h2 class="text-center mb25 mt35"><?=$this->title?></h2>
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

</div>
