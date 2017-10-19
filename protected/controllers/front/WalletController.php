<?php

class WalletController extends GxController {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
    }

    public function filters() {
        $this->setLanguageApp();
        return array(
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => false,
                'actions' => '*'
            ),
        );
    }

    public function actionChangeIdioma() {
        if (isset($_POST['idioma'])) {
            if ($_POST['idioma'] == '1' || $_POST['idioma'] == '2') {
                $session = Yii::app()->session;
                $session['idioma'] = $_POST['idioma'];
                echo "ok";
            }
        }
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    // para cargar la maqueta
    /* public function missingAction($actionID)
      {
      $this->render(strtr($actionID,array('.php'=>'')));
      } */

    public function actionSearch($idWallet) {
        $sysparams    = $this->loadModel(1,'Sysparams');
        $status       = Status::model()->findAll();
        $paymentTypes = Paymentypes::model()->findAll();     
        $model        = $this->loadModel($idWallet, 'Wallets');
        $payments     = Payments::model()->findAllByAttributes(array('idWallet'=>$idWallet));
        $actions      = Action::model()->findAll();
        $this->render(
            'wallet', 
            array(
                'model'        =>$model,
                'sysparams'    =>$sysparams,
                'status'       =>$status,
                'paymentTypes' =>$paymentTypes,
                'payments'     =>$payments,
                'actions'      =>$actions
            )
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionGetEffects($idAction) {
        $effects = Action::model()->with('effects')->findByPk($idAction);
        $options = "<option value=''>Seleccionar opción</option>";        
        foreach ($effects->effects as $effect) {
            $options.="<option value='".$effect->idEffect."'>".$effect->effectName."</option>";
        }        
        echo $options;
    }

    public function actionSave(){
        Yii::log("Entre Save", "error", "actionSave");
        $idWallet      = $_REQUEST['idWallet'];
        $idAdviser     = $_REQUEST['idAdviser'];
        $status        = $_REQUEST['status'];
        $paymentType   = $_REQUEST['paymentType'];
        $paymentValue  = $_REQUEST['paymentValue'];
        $paymentDate   = $_REQUEST['paymentDate'];
        $agendaAction  = $_REQUEST['agendaAction'];
        $agendaEffect  = $_REQUEST['agendaEffect'];
        $agendaComment = $_REQUEST['agendaComment'];
        $agendaDate    = $_REQUEST['agendaDate'];
        $promiseValue  = $_REQUEST['promiseValue'];
        $promiseDate   = $_REQUEST['promiseDate'];
        $idAction      = $_REQUEST['idAction'];
        $taskDate      = $_REQUEST['taskDate'];
        $timer         = $_REQUEST['timer'];
        //Fecha de Actualizacion
        $date = new Datetime(); //
        //Instancia Wallet
        /*
        $model = Wallets::model()->findByPk($idWallet);
        $model->idStatus = $status;
        $model->dUpdate = $date->format('Y-m-d H:i:s');

        if(!$model->save()){                
                Yii::log("Error Wallet", "error", "actionSave");
            }
        */

        //Instancia Pagos
        if(isset($paymentValue) && ($paymentValue!="")){
            Yii::log("Entre Pagos", "error", "actionSave");
            $payment = new Payments;
            $payment->value = $paymentValue;
            $payment->dPayment = $this->convertDate($paymentDate);
            $payment->dCreation = $date->format('Y-m-d H:i:s');
            $payment->idWallet = $idWallet;
            $payment->idAdviser = $idAdviser;
            $payment->idPaymentType = $paymentType;
            $payment->timer = $timer;
        }        

        //Instancia Agenda
        if(isset($agendaAction)&&isset($agendaEffect)&&isset($agendaComment)&&($agendaComment!="")){
            Yii::log("Entre Agendas", "error", "actionSave");
            $agenda = new Agendas;
            $agenda->idAction = $agendaAction;
            $agenda->dAction = $this->convertDate($agendaDate);
            $agenda->dCreation = $date->format('Y-m-d H:i:s');
            $agenda->idWallet = $idWallet;
            $agenda->idAdviser = $idAdviser;
            $agenda->idEffect = $agendaEffect;
            $agenda->comment = $agendaComment;
            $agenda->timer = $timer;

        }

        //Instancia Promesas
        if(isset($promiseValue) && ($promiseValue!="")){
            Yii::log("Entre Promesas", "error", "actionSave");
            $promises = new Promises;        
            $promises->value = $promiseValue;
            $promises->dPromise = $this->convertDate($promiseDate);
            $promises->dCreation = $date->format('Y-m-d H:i:s');
            $promises->idWallet = $idWallet;
            $promises->idAdviser = $idAdviser;
            $promises->timer = $timer;
        }

        if(isset($idAction)&&($idAction!="")){
            Yii::log("Entre Tareas", "error", "actionSave");
            $tasks = new Tasks;
            $tasks->idWallet = $idWallet;
            $tasks->idAdviser = $idAdviser;
            $tasks->idAction = $idAction;
            $tasks->dTask = $this->convertDate($taskDate);
            $tasks->dCreation = $date->format('Y-m-d H:i:s'); 
            $tasks->timer = $timer;           
        }

        $transaction = Yii::app()->db->beginTransaction();
        try
        {   /*
            if(!$model->save()){                
                Yii::log("Error Wallet", "error", "actionSave");
            }
            */
            if(isset($paymentValue) && ($paymentValue!="")){
                if(!$payment->save()){
                    Yii::log("Error Pagos", "error", "actionSave");
                    Yii::log(var_export($payment->getErrors(), true), "error", "actionSave");
                }
            }
            if(isset($agendaAction)&&isset($agendaEffect)&&isset($agendaComment)&&($agendaComment!="")){
                if(!$agenda->save()){
                    Yii::log("Error Agendas", "error", "actionSave");
                    Yii::log(var_export($agenda->getErrors(), true), "error", "actionSave");
                }
            }
            if(isset($promiseValue) && ($promiseValue!="")){
                if(!$promises->save()){
                    Yii::log("Error Promesas", "error", "actionSave");
                    Yii::log(var_export($promises->getErrors(), true), "error", "actionSave");
                }
            }
            if(isset($idAction)&&($idAction!="")){
                if(!$tasks->save()){
                    Yii::log("Error Tareas", "error", "actionSave");
                    Yii::log(var_export($tasks->getErrors(), true), "error", "actionSave");
                }
            }

            $transaction->commit();            
            Yii::app()->user->setFlash('success', "Registros actualizados con éxito");            
        }
        catch (Exception $e)
        {
            Yii::log($e->getMessage(), "error", "actionSave");
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
            print_r($e->getMessage());
            die();
            //$this->refresh();
        }
    }

    public function actionDelete(){
        Yii::log("Entre Delete", "error", "actionSave");
        $idSupport = $_REQUEST['idSupport'];

        //Instancia Support
        //$model = Supports::model()->deleteByPk($idSupport);

        $transaction = Yii::app()->db->beginTransaction();

        try
        {

            if(!$model = Supports::model()->deleteByPk($idSupport)){                
                Yii::log("Error Support", "error", "actionSave");
            }

            $transaction->commit();            
            Yii::app()->user->setFlash('success', "Soporte Eliminado Con exito");            
        }
        catch (Exception $e)
        {
            Yii::log($e->getMessage(), "error", "actionDelete");
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
            print_r($e->getMessage());
            die();
            //$this->refresh();
        }
    }

    public function actionSaveInfo(){
        $idWallet      = $_REQUEST['idWallet'];
        $idAdviser     = $_REQUEST['idAdviser'];
        $infoName      = $_REQUEST['infoName'];
        $infoId        = $_REQUEST['infoId'];
        $infoAddress   = $_REQUEST['infoAddress'];
        $infoDistricts = $_REQUEST['infoDistricts'];
        $infoPhone     = $_REQUEST['infoPhone'];
        $infoEmail     = $_REQUEST['infoEmail'];

        $date = new Datetime();

        $model = Wallets::model()->findByPk($idWallet);
        $model->legalName = $infoName;
        $model->idNumber = $infoId;
        $model->address = $infoAddress;
        $model->phone = $infoPhone;
        $model->email = $infoEmail;
        $model->idDistrict = $infoDistricts;
        $model->idAdviser = $idAdviser;
        $model->dUpdate = $date->format('Y-m-d H:i:s');

        if(!$model->save()){                
            Yii::log("Error Wallet", "error", "actionSave");
        }else{
            Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
        }
    }

    public function actionSaveAsset(){

        $idAsset = $_REQUEST['idAsset'];

        $idWallet    = $_REQUEST['idWallet'];
        $idAdviser   = $_REQUEST['idAdviser'];
        $description = $_REQUEST['description'];
        $assetDate   = $_REQUEST['assetDate'];
        $assetName   = $_REQUEST['assetName'];
        $assetType   = $_REQUEST['assetType'];

        if($idAsset != ''){
            $assets = Assets::model()->findByPk($idAsset);
        }else{
            $assets = new Assets;
        }        

        $assets->idWallet = $idWallet;
        $assets->idAdviser = $idAdviser;
        $assets->assetName = $assetName;
        $assets->description = $description;
        $assets->idType = $assetType;
        $assets->dCreation = $this->convertDate($assetDate);
        if($assets->validate()){
            if(!$assets->save()){
                Yii::log("Error Assets", "error", "saveAsset");
                Yii::log("ERROR DB:".$assets->getErrors(), "error", "saveAsset");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }else{
            $errors = $assets->errors;
            Yii::log("ERRORS:".$errors, "error", "saveAsset");
        }       
    }

    public function actionGetCities($idDepartment) {
        $cities = Cities::model()->findAllByAttributes(array('idDepartament'=>$idDepartment));
        $options = "<option value=''>Seleccionar opción</option>";        
        foreach ($cities as $city) {
            $options.="<option value='".$city->idCity."'>".$city->name."</option>";
        }        
        echo $options;
    }

    public function actionSaveDemographicPhone(){
        $idWallet      = $_REQUEST['idWallet'];
        $idAdviser     = $_REQUEST['idAdviser'];
        $idType        = 1;
        $phoneType     = $_REQUEST['phoneType'];
        $phoneNumber   = $_REQUEST['phoneNumber'];
        $idCity        = $_REQUEST['idCity'];
        $idDemographic = $_REQUEST['idDemographic'];

        $date = new Datetime();

        if($idDemographic != ''){
            $demographics = Demographics::model()->findByPk($idDemographic);
        }else{
            $demographics = new Demographics;    
        }
        

        $demographics->idWallet = $idWallet;
        $demographics->idAdviser = $idAdviser;
        $demographics->idType = $idType;
        $demographics->idCity = $idCity;
        $demographics->dCreation = $date->format('Y-m-d H:i:s');
        $demographics->phoneType = $phoneType;
        $demographics->value = $phoneNumber;        

        if($demographics->validate()){
            if(!$demographics->save()){
                Yii::log("Error Phone", "error", "saveDemographicPhone");
                Yii::log("ERROR DB:".$demographics->getErrors(), "error", "saveDemographicPhone");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicPhone");
        }
    }

    public function actionSaveDemographicReference(){
        $idWallet              = $_REQUEST['idWallet'];
        $idAdviser             = $_REQUEST['idAdviser'];
        $idType                = 2;
        $referenceValue        = $_REQUEST['referenceValue'];
        $referenceRelationship = $_REQUEST['referenceRelationship'];
        $idCity                = $_REQUEST['idCity'];
        $referenceComment      = $_REQUEST['referenceComment'];
        $idDemographic         = $_REQUEST['idDemographic'];

        $date = new Datetime();

        if($idDemographic != ''){
            $demographics = Demographics::model()->findByPk($idDemographic);
        }else{
            $demographics = new Demographics;    
        }

        $demographics->idWallet = $idWallet;
        $demographics->idAdviser = $idAdviser;
        $demographics->idType = $idType;
        $demographics->idCity = $idCity;
        $demographics->value = $referenceValue;
        $demographics->comment = $referenceComment;
        $demographics->relationshipType = $referenceRelationship;
        $demographics->dCreation = $date->format('Y-m-d H:i:s');

        if($demographics->validate()){
            if(!$demographics->save()){
                Yii::log("Error Phone", "error", "saveDemographicReference");
                Yii::log("ERROR DB:".$demographics->getErrors(), "error", "saveDemographicReference");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicReference");
        }
    }

    public function actionSaveDemographicEmail(){
        $idWallet   = $_REQUEST['idWallet'];
        $idAdviser  = $_REQUEST['idAdviser'];
        $idType     = 3;
        $emailName  = $_REQUEST['emailName'];
        $emailEmail = $_REQUEST['emailEmail'];
        $idDemographic         = $_REQUEST['idDemographic'];

        $date = new Datetime();

        if($idDemographic != ''){
            $demographics = Demographics::model()->findByPk($idDemographic);
        }else{
            $demographics = new Demographics;    
        }

        $demographics->idWallet = $idWallet;
        $demographics->idAdviser = $idAdviser;
        $demographics->idType = $idType;
        $demographics->contactName = $emailName;
        $demographics->value = $emailEmail;
        $demographics->dCreation = $date->format('Y-m-d H:i:s');

        if($demographics->validate()){
            if(!$demographics->save()){
                Yii::log("Error Phone", "error", "saveDemographicEmail");
                Yii::log("ERROR DB:".$demographics->getErrors(), "error", "saveDemographicEmail");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicEmail");
        }
    }

    public function actionSaveDemographicAddress(){
        $idWallet       = $_REQUEST['idWallet'];
        $idAdviser      = $_REQUEST['idAdviser'];
        $idType         = 4;
        $addressType    = $_REQUEST['addressType'];
        $addressAddress = $_REQUEST['addressAddress'];
        $idCity         = $_REQUEST['idCity'];
        $idDemographic  = $_REQUEST['idDemographic'];

        $date = new Datetime();

        if($idDemographic != ''){
            $demographics = Demographics::model()->findByPk($idDemographic);
        }else{
            $demographics = new Demographics;    
        }

        $demographics->idWallet = $idWallet;
        $demographics->idAdviser = $idAdviser;
        $demographics->idType = $idType;
        $demographics->idCity = $idCity;
        $demographics->value = $addressAddress;
        $demographics->addressType = $addressType;
        $demographics->dCreation = $date->format('Y-m-d H:i:s');

        if($demographics->validate()){
            if(!$demographics->save()){
                Yii::log("Error Phone", "error", "saveDemographicEmail");
                Yii::log("ERROR DB:".$demographics->getErrors(), "error", "saveDemographicEmail");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicEmail");
        }
    }

    public function actionGetManagementPdf($idWallet){
        setlocale(LC_MONETARY, "en_US");
        $date = new Datetime;

        $model = Wallets::model()->with('agendases')->findByPk($idWallet);

        $modelManagment = Management::model()->findAllByAttributes(array("idWallet"=>$idWallet));
        $modelWallet = Wallets::model()->findByPk($idWallet);

        $tr = "";
        $color = "#E0E0E0";
        foreach($modelManagment as $value) {
            if($value->action == 'Promesa'){
                $gestion = $value->action;
                if($value->effect != ''){
                  $gestion .= " / ".$value->effect;
                }
                $comment = ($value->action=="Pago"||$value->action=="Promesa") ? money_format('%n',$value->comment) : $value->comment;
                $tr = "<tr bgcolor=\"".$color."\"><td>".$comment."</td><td>".$gestion."</td><td>".$value->fecha."</td></tr>" . $tr ; 
                if($color=="#E0E0E0"){
                    $color="#FFFFFF";
                }else {
                    $color="#E0E0E0";
                }
                }

            if($value->effect != null){
                
                $gestion = $value->action;
                if($value->effect != ''){
                  $gestion .= " / ".$value->effect;
                }
                $comment = ($value->action=="Pago"||$value->action=="Promesa") ? money_format('%n',$value->comment) : $value->comment;
                $tr = "<tr bgcolor=\"".$color."\"><td>".$comment."</td><td>".$gestion."</td><td>".$value->fecha."</td></tr>" . $tr ; 
                if($color=="#E0E0E0"){
                    $color="#FFFFFF";
                }else {
                    $color="#E0E0E0";
                }
            }
        }

        $html ="<table border=\"0\" bordercolor=\"#3286C1\" cellspacing=\"2\" cellpadding=\"3\">"
                ."<tr bgColor=\"#193153\" style=\"color:#FFF; text-align: center; font-weight: bold;\"><td>Comentario/Valor</td><td>Gestión</td><td>Tiempo</td></tr>"
                .$tr
                ."</table>";
        
        // echo "<pre>";
        // print_r($model->agendases);
        // die();
        $encabezado = $this->headerPdf("<table><tr><td>Asesor: ". $modelManagment[0]->asesor . "</td><td>Cliente: " . $modelWallet->legalName . "</td></tr></table>");
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Reporte de Gestion");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );

        



        // $pdf->SetFillColor(127,127,255);
        // $pdf->MultiCell(130,20,'Nombre del asesor',1,'C',true, 0);
        // $pdf->MultiCell(203,20,'Comentario',1,'C',true, 0);
        // $pdf->MultiCell(130,20,'Fecha de gestión',1,'C',true, 0);
        // $pdf->MultiCell(130,20,'Tipo de gestión',1,'C',true, 1);
        // if(count($model->agendases)>0){
        //     $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('6') , '', 'default', true );
        //     foreach ($model->agendases as $agenda) {            
        //         $adviser = Advisers::model()->findByPk($agenda->idAdviser);

        //         $pdf->MultiCell(130,20,$adviser->name,1,'C',false, 0,'','',true,0,false,true,0,'M',false);
        //         $pdf->MultiCell(203,20,$agenda->comment,1,'C',false, 0,'','',true,0,false,true,0,'M',false);
        //         $dateManagement = new DateTime($agenda->dCreation);
        //         $pdf->MultiCell(130,20,$dateManagement->format('d/m/Y'),1,'C',false, 0,'','',true,0,false,true,0,'M',false);
        //         $action = Action::model()->findByPk($agenda->idAction);
        //         $effect = Effects::model()->findByPk($agenda->idEffect);
        //         $pdf->MultiCell(130,20,$action->actionName." - ".$effect->effectName,1,'C',false, 1,'','',true,0,false,true,0,'M',false);
        //     } 
        // }else{
        //     $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );
        //     $pdf->MultiCell(593,20,'No existen gestiones para esta cartera',1,'C',false, 1,'','',true,0,false,true,0,'M',false);
        // }
        
        $pdf->writeHTML($encabezado.$html, true, false, true, false, '');

        $pdf->Output("ReporteGestion.pdf", "I");
    }

    private function convertDate($date){
        Yii::log($date, "error", "convertDate");
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
        Yii::log(print_r($trueDate,true), "error", "convertDate");

        $day = $trueDate[0];
        $month = $months[$trueDate[1]];
        $year = $trueDate[2];

        $defDate = $year.'-'.$month.'-'.$day;

        return $defDate;
    }

    public function actionSaveSupport(){

        try{
            $file = new File;   
            if(isset($_POST['File'])){
                $file->attributes=$_POST['File'];
                $file->file=CUploadedFile::getInstance($file,'file');
                if($file->save())
                {
                    $file->file->saveAs('assets/supports/3.txt');
                    // redirect to success page
                }
            }     

            Yii::import('application.google.google.*');
            require_once("protected/google/autoload.php");

            $idWallet = $_REQUEST['idWallet'];

            $configuration = array(
                'login'   =>'cojunal@cojunal-148320.iam.gserviceaccount.com',
                'key'     =>file_get_contents('assets/cojunal-5498ea4f2a1c.p12'),
                'scope'   => 'https://www.googleapis.com/auth/devstorage.full_control',
                'project' => 'cojunal-148320',
                'storage' => array(
                    'url'    => 'https://storage.googleapis.com/',
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
            $uploadDir = 'assets/supports/';
            $fname = '1.txt';
            $file_name = $idWallet."/".$fname;
            $obj = new Google_Service_Storage_StorageObject();
            $obj->setName($file_name);
            //if()
            $storage->objects->insert(
                "cojunal-148320.appspot.com",
                $obj,
                ['name' => $file_name, 'data' => file_get_contents($uploadDir.$fname), 'uploadType' => 'media','predefinedAcl' => 'publicRead']
            );
            return true;
        }catch(Exception $e){
            Yii::log("File Upload fail" . print_r($e->getMessage(),true), "error", "saveSupport");
            return false;
        }
        

        
    }

    public function actionSaveFinantial(){

        $idWallet    = $_REQUEST['idWallet'];
        $idAdviser   = $_REQUEST['idAdviser'];
        $negotiation = $_REQUEST['negotiation'];
        $vendorEmail = $_REQUEST['vendorEmail'];
        $vendorName  = $_REQUEST['vendorName'];
        $vendorPhone = $_REQUEST['vendorPhone'];        

        $date = new Datetime();

        $model = Wallets::model()->findByPk($idWallet);

        $model->negotiation = $negotiation;
        $model->vendorEmail = $vendorEmail;
        $model->vendorName  = $vendorName;
        $model->vendorPhone = $vendorPhone;
        $model->dUpdate     = $date->format('Y-m-d H:i:s');

        if(!$model->save()){                
            Yii::log("Error Wallet", "error", "actionSaveFinantial");
            Yii::log("ERROR DB:".$model->getErrors(), "error", "actionSaveFinantial");
        }else{
            Yii::log("Save:", "error", "actionSaveFinantial");
            Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
        }
    }

    public function actionDeleteDemographic($idDemographic){
        $model = Demographics::model()->findByPk($idDemographic);

        if($model->delete()){
            Yii::log("Entra Delete:", "error", "Delete");
            Yii::app()->user->setFlash('success', "Registro eliminado con éxito");
        }else{
            Yii::log("No Entra Delete:", "error", "Delete");
            Yii::app()->user->setFlash('error', "No se pudo eliminar");
        }

        $current_user=Yii::app()->user->id;
        $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
    }


    public function actionUpdateComment(){
        $idComment = $_REQUEST['idComment'];
        $model = Comments::model()->findByPk($idComment);
        if($model->status){
            Yii::app()->user->setFlash('error', "El comentario ya fué atendido y no se puede cambiar su etado");
        }else {
            $model->status = true;    
            if(!$model->save()){                
                Yii::log("Error Campaign", "error", "actionSaveComment");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
            }
        }
        
    }

    public function actionTipoEstatus(){

        $idWallet = $_REQUEST['idWallet'];
        $status = $_REQUEST['status'];
        $date = new Datetime();

        $tipo = Wallets2::model()->findByPk($idWallet);
        $tipo->idStatus = $status;
        $tipo->dUpdate = $date->format('Y-m-d H:i:s');

        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            if($tipo->save()){  
                $transaction->commit();            
                Yii::app()->user->setFlash('success', "Tipo Actualizado con Exito");                 
            }else{
                Yii::log("Error Support", "error", "actionSave");
            }

                        
        }
        catch (Exception $e)
        {
            Yii::log($e->getMessage(), "error", "actionDelete");
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
            print_r($e->getMessage());
            die();
            //$this->refresh();
        }
    }

    private function headerPdf($textHeader){
        $now = new Datetime;
        $img = Yii::app()->baseUrl."/assets/img/logo.png";
        return $encabezado = "<table>
                        <tr>
                            <td><img src=\"".$img."\"></td>
                            <td><p align=\"right\"><h4>".$now->format('d/m/Y')."</h4></p></td>
                        </tr>
                        </table>
                        <h1> ".$textHeader."</h1>
                        ";

    }
}