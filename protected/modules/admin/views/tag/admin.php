<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Tag', 'url'=>array('create')),
);

?>

<h1>Manage Tags</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tag-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
