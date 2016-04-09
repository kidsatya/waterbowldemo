<?php

class RequestsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','createRequest','approved','getRequests','placeabowl','sponserABowl','buyABowl'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new Requests;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreateRequest()
	{

		$model=new Requests;

		$email = $_POST['email'];
		$bowlorshed = $_POST['bowlorshed'];
		$locality = $_POST['locality'];
		$location = $_POST['location'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$city = $_POST['city'];

		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		if($usermodel == null){
			echo "User Does Not Exist";
		}	
		else{

			$results = Requests::model()->findAllByAttributes(array('userid'=>$usermodel->id));
			$count = count ( $results );

			$cities = City::model()->findAllByAttributes(array('name'=>$city));
			$countofcities = count ( $cities );			

			if($countofcities != 0){
			if($count < 1 || $usermodel->isAdmin == "yes"){

			$model->userid = $usermodel->id;
			$model->locality = $locality;
			$model->location = $location;
			$model->latitude = $latitude;
			$model->longitude = $longitude;
			$model->status = "waiting";
			$model->bowlorshed = $bowlorshed;
			$model->city = $city;
			if($model->save())
				echo "Success";
			else{
				echo "Failed";
			}
			}
			else{
				echo "You Already Requested ".$count." Bowls/Shed";
			}
			}
			else{
				echo "We are Currently Not Operating In ".$city;
			}
		}
	}

	public function actionSponserABowl()
	{
		
		$email = $_POST['email'];
		$id = $_POST['id'];

		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		$model=$this->loadModel($id);
		$model->sponser_id = $usermodel->id;

		if($model->save())
			echo "Success";
		else{
			echo "Failed";
		}

	}

	public function actionBuyABowl()
	{
		$model=new Privatebowls;

		$email = $_POST['email'];
		$bowlType = $_POST['bowlType'];
		$locality = $_POST['locality'];
		$location = $_POST['location'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$amount = $_POST['amount'];
		$city = $_POST['city'];

		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		if($usermodel == null){
			echo "User Does Not Exist";
		}	
		else{

			$model->userid = $usermodel->id;
			$model->locality = $locality;
			$model->location = $location;
			$model->latitude = $latitude;
			$model->longitude = $longitude;
			$model->status = "waiting";
			$model->bowltype = $bowlType;
			$model->amount = $amount;
			$model->city = $city;
			if($model->save())
				echo "Success";
			else{
				echo "Failed";
			}
			
		}
	}

	public function actionApproved($rId)
	{
		// API access key from Google API's Console
		define( 'API_ACCESS_KEY', 'AIzaSyDPlIhBe9bOqvYF061C_LHWvPlvcvYeoPk' );


		$registrationIds = array( $rId );//array( $_GET['id'] );

		// prep the bundle
		$msg = array
		(
			'message' 	=> 'Your Request Approved',
			'title'		=> 'Status',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);

		$fields = array
		(
			'registration_ids' 	=> $registrationIds,
			'data'			=> $msg
		);
		 
		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );

		echo $result;
	}

	public function actionGetRequests()
	{
		//$email = $_POST['email'];
		//$usermodel=Users::model()->findByAttributes(array('email'=>$email));
		$data = Requests::model()->findAllBySql("SELECT id,latitude,longitude from requests where sponser_id = 0 ");
		//print_r($data);
		echo CJSON::encode($data);
	}

	public function actionplaceabowl()
	{
		//echo $_POST['reqId'];
		//echo $_POST['email'];
		echo "Success";
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

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			$user = Users::model()->findByAttributes(array('id'=>$model->userid));
			if($model->save()){				

				if($model->status == "Approved"){
					$location_model=new Locations;
					$location_model->locality = $model->locality;
					$location_model->location = $model->location; 
					$location_model->city = $model->city;
					$location_model->latitude = $model->latitude;
					$location_model->longitude = $model->longitude;
					$location_model->rid = $model->id;

					$results = Locations::model()->findAllByAttributes(array('rid'=>$model->id));
					$count = count ( $results );

					if($count == 0){

					if($location_model->save()){
						//$this->actionApproved($user->regId);
						$this->redirect(array('view','id'=>$model->id));
					}
					}
					else{
						$this->redirect(array('view','id'=>$model->id));
					}
				}
				else{
					$this->redirect(array('view','id'=>$model->id));
				}
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Requests');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Requests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requests']))
			$model->attributes=$_GET['Requests'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Requests the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Requests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Requests $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='requests-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
