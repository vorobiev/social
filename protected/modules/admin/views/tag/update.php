<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	$model->name=>array('view','id'=>$model->tag_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tag', 'url'=>array('index')),
	array('label'=>'Create Tag', 'url'=>array('create')),
);
?>

<h1>Update Tag <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>