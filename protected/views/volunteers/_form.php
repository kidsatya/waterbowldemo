<?php
/* @var $this VolunteersController */
/* @var $model Volunteers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'volunteers-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
		<?php echo $form->error($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'locationid'); ?>
		<?php echo $form->textField($model,'locationid'); ?>
		<?php echo $form->error($model,'locationid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'homeoroffice'); ?>
		<?php echo $form->textField($model,'homeoroffice',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'homeoroffice'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->