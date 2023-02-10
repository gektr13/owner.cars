<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CreateTransactionAugment $model */
/** @var yii\widgets\ActiveForm $form */

?>
<div class="site-about">
    <div class="organization-form">



    </div>
</div>

<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">

        <div class="col-lg-4">

            <h2>Списание с баланса</h2>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'value')->textInput()->label('Сумма') ?>
            <?= $form->field($model, 'purpose')->textInput()->label('Назначение') ?>

            <?= $form->errorSummary($model); ?>

            <br><br>

            <div class="form-group">
                <?= Html::submitButton('Списать', ['class' => 'btn btn-success']) ?>
            </div>

            <br><br>

            <?=  Html::a( 'Back', Yii::$app->request->referrer)?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>


