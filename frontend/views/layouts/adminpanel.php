<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<div class="admin_panel">
    <div class="container text-right">
        <?php
        echo Html::a('Товары','/product/admin');
        echo Html::a('Категории','/category');
        echo Html::a('Баннеры','/banner');
        echo Html::a('Страницы','/page');
        echo Html::a('Данные','/lookup');
        echo Html::a('Пользователи','/user');
        if($user->id){
            echo Html::a(Yii::t('app','Logout').' ('.$user->identity->username.')',
                ['/site/logout'],[ 'data-method'=>'post','class'=>'pull-right']);
        }
        ?>
    </div>
</div>
