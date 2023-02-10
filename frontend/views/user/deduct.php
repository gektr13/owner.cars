<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'My Yii Application';
?>
<div class="organization-update">

    <?= $this->render('_transaction', [
        'model' => $model,
    ]) ?>

</div>
