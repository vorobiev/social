<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	$model->name=>array('view','id'=>$model->site_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Site', 'url'=>array('index')),
	array('label'=>'Create Site', 'url'=>array('create')),
);
?>

<h1>Update <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>