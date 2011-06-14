<?php

class PlanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'roles'=>array('administrator','accountant','manager'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Plan;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Plan']))
		{
			$model->attributes=$_POST['Plan'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Plan']))
		{
			$model->attributes=$_POST['Plan'];
			if($model->save())
				$this->redirect(array('index?Plan[month]=' . $model -> month ));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	public function actionFullfill()
	{
	
	
		$ids = Yii::app() -> db -> createCommand("SELECT client_id
FROM client
WHERE client_id NOT
IN (

SELECT client_id
FROM `plan`
WHERE MONTH =5
)") -> queryAll();


		foreach ( $ids as $id )
		{
			$_id = $id [ 'client_id' ];
			
			$plan = new Plan;
			
			$plan -> client_id = $_id ;
			$plan -> month = 5;
			
			
		//	$plan -> sales = 0;
		//	$plan -> extra_sales = 0;
			
		//	$plan -> save();
			
		}
	
	/*
		$plans = Plan::model() -> findAll( 'month = 3' );
		
		foreach ( $plans as $plan )
		{
			
			$plan_apr = Plan::model() -> find ( 'month = 4 AND client_id = ' . $plan -> client_id );
			
			if ( $plan_apr != null )
			{
			
				if ( $plan_apr -> sales_yandex == 0 )
				{
					$plan_apr -> sales_yandex = $plan -> sales_yandex ;
				}
			
				if ( $plan_apr -> sales_google == 0 )
				{
					$plan_apr -> sales_google = $plan -> sales_google ;
				}
			
				$plan_apr -> save();

			}
			

			
			$plan_may = Plan::model() -> find ( 'month = 5 AND client_id = ' . $plan -> client_id );

			if ( $plan_may != null )
			{

				if ( $plan_may -> sales_yandex == 0 )
				{
					$plan_may -> sales_yandex = $plan -> sales_yandex ;
				}
			
				if ( $plan_may -> sales_google == 0 )
				{
					$plan_may -> sales_google = $plan -> sales_google ;
				}
			
				$plan_may -> save();
			
			}
			
		}
		
	
	
	/*
		$plans = Plan::model() -> findAll ( 'month = 5' );
		foreach ( $plans as $plan )
		{
			
			print $plan -> client_id ;
			
			/*
			$pl = Plan::model() -> find( 'month = 5 AND client_id = ' . $plan -> client_id );
			
			if ( $pl != null )
			{
			
			$pl -> attributes = $plan -> attributes ;
			$pl -> month = 5;
			$pl -> save();
			
			}
			
			
		}
		
	


	
	$clients = Client::model() -> findAll(array('order' => 'second_name'));
		
		
		foreach ( $clients as $client )
		{
			$plan = new Plan;
			
			$old_plan = Plan::model() -> find('month = 4 AND client_id = ' . $client -> client_id );
			
			if ( $old_plan != null )
			{
				
				$plan -> attributes = $old_plan -> attributes ;
			}

			$plan -> client_id = $client -> client_id;
			$plan -> month = 5;
			
			
		//	$plan -> sales = 0;
		//	$plan -> extra_sales = 0;
			
			$plan -> save();
			
			print $client -> second_name . ' - OK<br />';
		}
		
*/		
		Yii::app() -> end();
		
	}
	
	public function actionReport()
	{
		$users = array();
		
		$month = date ( 'm' ) - 1 ;
		
		if ( isset ( $_GET [ 'month' ] ))
		{
			$month = intval ( $_GET [ 'month' ] );
		}
		
		
		if ( Yii::app() -> user -> role == 'manager' )
		{
			$users = User::model() -> findAll ( array ( 'condition' => 'user_id = ' . Yii::app() -> user -> id , 'order' => 'name' ));

		}
		else
		{
			$users = User::model() -> findAll ( array ( 'condition' => '(role = 1 OR role = 100 ) AND user_id != 7 AND user_id != 9 AND user_id != 1' , 'order' => 'name' ));
		}
		
		$this->render('report',array(
			'users' => $users,
			'month' => $month
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Plan('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Plan']))
		{
			$model->attributes=$_GET['Plan'];
			 
		}
		
	

		if ( !isset ( $_GET [ 'Plan' ] [ 'month'] )) 
		{
			$model -> month = date ( 'm' ) - 1;	
		} 
		else
		{
			$model -> month = intval ( $_GET [ 'Plan' ] [ 'month'] );	
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Plan::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='plan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
