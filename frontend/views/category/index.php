<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
$rows=Yii::$app->db->createCommand("SELECT id, title, parent_id FROM category")->queryAll();
$parents[0]="Только родители";
$all=[];
foreach($rows as $row){
    if($row['parent_id']==0){$parents[$row['id']]=$row['title'];}
    $all[$row['id']]=$row['title'];
}
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'title',
                    'value' => function($model) {
                        if(!empty($model->parent->title)){$title=$model->parent->title." -> ".$model->title;}
                        else $title=$model->title;;
                        return $title;
                    },
                    //'contentOptions'=>['width'=>180]
                ],
                [
                    'attribute' => 'parent_id',
                    'value' => function($model) use ($all) {
                        if(!empty($all[$model->parent_id])){$parent=$all[$model->parent_id];}
                        else $parent='';
                        return $parent;
                    },
                    //'contentOptions'=>['width'=>180]
                ],
                'weight',
                'public',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } catch (Exception $e) {
    } ?>
</div>
