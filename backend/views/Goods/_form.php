<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<p>Перед тем как загрузить картинку на сервер, она должна быть сжата или обрезана до 300х300.<p>
<p>Что бы расстянуть картинку потяните за чёрный квадрат.<p>
<p>Что бы обрезать картинку нажмите на её.<p>
<div class="goods-form">
	<?php $form = ActiveForm::begin(['options' => ['id'=> 'upload_form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return checkForm()']]); ?>
		<input type="hidden" id="x1" name="x1" />
		<input type="hidden" id="y1" name="y1" />
		<input type="hidden" id="x2" name="x2" />
		<input type="hidden" id="y2" name="y2" />
		<input type="hidden" id="img_width" name="img_width" />
		<input type="hidden" id="img_height" name="img_height" />
		<div>
			<input type="file"  name="image_file" id="image_file" onchange="fileSelectHandler(this)" required="required" />
		</div>
		<br>
		<div class="step2">
			<div>
				<img id="preview" src="http://placehold.it/180" alt="your image" onclick="make_jcrop()" />
				<div onmousedown="saveWH()"><div id="block_resize" ></div></div>
			</div>
			<div class="info">
				<input type="hidden" id="filesize" name="filesize" />
				<input type="hidden" id="filetype" name="filetype" />
				<input type="hidden" id="filedim" name="filedim" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" /><br><br>
			</div>
		</div>

		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'categories')->dropdownList($add_to_categorie, ['multiple'=>'multiple']) ?>
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success', 'onmousemove' => 'check_img1()']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>