<?php

class PaymentController extends Controller
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
		$model=new Payment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Payment']))
		{
			$model->attributes=$_POST['Payment'];
			if ( empty ( $model -> account_number ))
			{
				$model -> account_number = 0;
			}
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

		if(isset($_POST['Payment']))
		{
			$model->attributes=$_POST['Payment'];
			
			if($model->save())
			{
				
				if ( Yii::app() -> user -> role == 'accountant' )
				{
					
					$manager = $model -> client -> manager ;
					

					$message = '<p>' . $manager -> name . ',</p>';
					$message .= '<p>' . Yii::app() -> user -> name . ' обновила данные <a href="http://admoney.localhost/payment/' . $id . '">счета</a> ' . $model -> client -> legal_name . ' от ' . date ( 'd.m.Y' , strtotime( $model -> date )) . '</p>';

					Yii::import('application.extensions.phpmailer.JPhpMailer');
					$mail = new JPhpMailer;
					$mail->IsSMTP();
					$mail->Host = 'mail.morizo.ru';
					$mail->SMTPAuth = true;
					$mail->Username = 'vorobiev@morizo.ru';
					$mail->Password = 'anton';
					$mail->SetFrom('no-reply@morizo.ru', 'AdMoney');
					$mail->Subject = 'Запрос номера счета из AdMoney';
					$mail->CharSet = 'UTF-8'; 
					$mail->AltBody = 'Для просмотра сообщения нужно включить режим HTML';
					$mail->MsgHTML($message);
					$mail->AddAddress( $manager -> email  , $manager -> name );
					$mail->Send();
					

				}
		
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionPrint($id)
	{
		$model=$this->loadModel($id);
	
		$this -> renderPartial ( 'print' , array( 'model' => $model ) , false, true );
	}

	public function actionNotify($id)
	{
		$model=$this->loadModel($id);
		
		$accountant = User::model() -> find('role = 10');
		
		$message = '<p>' . $accountant -> name . ',</p>';
		$message .= '<p>Необходимо проставить номер счета в одном из счетов в AdMoney<p>';
		$message .= '<p>Пожалуйста, <a href="http://admoney.localhost/payment/update/' . $id . '">пройдите по ссылке</a></p>';
		
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP();
		$mail->Host = 'mail.morizo.ru';
		$mail->SMTPAuth = true;
		$mail->Username = 'vorobiev@morizo.ru';
		$mail->Password = 'anton';
		$mail->SetFrom('no-reply@morizo.ru', 'AdMoney');
		$mail->Subject = 'Запрос номера счета из AdMoney';
		$mail->CharSet = 'UTF-8'; 
		$mail->AltBody = 'Для просмотра сообщения нужно включить режим HTML';
		$mail->MsgHTML($message);
		$mail->AddAddress( $accountant -> email  , $accountant -> name );
		$mail->Send();

	
		$this -> render ( 'notify' );
	
	}
	
	public function actionFill()
	{
		$payments = Payment::model() -> findAll ();
		
		foreach ( $payments as $payment )
		{
			if ( $payment -> month_rk == 'декабрь' )
			{
				$payment -> month_rk = '2010-12-01' ;
			}

			if ( $payment -> month_rk == 'Январь' )
			{
				$payment -> month_rk = '2011-01-01' ;
			}
			
			if ( $payment -> month_rk == 'февраль' )
			{
				$payment -> month_rk = '2011-02-01' ;
			}
			
			if ( $payment -> month_rk == 'март' )
			{
				$payment -> month_rk = '2011-03-01' ;
			}
			
			$payment -> save();
			
		}
	}
	
	public function actionClone($id)
	{
		$model=$this->loadModel($id);
	
		$payment = new Payment;
		
		$payment -> attributes = $model -> attributes ;
		
		$payment -> unsetAttributes ( array ( 'payment_id' , 'month_rk' , 'account_rk' , 'date' , 'payment_date' , 'deadline', 'account_number' , 'comment' ));
		
		$payment -> deadline = date ( 'Y-m-d' , strtotime ( date ( 'Y-m-d' , strtotime($model -> deadline )) . ' + 1 month' ));
		
		$payment -> save();
	
		$this -> redirect('/payment/update/'. $payment -> payment_id );
	
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	
	public function actionIndex()
	{
		$model=new Payment('search');
		$model->unsetAttributes();  // clear any default values
		
		
		if ( Yii::app() -> user -> role == 'manager' )
		{
			$model -> findAll( array ( 'condition' => 'manager_id = ' . Yii::app() -> user -> id )) ;
		}
		
		
		if(isset($_GET['Payment']))
		{
			$model->attributes=$_GET['Payment'];
			//print_r ( $model -> attributes );
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
		$model=Payment::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
