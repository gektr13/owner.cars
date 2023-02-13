<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\User $model */
/** @var yii\data\ActiveDataProvider $dataProviderTransaction */
/** @var common\models\TransactionSearch $searchModelTransaction */
/** @var yii\data\ActiveDataProvider $dataProviderBonus */
/** @var common\models\BonusSearch $searchModelBonus */


$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            [
                'attribute' => 'balance',
                'value' => function ($model) {
                    return $model->balance;
                },
            ],
            [
                'attribute' => 'bonus',
                'value' => function ($model) {
                    return $model->bonus;
                },
            ],

            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime', // Доступные модификаторы - date:datetime:time
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Псоледнее обновлнеие',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
        ],
    ]) ?>

    <?= Html::a('Пополнить баланс', ['augment-transaction', 'user_id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?= Html::a('Списать с баланса', ['deduct-transaction', 'user_id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <br><br>
    <h1>Транзакции</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProviderTransaction,
        'columns' => [


            'id',
            'value',
            'purpose',
            [
                'attribute' => 'created_at',
                'label' => 'Дата операции',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
        ],
    ]); ?>

    <br><br>
    <h1>Бонусы</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProviderBonus,

        'columns' => [


            'id',
            'transaction_id',
            'value',

            [
                'attribute' => 'created_at',
                'label' => 'Дата операции',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
        ],
    ]); ?>
</div>
