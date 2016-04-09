<?php
/* @var $this PrivatebowlsController */
/* @var $model Privatebowls */

$this->breadcrumbs=array(
	'Privatebowls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Privatebowls', 'url'=>array('index')),
	array('label'=>'Manage Privatebowls', 'url'=>array('admin')),
);
?>

<h1>Create Privatebowls</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>