<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if(Yii::$app->user->can('userIndex')){
    ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
}?>


<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="clear"></div>
    <?php Pjax::begin(); ?>
    <?php
    $url=Yii::$app->request->url;
    $ctg=Yii::$app->request->get('show');
    $c1='';$c2='';$c3='';$all='';
    if($ctg=='socks'||$url=='/socks'){$c1='active';}
    else if($ctg=='singlets'||$url=='/singlets'){$c2='active';}
    else if($ctg=='underwear'||$url=='/underwear'){$c3='active';}
    else{$all='active';}
    ?>
    <div class="flex prod_menu">
        <ul class="myul prod_menu_ul comforta">
            <li class="pull-left"><a href="/product" class="<?=$all?>">Все</a> </li>
            <li class="pull-left"><a href="/product?show=socks" class="<?=$c1?>">Носки</a> </li>
            <li class="pull-left"><a href="/product?show=singlets" class="<?=$c2?>">Майки</a> </li>
            <li class="pull-left"><a href="/product?show=underwear" class="<?=$c3?>">Трусы</a> </li>
        </ul>
    </div>

    <?php
    try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => Yii::t('app', 'No results found'),
            'summary' => '',
            'layout' => '{items}<div class="clear">{pager}</div>{summary}',
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_view', ['model' => $model]);
            },
        ]);
    } catch (Exception $e) {
    } ?>
    <?php Pjax::end(); ?>
</div>