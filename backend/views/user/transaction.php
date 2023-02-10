<?php


/** @var yii\web\View $this */
/** @var \backend\models\CreateTransactionAugment $model */

$this->title = 'Создание транзакции для :' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
?>
<div class="organization-update">

    <?= $this->render('_transaction', [
        'model' => $model,
    ]) ?>

</div>
