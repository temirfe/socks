<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\UserSearch */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$role='';
$user=Yii::$app->user;
if(isset($user->identity->role->title)){$role=$user->identity->role->title;}

/*
 $auth = Yii::$app->authManager;
 foreach($auth->getRoles() as $roleObj){
    echo $roleObj->name."<br />";
}*/
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            [
                'attribute'=>'username',
                'format'=>'html',
                'value' => function ($data) use($role) {
                    $link=Html::a($data->username,['view','id'=>$data->id]);
                    if($role=='admin' && $data->role->title=='investor'){
                        $link=Html::a($data->username,['/site/index','view'=>'investor','investor_id'=>$data->id]);
                    }
                    else if($role=='admin' && $data->role->title=='customer'){
                        $link=Html::a($data->username,['/site/index','view'=>'customer','user_id'=>$data->id]);
                    }
                    return $link;
                },
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            [
                'attribute'=>'updated_at',
                'value' => function ($data) {
                    return Yii::$app->formatter->asDatetime($data->updated_at);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
