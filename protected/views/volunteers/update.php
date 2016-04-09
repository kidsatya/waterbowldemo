<?php
/* @var $this VolunteersController */
/* @var $model Volunteers */

$this->breadcrumbs=array(
	'Volunteers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Volunteers', 'url'=>array('index')),
	array('label'=>'Create Volunteers', 'url'=>array('create')),
	array('label'=>'View Volunteers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Volunteers', 'url'=>array('admin')),
);
?>

<h1>Update Volunteers <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>