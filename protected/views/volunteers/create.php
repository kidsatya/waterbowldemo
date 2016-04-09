<?php
/* @var $this VolunteersController */
/* @var $model Volunteers */

$this->breadcrumbs=array(
	'Volunteers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Volunteers', 'url'=>array('index')),
	array('label'=>'Manage Volunteers', 'url'=>array('admin')),
);
?>

<h1>Create Volunteers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>