<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		http://<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'about'); ?>
		<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'about'); ?>
	</div>
	
	<div>
		<label>Tags</label>
		
		<?php 
		
		$tags = array();
		 
		foreach ( $model -> tags as $tag )
		{
			$tags [] = $tag -> tag_id; 
		}
		 
		?>
		
		<?php print CHtml::checkBoxList('tags',$tags,CHtml::listData(Tag::model()->findAll(array('order'=>'name ASC')),"tag_id","name"),array('separator'=>'<br />','template'=>'{input} {label}', 'labelOptions' => array ( 'style' => 'display: inline;'))); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->