<?php
$this->breadcrumbs=array(
	'Sites'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Site', 'url'=>array('create')),
);

?>

<h1>Manage Sites</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'name',
		'url',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
