<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:umi="http://www.umi-cms.ru/TR/umi" xml:lang="ru">
<head>
<title>AdMoney</title>
<link type="text/css" rel="stylesheet" href="/css/form.css" />
<style>

body {
  background: #FFF;
  font-size: 10pt !important;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  line-height: 1.5;
  color: #000;
  padding: 0;
  margin: 0;
}

h1,h2,h3,h4,h5,h6 { font-family: "Helvetica Neue", Arial, "Lucida Grande", sans-serif; }

img { float:left; margin:0; }
a img { border:none; }

#container {

  width: 100%;
  min-height: 100%;
  position: relative;

}

#menu {

  width: 100%;
  height: 100px;
}

#menu h1 { 
  width: 200px;
  float: left;
  padding: 10px;
}

#menu ul {
  float: left;
  list-style: none;
  overflow: hidden;
  padding: 10px;

}

#menu ul li {
  float: left;
  padding: 20px;
}  
 
#wrapper {
  clear: both;
  padding: 10px;
  margin-bottom: 50px;
  overflow: hidden;
}

#content {
	width: 90%;
	float: left;

}
#sidebar {
	width: 6%;
	float: left;
	padding: 2% 2% 2% 2%;
}
td {
	padding: 5px;
}
div.portlet-title {
	font-weight: bold;
	font-size: 16px;
}
ul.operations {
	list-style-type: none;
	padding: 0px !important;
}
div#baloon {
	display: none;
	z-index: 100;
	position: absolute;
	border: 1px solid #ccc;
	padding: 5px;
	height: 40px;
}
li#balooner {
	position: relative;
	cursor: pointer;
	cursor: hand;
	width: 500px;
	height: 70px;
}
li#balooner span
{
	border-bottom: 1px dashed black;
}
li#balooner:hover div#baloon {
	display: block;
}
tr.header td { 
	font-weight: bold;
}
table#report {
	border-collapse: collapse;
}
table#report td {
	padding: 7px;
}
table#report tr:hover {
	background-color: cornsilk;
}
table#report tr {
	background-color: white;
}
table#report tr:hover td a img {
	display: block;
}
table#report tr td a img {
	display: none;
}

div#menu h1 {
	text-shadow: gold 2px 2px 2px;
}

a#tools {
	text-shadow: orange 2px 0px 2px;
}

</style>
</head>
<body>
<div id="container">

  <div id="menu">
    <h1 onclick="window.location.href='/payment/';" style="cursor: pointer; cursor: hand;">AdMoney</h1>
    <?php if ( !Yii::app() -> user -> isGuest ): ?>
    <ul>
      <li><a href="/payment">Платежи</a></li>
      <li><a href="/client">Клиенты</a></li>
  	  <li><a href="/tool" id="tools">Рекламные инструменты</a></li>
      <?php if ( Yii::app() -> user -> role == 'administrator' ): ?>
      <li><a href="/user">Учетные записи</a></li>
	  <li><a href="/plan">План</a></li>
	  <?php endif; ?>
	  <li id="balooner"><span><?php print Yii::app() -> user -> name ?></span> &nbsp; <a href="/site/logout">Выход</a>
		
		
	
			<div id="baloon">
				Показатели за май: 
				<?php if ( Yii::app() -> user -> role == 'administrator' ): ?>

				мои: <?php print number_format ( Yii::app() -> db -> createCommand ( 'select sum( price_vat + comission_vat ) from payment where manager_id = ' . Yii::app() -> user -> id . ' AND payment_date LIKE "2011-05-%"' ) -> queryScalar() , 0 , ' ' , ' ' ); ?> руб. 	из <?php print number_format ( Yii::app() -> db -> createCommand ( 'select sum( sales_yandex + sales_google + sales_begun ) from plan where client_id IN ( select client_id FROM client where manager_id = ' . Yii::app() -> user -> id . ' ) AND month = 5' ) -> queryScalar() , 0 , ' ' , ' ' ); ?> руб. по плану
				<br /> общие <?php print number_format ( Yii::app() -> db -> createCommand ( 'select sum( price_vat + comission_vat ) from payment where payment_date LIKE "2011-05-%"' ) -> queryScalar() , 0 , ' ' , ' ' ); ?> руб.

			   <?php else: ?>		

				<?php print number_format ( Yii::app() -> db -> createCommand ( 'select sum( price_vat + comission_vat ) from payment where manager_id = ' . Yii::app() -> user -> id . ' AND payment_date LIKE "2011-04-%"' ) -> queryScalar() , 0 , ' ' , ' ' ); ?> руб. из <?php print number_format ( Yii::app() -> db -> createCommand ( 'select sum( sales_yandex + sales_google + sales_begun ) from plan where client_id IN ( select client_id FROM client where manager_id = ' . Yii::app() -> user -> id . ' ) AND month = 5' ) -> queryScalar() , 0 , ' ' , ' ' ); ?> руб. по плану (<a href="/plan/report">отчет</a>)

			   <?php endif; ?>
			</div>
		
		
	</li>
    </ul>
    <?php endif; ?>

	


  </div> 

  <div id="wrapper">
    <div id="content">
	<?php print $content; ?>
    </div>  
    <div id="sidebar">
    <?php
    	$this->beginWidget('zii.widgets.CPortlet', array(
    		'title'=>'Действия',
    	));
    	$this->widget('zii.widgets.CMenu', array(
    		'items'=>$this->menu,
    		'htmlOptions'=>array('class'=>'operations'),
    	));
    	$this->endWidget();
    ?>
    </div><!-- sidebar -->
  </div>
</div>


</body>
</html>
