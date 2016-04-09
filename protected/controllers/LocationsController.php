<?php

class LocationsController extends Controller
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
				'actions'=>array('index','view','list','updateStatus','getStatus','uploadImage','getStats','adminUpdateStatus','needSponser','sponserABowl'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
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
		$model=new Locations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Locations']))
		{
			$model->attributes=$_POST['Locations'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionNeedSponser()
	{
		//$email = $_POST['email'];
		//$usermodel=Users::model()->findByAttributes(array('email'=>$email));
		$data = Locations::model()->findAllBySql("SELECT id,latitude,longitude from locations where sponser_id = 0 ");
		//print_r($data);
		echo CJSON::encode($data);
	}

	public function actionList($id)
	{
		$allArs = Locations::model()->findAll(array('condition'=>'id> :id','params'=>array(':id'=>$id)));
		echo CJavaScript::jsonEncode($allArs);
	}

	public function actionUpdateStatus()
	{
		$email = $_POST['email'];
		$id = $_POST['locationId'];

	    $status=$_POST['status'];
		
		$model=Locations::model()->findByPk($id);

		$model->status = $status;
		if($model->save()){
			echo "Success";
		}
		else{
			echo "Failed";
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

	public function actionAdminUpdateStatus()
	{

		$email = $_POST['email'];
		$id = $_POST['locationId'];

		// Get image string posted from Android App
	    $base=$_POST['image'];

	    $path = getcwd()."/uploadedimages/";
	    
	    // Decode Image
	    $binary=base64_decode($base);
	    header('Content-Type: bitmap; charset=utf-8');
	    // Images will be saved under 'www/imgupload/uplodedimages' folder
	    $file = fopen($path.$id.".png", 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);
		
		$model=Locations::model()->findByPk($id);

		$model->status = "Installed";
		if($model->save()){
			echo "Success";
		}
		else{
			echo "Failed";
		}
	}
	
	/*public function actionUpdateStatus()
	{
		$email = $_POST['email'];
		$id = $_POST['locationId'];
		$status = $_POST['status'];

		// Get image string posted from Android App
	    $base=$_REQUEST['image'];
	    
	    // Decode Image
	    $binary=base64_decode($base);
	    header('Content-Type: bitmap; charset=utf-8');
	    // Images will be saved under 'www/imgupload/uplodedimages' folder
	    $file = fopen('/var/www/html/WaterBowl/uploadedimages/'.$id.".png", 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);
		
		$model=Locations::model()->findByPk($id);

		$model->status = $status;
		if($model->save()){
			echo "Success";
		}
		else{
			echo "Failed";
		}
	}*/

	public function actionUploadImage()
	{
		// Get image string posted from Android App
	    $base=$_REQUEST['image'];
	    // Get file name posted from Android App
	    $filename = $_REQUEST['filename'];
	    // Decode Image
	    $binary=base64_decode($base);
	    header('Content-Type: bitmap; charset=utf-8');
	    // Images will be saved under 'www/imgupload/uplodedimages' folder
	    $file = fopen('uploadedimages/'.$filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);
	    echo 'Image upload complete, Please check your php file directory';
	}

	public function actionGetStatus()
	{
		$id = $_POST['locationId'];
		$model=Locations::model()->findByAttributes(array('id'=>$id));
		echo $model->status;
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

		if(isset($_POST['Locations']))
		{
			$model->attributes=$_POST['Locations'];
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
		$dataProvider=new CActiveDataProvider('Locations');
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Locations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Locations']))
			$model->attributes=$_GET['Locations'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionGetStats()
	{
		$stats = array();
		//array_push($stats,$no_requests);
		$locations = Locations::model()->findAll();
		$requests = Requests::model()->findAll();
		$volunteers=Volunteers::model()->findAll(array('select'=>'t.userid','distinct'=>true,));
         
		$stats['no_requests'] = count($requests);
		$stats['no_installs'] = count($locations);
		$stats['funds_received'] = 0;
		$stats['no_of_volunteers'] = count($volunteers);
		echo json_encode($stats);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Locations the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Locations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Locations $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='locations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
