<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="goods-form">
	<?php $form = ActiveForm::begin(['options' => ['id'=> 'upload_form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return checkForm()']]); ?>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'categories')->dropdownList($add_to_categorie, ['multiple'=>'multiple']) ?> 

		<input type="hidden" id="x1" name="x1" />
		<input type="hidden" id="y1" name="y1" />
		<input type="hidden" id="x2" name="x2" />
		<input type="hidden" id="y2" name="y2" />
		<div>
			<input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" required="required" />
		</div>
		<br>
		<div class="step2">
			<img id="preview" />
			<div class="info">
				<input type="hidden" id="filesize" name="filesize" />
				<input type="hidden" id="filetype" name="filetype" />
				<input type="hidden" id="filedim" name="filedim" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" /><br><br>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>