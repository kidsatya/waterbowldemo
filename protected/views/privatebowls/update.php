<?php
/* @var $this PrivatebowlsController */
/* @var $model Privatebowls */

$this->breadcrumbs=array(
	'Privatebowls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Privatebowls', 'url'=>array('index')),
	array('label'=>'Create Privatebowls', 'url'=>array('create')),
	array('label'=>'View Privatebowls', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Privatebowls', 'url'=>array('admin')),
);
?>

<h1>Update Privatebowls <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>