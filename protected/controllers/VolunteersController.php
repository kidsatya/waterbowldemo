<?php

class VolunteersController extends Controller
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
				'actions'=>array('index','view','createVolunteer','myBowls','myBowlsTest'),
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
		$model=new Volunteers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Volunteers']))
		{
			$model->attributes=$_POST['Volunteers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionMyBowlsTest()
	{
		$email = $_POST['email'];
		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		$id = $usermodel->id;
		$allArs = Locations::model()->findAllBySql('SELECT * FROM locations where id IN (SELECT locationid FROM volunteers where userid = '.$id.')');
		//echo 'SELECT * FROM locations where id IN (SELECT locationid FROM volunteers where userid = '.$id.')';
		echo CJavaScript::jsonEncode($allArs);
	}

	public function actionMyBowls()
	{
		$email = $_POST['email'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		$id = $usermodel->id;
		$allArs = Locations::model()->findAllBySql('SELECT * FROM locations where id IN (SELECT locationid FROM volunteers where userid = '.$id.')');
		//echo 'SELECT * FROM locations where id IN (SELECT locationid FROM volunteers where userid = '.$id.')';
		$bowls = array();
		foreach ($allArs as $row) {
			//print_r($row['latitude']);
			$d = $this->distance($row['latitude'],$row['longitude'],$latitude,$longitude,"K");
			if($d <= 0.1)
			array_push($bowls, $row);
		}
		echo CJavaScript::jsonEncode($bowls);
	}

	public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
//echo $lat2;echo " - ";echo $lat1;echo " - ";echo $lon1;echo " - ";echo $lon2;echo " - ";
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
	    return ($miles * 1.609344);
	  } else if ($unit == "N") {
	      return ($miles * 0.8684);
	    } else {
	        return $miles;
	      }
	}

	public function actionCreateVolunteer()
	{
		$model=new Volunteers;

		$email = $_POST['email'];
		$usermodel=Users::model()->findByAttributes(array('email'=>$email));

		$results1 = Volunteers::model()->findAllByAttributes(array('locationid'=>$_POST['locationId']));
		$count1 = count ( $results1 );

		if($count1 == 0){

		$results = Volunteers::model()->findAllByAttributes(array('userid'=>$usermodel->id));
		$count = count ( $results );

		if($count < 2){

		$model->userid = $usermodel->id;
		$model->locationid = $_POST['locationId'];
		$model->homeoroffice = $_POST['homeoroffice'];
			
		if($model->save()){
			echo "Success";
		}
		else
			echo "Failed";
		}
		else{
			echo "You Already Volunteered For ".$count." locations";
		}
		}
		else{
			echo "You Already Volunteered for this bowl";
		}
		
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

		if(isset($_POST['Volunteers']))
		{
			$model->attributes=$_POST['Volunteers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Volunteers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Volunteers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Volunteers']))
			$model->attributes=$_GET['Volunteers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Volunteers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Volunteers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Volunteers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='volunteers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
