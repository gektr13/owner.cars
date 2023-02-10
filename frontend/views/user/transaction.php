<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">

        <div class="col-lg-4">
            <h2>На балансе <?= $model->balance ?> руб.</h2>
            <br>
            <h2>История транзакций</h2>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
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


            <br>
            <h2>Cовершить операцию</h2>


            <?= Html::a('Списать с баланса', ['deduct-transaction', 'user_id' => $model->id], ['class' => 'btn btn-primary']) ?>

        </div>
    </div>
</div>
