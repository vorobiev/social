<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);
?>

<h1>Update <?php echo $model->name; ?>'s profile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>