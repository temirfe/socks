<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'title_ru',
                'title_ko',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{addDesc} &nbsp;{view}&nbsp; {update}&nbsp; {delete}',
                    'buttons' => [
                        'addDesc' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-plus-sign"></span>',
                                ['description/create', 'category_id' => $model->id],
                                [
                                    'title' => 'Add description',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]);
    } catch (Exception $e) {
    } ?>
</div>
