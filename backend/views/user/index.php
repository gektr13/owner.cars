<?php

use backend\models\Organization;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var backend\models\User $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'balance',
            'bonus',
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Последнее обновление',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?=


    // Renders a export dropdown menu
    ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'clearBuffers' => true, //optional
    ]);

    // You can choose to render your own GridView separately
    \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns
    ]);
    ?>


</div>
