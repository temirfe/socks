<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = Yii::t('app', 'Products');
//$this->params['breadcrumbs'][] = $this->title;
$queryCtg=Yii::$app->request->get('category_id');
$categories= Yii::$app->cache->getOrSet('category', function () {
    return Yii::$app->db->createCommand("SELECT * FROM category")->queryAll();
});
$ctgMenu=[];$parent_id=null;
foreach($categories as $category){
    if($category['id']==$queryCtg){
        if($category['parent_id']){$parent_id=$category['parent_id'];}
    }
}
foreach($categories as $category){
    if($category['id']==$queryCtg && !$category['parent_id'] || $category['id']==$parent_id ){
        $ctgMenu[0]=['id'=>$category['id'],'title'=>'Все '.$category['title']]; $title=$category['title'];}
    else if($category['parent_id']==$queryCtg || ($parent_id && $category['parent_id']==$parent_id)){
        $ctgMenu[]=['id'=>$category['id'],'title'=>$category['title']];}
    else if($category['id']==$queryCtg){$ctgMenu[]=['id'=>$category['id'],'title'=>$category['title']];}
}
$this->title =$title;
?>
<script type="text/javascript" src="https://unpkg.com/scrollreveal@4.0.5/dist/scrollreveal.js"></script>
<?php if(Yii::$app->user->can('userIndex')){
    ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success mt10']) ?>
    </p>
<?php
}?>


<div class="product-index">

    <h1 class="mob_hidden"><?= Html::encode($this->title) ?></h1>
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
            <!--<li class="pull-left"><a href="/product" class="<?/*=$all*/?>">Все</a> </li>
            <li class="pull-left"><a href="/product?show=socks" class="<?/*=$c1*/?>">Носки</a> </li>
            <li class="pull-left"><a href="/product?show=singlets" class="<?/*=$c2*/?>">Майки</a> </li>
            <li class="pull-left"><a href="/product?show=underwear" class="<?/*=$c3*/?>">Трусы</a> </li>-->
            <?php
                if($ctgMenu){
                    foreach($ctgMenu as $ctgli){
                        if($queryCtg==$ctgli['id']){$act='active';}else{$act='';}
                        echo Html::tag('li',
                            Html::a($ctgli['title'],['index','category_id'=>$ctgli['id']],['class'=>$act]),
                            ['class'=>'pull-left']
                        );
                    }
                }
            ?>
        </ul>
    </div>

    <?php
    try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => Yii::t('app', 'Soon'),
            'summary' => '',
            'itemOptions' => ['class' => 'product_item js_product_item'],
            'layout' => '{items}<div class="clear">{pager}</div>{summary}',
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_view', ['model' => $model]);
            },
        ]);
    } catch (Exception $e) {
    } ?>
    <?php Pjax::end(); ?>
</div>