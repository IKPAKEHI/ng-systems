<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
?>
<h1>Товары</h1>


<?php
NavBar::begin([]);

$items = array();
foreach ($all_categs as $categ) {
	$items[] = array(
		'label' => $categ->name,
		'url' => "index.php?r=goods%2Findex&id={$categ->id}"
	);
}

echo Nav::widget(
	[
	    'options' => [
	        'class' => 'navbar-nav'
	    ],
	    'items' => $items,
	]);
NavBar::end();
?>
<ul class='list-group column'>
<?php foreach ($goods_by_categ as $good): ?>
	<?php $img = Html::img("{$good->img}", ['alt' => 'Наш логотип', 'class' => 'sz_good_img'])?> 
	<?= Html::tag('li',	 $good->name . '( цена ' . $good->price . ')' . $img , ['class' => 'list-group-item col-xs-6 col-sm-4 col-md-3 goods_li']) ?>

<?php endforeach; ?>
</ul>
