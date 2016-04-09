<?php
/* @var $this VolunteersController */
/* @var $model Volunteers */

$this->breadcrumbs=array(
	'Volunteers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Volunteers', 'url'=>array('index')),
	array('label'=>'Create Volunteers', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#volunteers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Volunteers</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'volunteers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'userid',
		'locationid',
		'homeoroffice',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
