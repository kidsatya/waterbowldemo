<?php
/* @var $this VolunteersController */
/* @var $model Volunteers */

$this->breadcrumbs=array(
	'Volunteers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Volunteers', 'url'=>array('index')),
	array('label'=>'Create Volunteers', 'url'=>array('create')),
	array('label'=>'Update Volunteers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Volunteers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Volunteers', 'url'=>array('admin')),
);
?>

<h1>View Volunteers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userid',
		'locationid',
		'homeoroffice',
	),
)); ?>
