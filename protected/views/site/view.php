<h1><?php print $site -> name ?></h1>
<p><a href="http://<?php print $site -> url; ?>" rel="nofollow"><?php print $site -> url; ?></a></p>
<p><?php print $site -> about ; ?></p>

<h4>Теги</h4>
<div class="tags">
<?php
	
	$tags = array();
	foreach ( $site -> tags as $tag )
	{
		$tags [] = '<a href="/tag/' . $tag -> tag_id . '">' . $tag -> name . '</a>';
	}
	
	print join(', ' , $tags );
?>
</div>

<?php if ( !Yii::app() -> user -> isGuest ): ?>

<h4>Оцените сайт</h4>
<div id="voting">

<input type="hidden" name="site_id" value="<?php print $site -> site_id ?>" />

<?php $marks =  array ( 1 => '1 (самая низкая)' , 2 => '2' , 3 => '3' , 4 => '4' , 5 => '5' , 6 => '6', 7 => '7' , 8 => '8' , 9 => '9' , 10 => '10' , 11 => '11' , 12 => '12 (самая высокая)' ); ?>
<?php print CHtml::radioButtonList('mark',$value,$marks, array('separator' => ' &nbsp; ')); ?>

<br />
<br />
<input type="button" value="Оценить" id="mark_submit" />

</div>

<?php endif; ?>

<p>Средний балл: <?php print $site -> avgValue; ?></p>

<h4>Другие оценивают</h4>

<?php 

$marks = $site -> marks; 
$i = 0 ;
foreach ( $marks as $mark )
{

	if ( $mark -> user -> user_id != Yii::app()-> user -> id)
	{
		print $mark -> user -> name . ' оценил на ' . $mark -> value . ' баллов';
	}
	$i++;
}
?>
<?php if ( $i == 0 ): ?>
<p>Нет оценок.</p>
<?php endif; ?>


<h4>Комментарии</h4>

<?php if ( count ( $site -> comments  )): ?>

<?php foreach ( $site -> comments as $comment ): ?>

<div class="comment" id="comment<?php print $comment -> comment_id; ?>">
<div class="title"><span class="name"><?php print $comment -> user -> name ; ?></span> пишет в <span class="date"><?php print Yii::app()->dateFormatter->format("HH:mm dd MMMM", strtotime($comment -> date)); ?></span></div>

<div class="text"><?php print $comment -> text ;?></div>

<?php if ( Yii::app() -> user -> role == 'administrator' ): ?>
<div><a href="javascript:void(0);" onclick="delete_comment('<?php print $comment -> comment_id; ?>');">удалить комментарий</a></div>
<?php endif; ?>

</div>

<?php endforeach; ?>

<?php else: ?>

<p>Нет комментариев.</p>

<?php endif; ?>

<h4>Добавить комментарий</h4>
<?php if ( !Yii::app() -> user -> isGuest ): ?>
<form action="" method="post">
<textarea name="Comment[text]"></textarea><br />
<input type="submit" value="Добавить" />
</form>
<?php else: ?>
<p>Чтобы оставить комментарий, вам необходимо зарегистрироваться.</p>
<?php endif; ?>

