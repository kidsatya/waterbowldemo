<?php
/* @var $this PrivatebowlsController */
/* @var $model Privatebowls */

$this->breadcrumbs=array(
	'Privatebowls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Privatebowls', 'url'=>array('index')),
	array('label'=>'Create Privatebowls', 'url'=>array('create')),
	array('label'=>'Update Privatebowls', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Privatebowls', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Privatebowls', 'url'=>array('admin')),
);
?>

<h1>View Privatebowls #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userid',
		'locality',
		'location',
		'latitude',
		'longitude',
		'status',
		'bowltype',
		'amount',
	),
)); ?>
