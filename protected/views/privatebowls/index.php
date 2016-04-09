<?php
/* @var $this PrivatebowlsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Privatebowls',
);

$this->menu=array(
	array('label'=>'Create Privatebowls', 'url'=>array('create')),
	array('label'=>'Manage Privatebowls', 'url'=>array('admin')),
);
?>

<h1>Privatebowls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
