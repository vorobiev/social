<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->site_id), array('view', 'id'=>$data->site_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('about')); ?>:</b>
	<?php echo CHtml::encode($data->about); ?>
	<br />


</div>