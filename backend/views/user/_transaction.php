<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CreateTransactionAugment $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput() ?>
    <?= $form->field($model, 'purpose')->textInput() ?>

    <?= $form->errorSummary($model); ?>

    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <br><br>

    <?=  Html::a( 'Back', Yii::$app->request->referrer)?>

    <?php ActiveForm::end(); ?>

</div>
