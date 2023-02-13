<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">

        <div class="col-lg-4">
            <h2>Привет <?= Yii::$app->user->identity->username ?></h2>

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


            <br><br>


            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($file, 'xlsxFile')->fileInput() ?>

            <button>Submit</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
