<?php

/* @var $this yii\web\View */
/* @var $page \frontend\models\Page */

use yii\helpers\Html;

$this->title = 'Admin Panel | OK Tour';
$dao=Yii::$app->db;
$today=date('Y-m-d');
//$weekAgo=date('Y-m-d',strtotime('-1 week'));

?>
<div class="site-index">

    <div class="admin-content container flex flex-wrap">
    </div>
</div>
