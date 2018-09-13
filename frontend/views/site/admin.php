<?php

/* @var $this yii\web\View */
/* @var $page \frontend\models\Page */

use yii\helpers\Html;

$this->title = 'Admin Panel | OK Tour';
$dao=Yii::$app->db;
$today=date('Y-m-d');
//$weekAgo=date('Y-m-d',strtotime('-1 week'));
$books = $dao->createCommand("SELECT id FROM book WHERE date_format(FROM_UNIXTIME(`created_at`), '%Y-%m-%d')='{$today}'")->queryAll();

?>
<div class="site-index">

    <div class="admin-content container flex flex-wrap">
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Bookings'), ['/book'])?></h2>
            <div>
                <span class="menu_box_label"><?=Yii::t('app','Bookings today')?>:</span>
                <span class="menu_box_result"><?=count($books)?></span>
            </div>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Tours'), ['/tour'])?></h2>
            <div class="menu_box_link">
                <?=Html::a(Yii::t('app','Add').' '.Yii::t('app','Tour'), ['/tour'])?>
            </div>
        </div>

        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Prices'), ['/price'])?></h2>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Tour types'), ['/category'])?></h2>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Countries'), ['/destination'])?></h2>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Pages'), ['/page'])?></h2>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Lookups'), ['/lookup'])?></h2>
        </div>
        <div class="menu_box">
            <h2><?=Html::a(Yii::t('app','Users'), ['/user'])?></h2>
        </div>
    </div>
</div>
