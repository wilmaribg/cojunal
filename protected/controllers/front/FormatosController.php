<?php 

	class FormatosController extends GxController {
	

	public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
    }

	public function actionIndex(){
			$session = Yii::app()->session;
			$deudores = Wallets::model()->findAll();
			//$deudores->order='legalName ASC';
			$this->render('formatos',array('deudores' => $deudores));
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

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
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

	

   public function actionGetFormatPdf($idWallet){
        setlocale(LC_MONETARY, "en_US");
        $date = new Datetime;

        $model = Wallets::model()->with('agendases')->findByPk($idWallet);

        $whc = WalletsHasCampaigns::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $idCampaign = $whc[0]->idCampaign;

        $campaign = Campaigns::model()->findByPk($idCampaign);
        $nameCampaign = null;
        $nameCampaign = $campaign->name;


        $modelWallet = Wallets::model()->findByPk($idWallet);
        $saldoCapital = 0;
        $saldoCapital = $modelWallet->capitalValue;

        $modelManagment = Management::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $tr = "";
	    $color = "#E0E0E0";

        if($modelManagment){

        	$pagos = 0;
        	foreach ($modelManagment as  $value) {
        		if($value->action == 'Pago'){
        			$pagos+= $value->comment;
        		}
        	}
        	$saldoPendiente = $saldoCapital - $pagos;
	        
	        foreach($modelManagment as $value) {
	            if($value->action == 'Pago'){
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
        }else{
        	$saldoPendiente = $saldoCapital;
        }



        $html ="<table border=\"0\" bordercolor=\"#3286C1\" cellspacing=\"2\" cellpadding=\"3\">"
                ."<tr bgColor=\"#193153\" style=\"color:#FFF; text-align: center; font-weight: bold;\"><td>Valor</td><td>Gestión</td><td>Tiempo</td></tr>"
                .$tr
                ."</table>";
        
        // echo "<pre>";
        // print_r($model->agendases);
        // die();
        $encabezado = $this->headerPdf("<table><tr><td>Cliente: " . $modelWallet->legalName . "</td><td></td></tr>
        	<tr><td>Campaña: ". $nameCampaign . "</td><td>Saldo Pendiente: " . money_format("%n",$saldoPendiente) . "</td></tr>
        	<tr><td>Pagos Realizados: </td><td></td></tr>
        	</table>");
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Formato 1");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );

        
        $pdf->writeHTML($encabezado.$html, true, false, true, false, '');

        $pdf->Output("Formato1.pdf", "I");
    }

    public function actionGetFormatCPdf($idWallet){
        setlocale(LC_MONETARY, "en_US");
        $date = new Datetime;

        $model = Wallets::model()->with('agendases')->findByPk($idWallet);

        $whc = WalletsHasCampaigns::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $idCampaign = $whc[0]->idCampaign;

        $campaign = Campaigns::model()->findByPk($idCampaign);
        $nameCampaign = null;
        $nameCampaign = $campaign->name;


        $modelWallet = Wallets::model()->findByPk($idWallet);
        $saldoCapital = 0;
        $saldoCapital = $modelWallet->capitalValue;
        $intereses = 0;
        $intereses = $modelWallet->interestsValue;
        $honorarios = 0;
        $honorarios = $modelWallet->feeValue;
        $saldoTotal = $saldoCapital + $intereses + $honorarios;

        $modelManagment = Assets::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $tr = "";
	    $color = "#E0E0E0";

        if($modelManagment){
	        
	        foreach($modelManagment as $value) {

	                $tr = "<tr bgcolor=\"".$color."\"><td>".$value->assetName."</td><td>".$value->description."</td><td>".$value->dCreation."</td></tr>" . $tr ; 
	                if($color=="#E0E0E0"){
	                    $color="#FFFFFF";
	                }else {
	                    $color="#E0E0E0";
	                }
	        }
        }



        $html ="<table border=\"0\" bordercolor=\"#3286C1\" cellspacing=\"2\" cellpadding=\"3\">"
                ."<tr bgColor=\"#193153\" style=\"color:#FFF; text-align: center; font-weight: bold;\"><td>Nombre del Bien</td><td>Descripción</td><td>Fecha</td></tr>"
                .$tr
                ."</table>";
        
        // echo "<pre>";
        // print_r($model->agendases);
        // die();
        $encabezado = $this->headerPdf("<table><tr><td>Cliente: " . $modelWallet->legalName . "</td><td></td></tr>
        	<tr><td>Campaña: ". $nameCampaign . "</td><td>Saldo Capital: " . money_format("%n",$saldoCapital) . "</td></tr>
        	<tr><td>Intereses: ". money_format("%n",$intereses) . "</td><td>Honorarios: " . money_format("%n",$honorarios) . "</td></tr>
        	<tr><td>Saldo Total: ". money_format("%n",$saldoTotal) . "</td><td></td></tr>
        	<tr><td>Bienes: </td><td></td></tr>
        	</table>");
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Formato 2");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );

        
        $pdf->writeHTML($encabezado.$html, true, false, true, false, '');

        $pdf->Output("Formato2.pdf", "I");
    }

    public function actionGetFormatSPdf($idWallet){
        setlocale(LC_MONETARY, "en_US");
        $date = new Datetime;

        $model = Wallets::model()->with('agendases')->findByPk($idWallet);

        $whc = WalletsHasCampaigns::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $idCampaign = $whc[0]->idCampaign;

        $campaign = Campaigns::model()->findByPk($idCampaign);
        $nameCampaign = null;
        $nameCampaign = $campaign->name;


        $modelWallet = Wallets::model()->findByPk($idWallet);
        $saldoCapital = 0;
        $saldoCapital = $modelWallet->capitalValue;
        $intereses = 0;
        $intereses = $modelWallet->interestsValue;
        $honorarios = 0;
        $honorarios = $modelWallet->feeValue;
        $saldoTotal = $saldoCapital + $intereses + $honorarios;

        $modelManagment = Assets::model()->findAllByAttributes(array("idWallet"=>$idWallet));

        $tr = "";
	    $color = "#E0E0E0";

        if($modelManagment){
	        
	        foreach($modelManagment as $value) {

	                $tr = "<tr bgcolor=\"".$color."\"><td>".$value->assetName."</td><td>".$value->description."</td><td>".$value->dCreation."</td></tr>" . $tr ; 
	                if($color=="#E0E0E0"){
	                    $color="#FFFFFF";
	                }else {
	                    $color="#E0E0E0";
	                }
	        }
        }



        $html ="<table border=\"0\" bordercolor=\"#3286C1\" cellspacing=\"2\" cellpadding=\"3\">"
                ."<tr bgColor=\"#193153\" style=\"color:#FFF; text-align: center; font-weight: bold;\"><td>Nombre del Bien</td><td>Descripción</td><td>Fecha</td></tr>"
                .$tr
                ."</table>";
        
        // echo "<pre>";
        // print_r($model->agendases);
        // die();
        $encabezado = $this->headerPdf("<table><tr><td>Cliente: " . $modelWallet->legalName . "</td><td></td></tr>
        	<tr><td>Campaña: ". $nameCampaign . "</td><td>Saldo Capital: " . money_format("%n",$saldoCapital) . "</td></tr>
        	<tr><td>Intereses: ". money_format("%n",$intereses) . "</td><td>Honorarios: " . money_format("%n",$honorarios) . "</td></tr>
        	<tr><td>Saldo Total: ". money_format("%n",$saldoTotal) . "</td><td></td></tr>
        	</table>");
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Formato 3");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );

        
        $pdf->writeHTML($encabezado, true, false, true, false, '');

        $pdf->Output("Formato3.pdf", "I");
    }

	}
?>