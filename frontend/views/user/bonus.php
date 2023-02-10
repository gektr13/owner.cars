<?php

/** @var yii\web\View $this */

use yii\grid\GridView;


$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">

        <div class="col-lg-4">

            <h2>На балансе <?= $model->bonus ?> бонусов</h2>
            <br>
            <h2>История по бонусам</h2>



            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [


                    'id',
                    'value',
                    'transaction_id',
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата операции',
                        'format' => 'datetime',
                        'headerOptions' => ['width' => '200'],
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>
