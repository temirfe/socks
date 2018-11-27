<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
$categories = Yii::$app->cache->getOrSet('category', function () {
    return Category::find()->all();
});
$ctgs=ArrayHelper::map($categories,'id','title');
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                ['attribute' => 'id', 'contentOptions' => ['width' => 80]],
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $img='';
                        if($model->mainImg){$img=Html::img('/images/product/'.$model->id.'/s_'.$model->mainImg,['class'=>'w30 mr10 vtop']);}
                        return $img.$model->title;
                    },
                ],
                'title',
                'price',
                //'sex',
                [
                    'attribute' => 'category_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->category->title;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', $ctgs, ['class' => 'form-control', 'prompt' => Yii::t('app', 'All')]),
                ],
                [
                    'attribute' => 'public',
                    'format' => 'raw',
                    'value' => function ($model) {
                            $public=['нет','да'];
                        return $public[$model->public];
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'public', ['нет','да'], ['class' => 'form-control', 'prompt' => Yii::t('app', 'All')]),
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } catch (Exception $e) {
        var_dump($e);
    } ?>
    <?php Pjax::end(); ?>
</div>
