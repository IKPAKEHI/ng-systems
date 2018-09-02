<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Countries</h1>
<ul>
<?php foreach ($countries as $country): ?>
	<?= Html::tag('li', Html::encode("{$country->code} ({$country->name}) {$country->population}"), ['class' => 'username']) ?>
<?php endforeach; ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>