<?php
/* @var $this VolunteersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Volunteers',
);

$this->menu=array(
	array('label'=>'Create Volunteers', 'url'=>array('create')),
	array('label'=>'Manage Volunteers', 'url'=>array('admin')),
);
?>

<h1>Volunteers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
