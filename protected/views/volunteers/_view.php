<?php
/* @var $this VolunteersController */
/* @var $data Volunteers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::encode($data->userid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locationid')); ?>:</b>
	<?php echo CHtml::encode($data->locationid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('homeoroffice')); ?>:</b>
	<?php echo CHtml::encode($data->homeoroffice); ?>
	<br />


</div>