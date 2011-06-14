<?php
$this->breadcrumbs=array(
	'Sites',
);

$this->menu=array(
	array('label'=>'Create Site', 'url'=>array('create')),
	array('label'=>'Manage Site', 'url'=>array('admin')),
);
?>

<h1>Sites</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
