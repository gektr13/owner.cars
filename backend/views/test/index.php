<?php
use yii\widgets\ActiveForm;
?>

<!--Import Form-->
<h2>Import form</h2>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action' => ['import_excel_data'],'method'=>'post']) ?>

<?= $form->field($file, 'file')->fileInput() ?>

<button>Import form</button>

<?php ActiveForm::end() ?>
<!--Download Form-->
<a href="export_excel_data">Download form</a>