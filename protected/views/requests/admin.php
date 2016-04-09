<?php
/* @var $this RequestsController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Requests', 'url'=>array('index')),
	array('label'=>'Create Requests', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#requests-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Requests</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'requests-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'userid',
		'locality',
		'location',
		'latitude',
		'longitude',
		/*
		'status',
		'bowlorshed',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
