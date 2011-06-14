<?php

class SiteController extends Controller
{
	
	public $layout = 'common';
 	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$sites = array();
		
		$_ids = array();
		
		if ( !Yii::app() -> user -> isGuest )
		{
		
			$_ids = Yii::app() -> db -> createCommand('SELECT site.site_id FROM site WHERE site_id NOT IN ( SELECT DISTINCT ( site_id ) FROM mark WHERE user_id = ' . Yii::app() -> user -> id . ' )') -> queryColumn();
		}
		
		
		$ids = join(',',$_ids) ;
		
		if ( empty ( $ids ))
		{
			$sites = Site::model() -> findAll(array('order'=>'RAND()','limit'=>10));
		}
		else
		{
			$sites = Site::model() -> findAll(array('condition'=>'site_id IN ( ' . $ids . ')', 'order'=>'RAND()','limit'=>10));
		}
		 
		
				
		
		$tags = Tag::model() -> findAll(array('order'=>'RAND()','limit'=>10));
		
		$this->render('index',array('sites'=>$sites,'tags'=>$tags));
	}
	
	public function actionView()
	{
		
		
		if ( !isset ( $_GET [ 'id' ] ))
		{
			throw new CHttpException(404,'Страница не найденa');
		}
		else
		{
			$site_id = $_GET [ 'id' ];
			$site = Site::model() -> findByPk ( $site_id );
			
			if ( $site == null )
			{
				throw new CHttpException(404,'Страница не найденa');
			}
			else
			{
			
				$value = '';
			
				if ( !Yii::app() -> user -> isGuest )
				{
			
					$mark = Mark::model() -> find('site_id = :site_id AND user_id = :user_id' , array ( 'site_id' => $site -> site_id , 'user_id' => Yii::app() -> user -> id ));
				
				
					if ( $mark != null )
					{
						$value = $mark -> value ;
					}
					
					
					if ( $_POST )
					{
						$comment = new Comment ;
						$comment -> attributes = $_POST [ 'Comment' ];
						$comment -> user_id = Yii::app() -> user -> id ;
						$comment -> site_id = $site -> site_id ;
						$comment -> date = date ( 'Y-m-d H:i:s' );
						$comment -> save();
						
						$this -> redirect ( array ( 'view' , 'id' => $site -> site_id ));

					}
					
				}
						
				
				$this -> render ( 'view' , array ( 'site' => $site , 'value' => $value ));
			}
		}
	
	
	}
	
	public function actionDeletecomment()
	{
		if ( Yii::app()-> request ->isAjaxRequest && !Yii::app() -> user -> role != 'adminstrator' && isset ( $_POST [ 'comment_id' ] ) )
		{
			$comment = Comment::model() -> findByPk ( $_POST [ 'comment_id' ] );
			if ( $comment )
			{
				$comment -> delete();
				print 'Комментарий удален';
			}
		}
		else
		{
			throw new CHttpException ( 404 , 'Страница не найдена' );
		}
		
	}
	
	public function actionMark()
	{
		
		if ( Yii::app()-> request ->isAjaxRequest && !Yii::app() -> user -> isGuest )
		{
		
			if ( !isset ( $_GET [ 'id' ] ))
			{
				throw new CHttpException(404,'Страница не найденa');
			}
			else
			{
				$site_id = $_GET [ 'id' ];
				$site = Site::model() -> findByPk ( $site_id );
				
				if ( $site == null )
				{
					throw new CHttpException(404,'Страница не найденa');
				}
				else
				{
				
					$mark = Mark::model() -> find('site_id = :site_id AND user_id = :user_id' , array ( 'site_id' => $site -> site_id , 'user_id' => Yii::app() -> user -> id ));
					
					if ( $mark != null )
					{
						$mark -> delete();
					}
					
					$mark = new Mark;
					
					$mark -> user_id = Yii::app() -> user -> id; 
					$mark -> site_id = $site_id ;
					$mark -> value = $_POST [ 'value' ] ;
					
					$mark -> save() ;
					
					print 'Ваш голос учтен';
					
					Yii::app() -> end();
					
					
				}
			}
		
		}
		else
		{
			throw new CHttpException ( 404 , 'Страница не найдена' );
		}
	
	}
	
	

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}