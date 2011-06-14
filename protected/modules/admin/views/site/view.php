<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Site', 'url'=>array('index')),
	array('label'=>'Create Site', 'url'=>array('create')),
	array('label'=>'Update Site', 'url'=>array('update', 'id'=>$model->site_id)),
	array('label'=>'Delete Site', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->site_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Site', 'url'=>array('admin')),
);
?>

<h1>View Site #<?php echo $model->site_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'site_id',
		'name',
		'url',
		'about',
	),
)); ?>
