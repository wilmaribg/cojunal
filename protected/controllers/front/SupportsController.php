<?php

class SupportsController extends GxController {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $session = Yii::app()->session;
        if(!isset($session['cojunal'])){
            $this->actionLogout();       
        }
        
    }

    public function actionCreate() {
        try{
            $idSupport = $_REQUEST['idSupport'];
            $idOldFname = $_REQUEST['idOldFname'];
            $idOldFtype = $_REQUEST['idOldFtype'];
            if(isset($idSupport)&&($idSupport != '')){
                echo "load Model";
                $model = Supports::model()->findByPk($idSupport);
            }else{
                $model = new Supports;
            }       
            $date = new Datetime();                
            $this->performAjaxValidation($model, 'frmSupports');
            if (isset($_POST['Supports'])) {

                Yii::import('application.google.google.*');
                require_once("protected/google/autoload.php");

                $configuration = array(
                    'login'   =>'cojunal@cojunal-148320.iam.gserviceaccount.com',
                    'key'     =>file_get_contents('assets/cojunal-5498ea4f2a1c.p12'),
                    'scope'   => 'https://www.googleapis.com/auth/devstorage.full_control',
                    'project' => 'cojunal-148320',
                    'storage' => array(
                        'url'    => 'https://storage.googleapis.com/',
                        'prefix' => ''),
                );
                Yii::log("GOOGLE => " .sys_get_temp_dir(), "warning" , "create");
                $model->setAttributes($_POST['Supports']);

                $file=CUploadedFile::getInstance($model, 'fileP');

                $bucket = 'cojunal-148320.appspot.com';
                $path = $model->idWallet.'/'.$model->fileName.".".$file->getExtensionName();
                $removePath=$model->idWallet.'/'.$idOldFname.'.'.$idOldFtype;
                Yii::log("rpath: ".$removePath, "warning", "actionCreate");
                $downloadPath = $configuration['storage']['url'] . $bucket . '/' . $path;

                $model->fileType = $file->getExtensionName();
                $model->dCreation = $date->format('Y-m-d H:i:s');
                $model->file = $downloadPath;
                $model->dFile = $this->convertDate($model->dFile);             
                
                if ($model->save()) {
                    Yii::log("Error Supports", "warning", "actionCreate");
                    Yii::log(var_export($model->getErrors(), true), "error", "actionCreate");
                    if (Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->end();                    
                    }else{
                        try{
                            //Upload del archivo
                            $file->saveAs(Yii::getPathOfAlias("webroot")."/uploads/".$model->fileName.".".$file->getExtensionName());
                            //Subir archivo a bucket
                            $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
                            $client = new Google_Client();
                            $client->setAssertionCredentials($credentials);
                            if ($client->getAuth()->isAccessTokenExpired()) {
                                $client->getAuth()->refreshTokenWithAssertion();
                            }

                            # Starting Webmaster Tools Service
                            $storage = new Google_Service_Storage($client);
                            if(isset($idSupport)&&($idSupport != '')){
                                echo "pre";
                                $storage->objects->delete($configuration['storage']['prefix'] . $bucket, $removePath);
                                echo "post";
                            }
                            $uploadDir = 'uploads/';
                            $fname = $model->fileName.".".$file->getExtensionName();
                            $file_name = $model->idWallet."/".$fname;
                            $obj = new Google_Service_Storage_StorageObject();
                            $obj->setName($file_name);
                            try{
                                $storage->objects->insert(
                                    "cojunal-148320.appspot.com",
                                    $obj,
                                    ['name' => $file_name, 'data' => file_get_contents($uploadDir.$fname), 'uploadType' => 'media','predefinedAcl' => 'publicRead']
                                );
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $current_user=Yii::app()->user->id;
                                $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
                            }catch (Exception $e){
                                Yii::log("Error Save Support " . print_r($e->getMessage(),true) , "error" , "create" );
                                $model->delete();
                                Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo guardar el soporte"));
                                $current_user=Yii::app()->user->id;
                                $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
                            }
                            
                        }catch (Exception $e){
                            Yii::log("Error Save Support " . print_r($e->getMessage(),true) , "error" , "create" );
                            $model->delete();
                            Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo guardar el soporte"));
                            $current_user=Yii::app()->user->id;
                            $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
                        }                        
                    }
                }
            }   
        }catch (Exception $e){
            Yii::app()->user->setFlash("error", Yii::t('app', "No se han podido subir los dats"));
            $current_user=Yii::app()->user->id;
            $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
        }
        $current_user=Yii::app()->user->id;
        $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']); 
        	
	}

    public function actionGetFile(){
        $idWallet = $_REQUEST['idWallet'];
        $fileName = $_REQUEST['fileName'];

        Yii::import('application.google.google.*');
        require_once("protected/google/autoload.php");

        $configuration = array(
            'login'=>'cojunal@cojunal-1378.iam.gserviceaccount.com',
            'key'=>file_get_contents('cojunal-38f2b0732bac.p12'),
            'scope' => 'https://www.googleapis.com/auth/devstorage.full_control',
            'project' => 'cojunal-1378',
            'storage' => array(
                'url' => 'https://storage.googleapis.com/',
                'prefix' => '')
        );

        $credentials = new Google_Auth_AssertionCredentials($configuration['login'], $configuration['scope'], $configuration['key']);
        $client = new Google_Client();
        $client->setAssertionCredentials($credentials);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion();
        }
         
        # Starting Webmaster Tools Service
        $storage = new Google_Service_Storage($client);
        $bucket = 'cojunal-1378.appspot.com';
        $path = $idWallet.'/'.$fileName;

        $file = file_get_contents($configuration['storage']['url'] . $bucket . '/' . $path);
        header("content-type: image/your_image_type");
        echo $file;

    }

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Supports');
		$this->performAjaxValidation($model, 'supports-form');
		if (isset($_POST['Supports'])) {
			$model->setAttributes($_POST['Supports']);
			if ($model->save()) {
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('dashboard'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'Supports')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('dashboard'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Supports('search');
		$model->unsetAttributes();
		if (isset($_GET['Supports'])){
			$model->setAttributes($_GET['Supports']);
                }
		$this->render('dashboard', array('model' => $model));
	}

    private function convertDate($date){
        $months=array(
            'Enero'      =>'01',
            'Febrero'    =>'02',
            'Marzo'      =>'03',
            'Abril'      =>'04',
            'Mayo'       =>'05',
            'Junio'      =>'06',
            'Julio'      =>'07',
            'Agosto'     =>'08',
            'Septiembre' =>'09',
            'Octubre'    =>'10',
            'Noviembre'  =>'11',
            'Diciembre'  =>'12',
        );

        $newDate = str_replace(',', '', $date);
        $trueDate = explode(' ', $newDate);

        $day = $trueDate[0];
        $month = $months[$trueDate[1]];
        $year = $trueDate[2];

        $defDate = $year.'-'.$month.'-'.$day;

        return $defDate;
    }

    public function actionFilter(){
        $id = $_GET['idSupport'];   
        $wallet = $_GET['wallet'];
        Yii::log("File Support " . $id . "/" . $wallet , "warning");    
        if($id==0){
            $model = Supports::model()->findAllByAttributes(array("idWallet"=>$wallet));
        }else{
            $model = Supports::model()->findAllByAttributes(array("idsupports"=>$id,"idWallet"=>$wallet));
        }   
        $table = "";     
        foreach ($model as $support) {
                $tr =  "<tr>"
                        ."<td class=\"txt_center\">" . $support->fileName  . "</td>"
                        ."<td class=\"txt_center\">".$support->fileType ."</td>"
                        ."<td class=\"txt_center\">" . date("d/m/Y",strtotime($support->dFile)) ."</td>"
                        ."<td class=\"txt_center icon_table\">"
                        ."  <a href=\"".$support->file."\" class=\"inline padding tooltipped\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Descargar\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>"
                        ."  <a href=\"#new_sporte_modal\" " 
                        ."     class=\"inline padding tooltipped editSoporte modal_clic\" "
                        ."     data-position=\"top\" "
                        ."     data-delay=\"50\" "
                        ."     data-tooltip=\"Editar\" "
                        ."     data-id=\"" .$support->idsupports . "\" "
                        ."     data-fileName=\"" . $support->fileName ."\" "
                        ."     data-fileType=\"". $support->fileType ."\" "
                        ."     data-dFile=\"" . $support->dFile ."\" >"
                        ."  <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a> "
                        ."</td> "
                    ."</tr>";
                $table = $table . $tr;
                

        }
        echo $table;
    }

}