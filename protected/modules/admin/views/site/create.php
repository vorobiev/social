<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Site', 'url'=>array('index')),
);
?>

<h1>Create Site</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>