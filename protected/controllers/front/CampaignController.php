<?php

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class CampaignController extends GxController {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        // $session = Yii::app()->session;
        // var_dump($session['profile']);
        // exit();

        // if(!isset($session["idioma"]))
        //     $session["idioma"] = 1;
        // if(isset($session['cojunal'])){
        //     Yii::log($session['cojunal'] ." -> Profile => ". $session['profile'],"error","init");
        //     if($session['profile']=="empresa"){
        //         $this->layout = 'layout_campaign';        
        //     }else {
        //         $this->actionLogout();    
        //     }
            
        // }else {
        //     $this->actionLogout();    
        // }


        // $this->layout = 'layout_campaign';
        // parent::init();
        // Yii::app()->errorHandler->errorAction = 'site/error';
    }

    public function actionLogout() {
        Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion";
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
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

    public function actionProfile(){
        $session = Yii::app()->session;
        $campaign = Campaigns::model()->findByAttributes(array("contactEmail"=>$session["cojunal"]));
        $distric = Treedistricts::model()->findByAttributes(array("idDistrict"=>$campaign->idDistrict));
        $this->render('profile', array("campaign"=>$campaign, "district"=>$distric));
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

    public function actionReport(){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        setlocale(LC_MONETARY, "en_US");
        $listDebtors = Viewlistdebtors::model()->findAllByAttributes(array('idCampaign'=>$campaign->idCampaign));

        $command=Yii::app()->db->createCommand();
        $command->select('max(dCreate)');
        $command->from('wallets');
        $command->join('wallets_has_campaigns', 'wallets_has_campaigns.idWallet = wallets.idWallet and wallets_has_campaigns.idCampaign = ' . $campaign->idCampaign);
        $maxDateCreate = $command->queryScalar();
        
        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('wallets');
        $command->join('wallets_has_campaigns', 'wallets_has_campaigns.idWallet = wallets.idWallet and wallets_has_campaigns.idCampaign = ' . $campaign->idCampaign);
        $amount = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and currentDebt = 0 and debt = valueAssigment');
        $countDebts = $command->queryScalar();


        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 5');
        $juridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 5');
        $amountJuridico = $command->queryScalar();

        
        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 2');
        $preJuridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 2');
        $amountPreJuridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 1');
        $investigacion = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 1');
        $amountInvestigacion = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 4');
        $contactCenter = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 4');
        $amountContactCenter = $command->queryScalar();

        //1.- Rojo, 2.- Azul, 3.- Amarillo, 4.- Verde

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 1');
        $rojo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 1');
        $amountRojo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 2');
        $azul = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 2');
        $amountAzul = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 3');
        $amarillo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 3');
        $amountAmarillo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 4');
        $verde = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 4');
        $amountVerde = $command->queryScalar();

        $this->render('reports', array('campaign'=>$campaign,  'amount'=>money_format('%.0n',$amount), 'listDebtors'=>$listDebtors, 'countDebts'=>$countDebts,
                'juridico' =>$juridico,
                'preJuridico' =>$preJuridico,
                'investigacion' =>$investigacion,
                'contactCenter' =>$contactCenter,
                'amountJuridico' =>money_format('%.0n',$amountJuridico),
                'amountPreJuridico' =>money_format('%.0n',$amountPreJuridico),
                'amountInvestigacion' =>money_format('%.0n',$amountInvestigacion),
                'amountContactCenter' =>money_format('%.0n',$amountContactCenter),
                'maxDateCreate' => $maxDateCreate,
                'rojo' => $rojo,
                'azul'=>$azul,
                'amarillo'=>$amarillo,
                'verde'=>$verde,
                'amountRojo' => money_format('%.0n',$amountRojo),
                'amountAzul' => money_format('%.0n',$amountAzul),
                'amountAmarillo' => money_format('%.0n',$amountAmarillo),
                'amountVerde' => money_format('%.0n',$amountVerde),
            ));
    }

    public function actionReportPdf(){

        $session = Yii::app()->session;
        $user = $session['cojunal'];
        Yii::app()->sourceLanguage = 'xx';
        if($session['idioma']==2){
          Yii::app()->language = "en";
        }else {
          Yii::app()->language = "es";
        }
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        setlocale(LC_MONETARY, "en_US");
        $listDebtors = Viewlistdebtors::model()->findAllByAttributes(array('idCampaign'=>$campaign->idCampaign));

        $command=Yii::app()->db->createCommand();
        $command->select('max(dCreate)');
        $command->from('wallets');
        $command->join('wallets_has_campaigns', 'wallets_has_campaigns.idWallet = wallets.idWallet and wallets_has_campaigns.idCampaign = ' . $campaign->idCampaign);
        $maxDateCreate = $command->queryScalar();
        $date = new DateTime($maxDateCreate);
        
        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('wallets');
        $command->join('wallets_has_campaigns', 'wallets_has_campaigns.idWallet = wallets.idWallet and wallets_has_campaigns.idCampaign = ' . $campaign->idCampaign);
        $amount = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and currentDebt = 0 and debt = valueAssigment');
        $countDebts = $command->queryScalar();


        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 5');
        $juridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 5');
        $amountJuridico = $command->queryScalar();

        
        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 2');
        $preJuridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 2');
        $amountPreJuridico = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 1');
        $investigacion = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 1');
        $amountInvestigacion = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(idWallet)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 4');
        $contactCenter = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and idStatus = 4');
        $amountContactCenter = $command->queryScalar();

        //1.- Rojo, 2.- Azul, 3.- Amarillo, 4.- Verde

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 1');
        $rojo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 1');
        $amountRojo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 2');
        $azul = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 2');
        $amountAzul = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 3');
        $amarillo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 3');
        $amountAmarillo = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(type)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 4');
        $verde = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where('idCampaign = '.$campaign->idCampaign.' and type = 4');
        $amountVerde = $command->queryScalar();

        $encabezado = $this->headerPdf(Yii::t("reports","cliente").": ". $campaign->name);
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Reporte de CampaÃ±a");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );        
        
        $html = "
                <table border=\"0\" bordercolor=\"#3286C1\" cellspacing=\"5\" cellpadding=\"10\">
                  <tr>
                    <td  height=\"50px;\" bgcolor=\"#eaeaea\">
                        <b>".Yii::t("reports", "fechaCargue")."</b>
                        ".$date->format("d-m-Y")."
                    </td>
                    <td  height=\"50px;\" bgcolor=\"#eaeaea\">
                        <b>".Yii::t("reports", "totalDinero")."</b>
                        ".money_format('%n',$amount)."
                    </td>
                    <td  height=\"50px;\" bgcolor=\"#eaeaea\">
                        <b>".Yii::t("reports", "totalRecaudado")."</b>
                        ".money_format('%n',$countDebts)."
                    </td>
                    <td  height=\"50px;\" bgcolor=\"#eaeaea\">
                        <b>".Yii::t("reports", "totalCargados")."</b>
                        ".count($listDebtors)."
                    </td>
                  </tr>
                </table>
                <table border=\"0\" cellspacing=\"5\" cellpadding=\"10\">
                    <tr>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/ico_prejudirico.svg\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "prejuridico")." (".$preJuridico.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountPreJuridico)."</h1></td>
                            </tr>
                        </table>
                        
                      </td>
                      <td bgcolor=\"#f7f7f7\" >
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/ico_juridico.svg\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "juridico")." (".$juridico.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountJuridico)."</h1></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/ico_investig.svg\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "contactCenter")." (".$contactCenter.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountContactCenter)."</h1></td>
                            </tr>
                        </table>
                      </td>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/ico_center.svg\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "investigacion")." (".$investigacion.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountInvestigacion)."</h1></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/rojo.png\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "deudoresIlocalizados")." (".$rojo.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountRojo)."</h1></td>
                            </tr>
                        </table>
                      </td>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/azul.png\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "deudoresContactados")." (".$azul.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountAzul)."</h1></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/amarillo.png\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "deudoresCompromiso")." (".$amarillo.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountAmarillo)."</h1></td>
                            </tr>
                        </table>
                      </td>
                      <td bgcolor=\"#f7f7f7\">
                        <table>
                            <tr>
                                <td width=\"30%\"><img src=\"".Yii::app()->baseUrl."/assets/img/icons/verde.png\" width=\"50\" height=\"50\"></td>
                                <td width=\"70%\"><span style=\"margin-top:10px;\"><h3>".Yii::t("reports", "deudoresNormalizados")." (".$verde.")</h3></span></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\" ><h1>".money_format('%n',$amountVerde)."</h1></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                </table>";
        $pdf->writeHTML($encabezado.$html, true, false, true, false, '');

        $pdf->Output("ReporteCamapaign.pdf", "I");
    

    }

    public function actionSearch($idWallet) {
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));

        $where = 'idCampaign=' .$campaign->idCampaign;

        $queryBasic = new CDbCriteria( array(
            'condition' => 'idCampaign' . "= " .$campaign->idCampaign, 
            'order'=>'dAssigment'
        ));
        if(count($campaign)>0) {  
            $sysparams = $this->loadModel(1,'Sysparams');
            $model = $this->loadModel($idWallet, 'Wallets');
            $payments = Payments::model()->findAllByAttributes(array('idWallet'=>$idWallet));
            $this->render(
                'campaign', 
                array(
                    'model'=>$model,
                    'sysparams'=>$sysparams,
                    'payments'=>$payments,
                )
            );
        }else {

        }
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

    
    public function actionSave(){
        Yii::log("Entre Save", "error", "actionSave");
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $status = $_REQUEST['status'];
        $paymentType = $_REQUEST['paymentType'];
        $paymentValue = $_REQUEST['paymentValue'];
        $paymentDate = $_REQUEST['paymentDate'];
        $agendaAction = $_REQUEST['agendaAction'];
        $agendaEffect = $_REQUEST['agendaEffect'];
        $agendaComment = $_REQUEST['agendaComment'];
        $agendaDate = $_REQUEST['agendaDate'];
        $promiseValue = $_REQUEST['promiseValue'];
        $promiseDate = $_REQUEST['promiseDate'];
        $idAction = $_REQUEST['idAction'];
        $taskDate = $_REQUEST['taskDate'];
        //Fecha de Actualizacion
        $date = new Datetime(); //
        //Instancia Wallet
        $model = Wallets::model()->findByPk($idWallet);
        $model->idStatus = $status;
        $model->dUpdate = $date->format('Y-m-d H:i:s');

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
        }

        //Instancia Promesas
        if(isset($promiseValue)&&($promiseValue!="")){
            Yii::log("Entre Promesas", "error", "actionSave");
            $promises = new Promises;        
            $promises->value = $promiseValue;
            $promises->dPromise = $this->convertDate($promiseDate);
            $promises->dCreation = $date->format('Y-m-d H:i:s');
            $promises->idWallet = $idWallet;
            $promises->idAdviser = $idAdviser;
        }

        if(isset($idAction)&&($idAction!="")){
            Yii::log("Entre Tareas", "error", "actionSave");
            $tasks = new Tasks;
            $tasks->idWallet = $idWallet;
            $tasks->idAdviser = $idAdviser;
            $tasks->idAction = $idAction;
            $tasks->dTask = $this->convertDate($taskDate);
            $tasks->dCreation = $date->format('Y-m-d H:i:s');            
        }

        $transaction = Yii::app()->db->beginTransaction();
        try
        {

            if(!$model->save()){                
                Yii::log("Error Wallet", "error", "actionSave");
            }
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
            if(isset($promiseValue)&&($promiseValue!="")){
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
            Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");            
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

    public function actionSaveComment(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $comment = $_REQUEST['comment'];
        
        $model = new Comments;
        $model->idWallet = $idWallet;
        $model->idAdviser = $idAdviser;
        $model->comment = $comment;
        
        if(!$model->save()){                
            Yii::log("Error Campaign", "error", "actionSaveComment");
        }else{
            Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
        }
    }


    public function actionUpdateComment(){
        $idComment = $_REQUEST['idComment'];
        $model = Comments::model()->findByPk($idComment);
        $status = $model->status==true?false:true;
        $model->status = $status;
        if(!$model->save()){                
            Yii::log("Error Campaign", "error", "actionSaveComment");
        }else{
            Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
        }
    }

    public function actionSaveAsset(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $description = $_REQUEST['description'];
        $assetDate = $_REQUEST['assetDate'];
        $assetName = $_REQUEST['assetName'];
        $assetType = $_REQUEST['assetType'];

        $assets = new Assets;

        $assets->idWallet = $idWallet;
        $assets->idAdviser = $idAdviser;
        $assets->assetName = $assetName;
        $assets->description = $description;
        $assets->idType = $assetType;
        $assets->dCreation = $assetDate;
        if($assets->validate()){
            if(!$assets->save()){
                Yii::log("Error Assets", "error", "saveAsset");
                Yii::log("ERROR DB:".$assets->getErrors(), "error", "saveAsset");
            }else{
                Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
            }
        }else{
            $errors = $assets->errors;
            Yii::log("ERRORS:".$errors, "error", "saveAsset");
        }       
    }

    public function actionGetCities($idDepartment) {
        $cities = Cities::model()->findAllByAttributes(array('idDepartament'=>$idDepartment));
        $options = "<option value=''>Seleccione una Ciudad</option>";        
        foreach ($cities as $city) {
            $options.="<option value='".$city->idCity."'>".$city->name."</option>";
        }        
        echo $options;
    }

    public function actionSaveDemographicPhone(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $idType = 1;
        $phoneType = $_REQUEST['phoneType'];
        $phoneNumber = $_REQUEST['phoneNumber'];
        $idCity = $_REQUEST['idCity'];

        $date = new Datetime();

        $demographics = new Demographics;

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
                Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicPhone");
        }
    }

    public function actionSaveDemographicReference(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $idType = 2;
        $referenceValue = $_REQUEST['referenceValue'];
        $referenceRelationship = $_REQUEST['referenceRelationship'];
        $idCity = $_REQUEST['idCity'];
        $referenceComment = $_REQUEST['referenceComment'];

        $date = new Datetime();

        $demographics = new Demographics;

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
                Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicReference");
        }
    }

    public function actionSaveDemographicEmail(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $idType = 3;
        $emailName = $_REQUEST['emailName'];
        $emailEmail = $_REQUEST['emailEmail'];

        $date = new Datetime();

        $demographics = new Demographics;

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
                Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicEmail");
        }
    }

    public function actionSaveDemographicAddress(){
        $idWallet = $_REQUEST['idWallet'];
        $idAdviser = $_REQUEST['idAdviser'];
        $idType = 4;
        $addressType = $_REQUEST['addressType'];
        $addressAddress = $_REQUEST['addressAddress'];
        $idCity = $_REQUEST['idCity'];

        $date = new Datetime();

        $demographics = new Demographics;

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
                Yii::app()->user->setFlash('success', "Registros actualizados con Ã©xito");
            }
        }else{
            $errors = $demographics->errors;
            Yii::log("ERRORS:".$errors, "error", "saveDemographicEmail");
        }
    }

    public function actionMasiveData(){
        Yii::log("Entre a la accion", "error", "actionMasiveData");
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '2000M');
        
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $nameTempTable = rand();
        $error = false;

        // Guardar datos de la campaÃ±a
        if(! empty($_POST['Campaing'])) {
          Yii::import('application.models.WalletsByCampaign');

          $data['idCampaign'] = (!empty($_POST['Campaing']['idCampaign'])) ? $_POST['Campaing']['idCampaign'] : null;
          $data['campaignName'] = (!empty($_POST['Campaing']['campaignName'])) ? $_POST['Campaing']['campaignName'] : null;
          $data['serviceType'] = (!empty($_POST['Campaing']['serviceType'])) ? $_POST['Campaing']['serviceType'] : null;
          $data['notificationType'] = (!empty($_POST['Campaing']['notificationType'])) ? $_POST['Campaing']['notificationType'] : null;
          

          if($data['idCampaign']  == null 
            || $data['idCampaign']  == null 
            || $data['idCampaign']  == null 
            || $data['idCampaign']  == null) {
            Yii::app()->user->setFlash('error', "Datos incompletos por favor intentelo de nuevo.");   
            $this->redirect(array('../beta/database'));
          }

          if(WalletsByCampaign::save_data($data) != 1) {
            Yii::app()->user->setFlash('error', "Lo sentimos ha ocurrido un error al crear la campaÃ±a.");   
            $this->redirect(array('../beta/database'));
          }else {
            $campaign->idCampaign = WalletsByCampaign::getLastID();
          }
        }

        if(isset($_FILES['file']))
        {
            Yii::log("Pase el post", "error", "actionMasiveData");
            $uploadedFile = CUploadedFile::getInstanceByName('file',$_FILES['file']);
            $fp = Yii::getPathOfAlias('webroot') . "/uploads/" . $nameTempTable . ".csv";
            if(!empty($uploadedFile))
            {
                Yii::log("Intenete guardar en " . Yii::getPathOfAlias('webroot') . "/uploads/", "error", "actionMasiveData");
                $uploadedFile->saveAs($fp);
                $date = new Datetime();
                $date = $date->format('Y-m-d H:i:s');
                $caracterSeparator = ";";
                if( strpos(file_get_contents($fp),",") !== false) {
                    $caracterSeparator = ",";
                }
                $sql="LOAD DATA INFILE '".$fp."'
                    INTO TABLE `wallets_tempo`
                    FIELDS
                        TERMINATED BY '".$caracterSeparator."'
                        ENCLOSED BY '\"'
                    LINES
                        TERMINATED BY '\\n'
                     IGNORE 1 LINES 
                     (idNumber,capitalValue,legalName,address,phone,email,ciudad,product,@validThrough,accountNumber, titleValue,
                         typePhone1, countryPhone1, cityPhone1, phone1, typePhone2, countryPhone2, cityPhone2, phone2, typePhone3, countryPhone3, cityPhone3, phone3, nameReference1, relationshipReferenc1, 
                         countryReference1, cityReference1, commentReference1, nameReference2, relationshipReference2, countryReference2, cityReference2, commentReference2, nameReference3, 
                         relationshipReference3, countryReference3, cityReference3, commentReference3, nameEmail1, email1, nameEmail2, email2, nameEmail3, email3, typeAddress1, address1, countryAdrress1, 
                         cityAddress1, typeAddress2, address2, countryAddress2, cityAddress2, typeAddress3, address3, countryAddress3, cityAddress3, typeAsset1, nameAsset1, commentAsset1, 
                         typeAsset2, nameAsset2, commentAsset2, typeAsset3, nameAsset3, commentAsset3)
                     SET lote = sha1('".$date."'), idCampaign = " . $campaign->idCampaign . ", idAdviser = 1, idStatus = 1, migrate = false, validThrough = str_to_date(@validThrough, '%d/%m/%Y')" ;
                                
                                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();
                try
                    {
                      $connection->createCommand($sql)->execute();
                      $transaction->commit();

                      Yii::app()->user->setFlash('success', "Los datos han sido precargados con Ã©xito");            
                      $this->redirect(array('../beta/database/'.sha1($date))); 
                    }catch(Exception $e){
                        var_dump($e);
                      Yii::log("Error de registros" . print_r($e->getMessage(), true), "error", "UploadFile");
                      $error = true;
                      Yii::log($e->getMessage(), "error", "actionMasiveData");
                      $transaction->rollBack();
                      Yii::app()->user->setFlash('error', "Algunos registros de los que estÃ¡ subiendo estÃ¡ repetidos");  
                                            $this->redirect(array('../beta/database'));
                    }
            }
        }
        
    }

    public function actionLote($lote){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('wallets_tempo');
        $command->where('idCampaign=:id and lote=:lote', array(':id'=>$campaign->idCampaign, ':lote'=>$lote));
        $amount = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('count(lote)');
        $command->from('wallets_tempo');
        $command->where('idCampaign=:id and lote=:lote', array(':id'=>$campaign->idCampaign, ':lote'=>$lote));
        $usersUpload = $command->queryScalar();
        if($amount!=null){
            setlocale(LC_MONETARY, "en_US");
            $this->render('../dashboard/database', array('lote'=>$lote, 'amount'=>money_format('%n',$amount), 'usersUpload'=>$usersUpload));     
        }else{
            Yii::app()->user->setFlash('error', "EstÃ¡ intentado hacer una operaciÃ³n no permitida");            
            $this->redirect(array('../beta/database'));    
        }
        
    }


    public function actionDeleteLote($lote){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $criteria = new CDbCriteria;
        $criteria->condition = 'lote = "' . $lote. '" AND idCampaign = ' .$campaign->idCampaign;
        if(WalletsTempo::model()->deleteAll($criteria)){
            Yii::app()->user->setFlash('error', "No se han subido los registros");            
            $this->redirect(array('../database'));    
        } else{
            Yii::app()->user->setFlash('error', "Ocurrio un error por favor intente de nuevo");            
            $this->redirect(array('../database/'.$lote));    
        }
    }

    public function actionUploadLote($lote){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $criteria = new CDbCriteria;
        $criteria->condition = 'lote = "' . $lote. '" AND idCampaign = ' .$campaign->idCampaign;
        try{
            if(WalletsTempo::model()->updateAll(array("migrate"=>1), $criteria)){
                Yii::app()->user->setFlash('success', "Se han subido los registros");            
                $this->redirect(array('../dashboard'));    
            } else{
                Yii::app()->user->setFlash('error', "Ocurrio un error por favor intente de nuevo");            
                $this->redirect(array('../database/'.$lote));    
            }    
        }catch(Exception $e){
            Yii::log("Error subida lote => " . print_r($e->getMessage(),true) , "error", "updateLote");
            Yii::app()->user->setFlash('error', "Ocurrio un error por favor revise el archivo que tenga valores correctos. Revise la Fecha, que las ciudades y los bienes existan en la base de datos. De lo contrario comunicarse con el administrador. Presiones Declinar para detener la operaciÃ³n");            
            $this->redirect(array('../database/'.$lote));    
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
                ."<tr bgColor=\"#193153\" style=\"color:#FFF; text-align: center; font-weight: bold;\"><td>Comentario/Valor</td><td>GestiÃ³n</td><td>Tiempo</td></tr>"
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
        // $pdf->MultiCell(130,20,'Fecha de gestiÃ³n',1,'C',true, 0);
        // $pdf->MultiCell(130,20,'Tipo de gestiÃ³n',1,'C',true, 1);
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



    public function actionGetManagementLLPdf($idWallet){

        $date = new Datetime;

        $model = Wallets::model()->with('advisers','agendases','advisers')->findByPk($idWallet);

        // echo "<pre>";
        // print_r($model->agendases);
        // die();
        $img = Yii::app()->getBaseUrl(true)."/assets/img/logo.png";
        
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'cm', 'A4', true, 'UTF-8');
        $pdf->setPageUnit('pt');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Imaginamos");
        $pdf->SetTitle("Reporte de Cartera"+$model->legalName);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->AddPage();
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('20') , '', 'default', true );
        $pdf->MultiCell(296,40,'',0,'J',false, 0);
        $pdf->Image($img, 10, 10, 150, 20, '', '', '', true, 250);
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('12') , '', 'default', true );
        $pdf->MultiCell(296,40,'Fecha: '.$date->format('d/m/Y'),0,'R',false, 1);
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('20') , '', 'default', true );        
        $pdf->MultiCell(593,40,'Cliente: '.$model->legalName,0,'L',false, 1);
        $pdf->MultiCell(593,40,'',0,'L',false, 1);
        $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('12') , '', 'default', true ); 
        $pdf->SetFillColor(127,127,255);
        $pdf->MultiCell(130,20,'Nombre del asesor',1,'C',true, 0);
        $pdf->MultiCell(203,20,'Comentario',1,'C',true, 0);
        $pdf->MultiCell(130,20,'Fecha de gestiÃ³n',1,'C',true, 0);
        $pdf->MultiCell(130,20,'Tipo de gestiÃ³n',1,'C',true, 1);
        if(count($model->agendases)>0){
            $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('6') , '', 'default', true );
            foreach ($model->agendases as $agenda) {            
                $adviser = Advisers::model()->findByPk($agenda->idAdviser);

                $pdf->MultiCell(130,20,$adviser->name,1,'C',false, 0,'','',true,0,false,true,0,'M',false);
                $pdf->MultiCell(203,20,$agenda->comment,1,'C',false, 0,'','',true,0,false,true,0,'M',false);
                $dateManagement = new DateTime($agenda->dCreation);
                $pdf->MultiCell(130,20,$dateManagement->format('d/m/Y'),1,'C',false, 0,'','',true,0,false,true,0,'M',false);
                $action = Action::model()->findByPk($agenda->idAction);
                $effect = Effects::model()->findByPk($agenda->idEffect);
                $pdf->MultiCell(130,20,$action->actionName." - ".$effect->effectName,1,'C',false, 1,'','',true,0,false,true,0,'M',false);
            } 
        }else{
            $pdf->SetFont ('helvetica', '', $pdf->pixelsToUnits('10') , '', 'default', true );
            $pdf->MultiCell(593,20,'No existen gestiones para esta cartera',1,'C',false, 1,'','',true,0,false,true,0,'M',false);
        }
        
        $pdf->Output($model->legalName.".pdf", "I");
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

    public function actionSaveSupport(){
        
        Yii::import('application.google.google.*');
        require_once("protected/google/autoload.php");

        $idWallet = $_REQUEST['idWallet'];

        $configuration = array(
            'login'=>'cojunal@cojunal-1378.iam.gserviceaccount.com',
            'key'=>file_get_contents('assets/cojunal-38f2b0732bac.p12'),
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
        $uploadDir = 'assets/supports/';
        $fname = '1.txt';
        $file_name = $idWallet."/".$fname;
        $obj = new Google_Service_Storage_StorageObject();
        $obj->setName($file_name);
        $storage->objects->insert(
            "cojunal-1378.appspot.com",
            $obj,
            ['name' => $file_name, 'data' => file_get_contents($uploadDir.$fname), 'uploadType' => 'media','predefinedAcl' => 'publicRead']
        );

        return true;

    }


    /*===========================================================================================================
        5/Sept/2017 Unisoft - Wilmar Ibarguen M.
    ===========================================================================================================*/ 

    // // Esta funcion convierte los datos en una represntacion tipo json
    // function apiResponse($data) 
    // {
    //     header('Content-Type: application/json');
    //     echo json_encode($data);
    // }

    // // Esta funcion devuelve los datos para crear una campaÃ±a 
    // public function actionCrearCamapanaTemporal()
    // {
    //     // Crear el csv para cuando se reciba el ok del pago 
    //     $destino = './uploadCampaigns/'.time().'.csv';
    //     $archivo_temp = $_FILES['file']['tmp_name'];
    //     move_uploaded_file($archivo_temp, $destino);
    //     chmod($destino, 0777);
    //     $reader = ReaderFactory::create(Type::CSV); 
    //     $reader->open($destino);

    //     // inicializar variables
    //     $response['cant_deudores'] = 0;
    //     $response['total_campana'] = 0;

    //     $session = Yii::app()->session;
    //     $emailUsuario = $session['cojunal'];
    //     $adviser['idCampaign'] = Campaigns::getIdCampaignPorEmail($emailUsuario);

    //     // Posicion de los datos en el csv
    //     $fila = 0;
    //     $validacion = [];
    //     $lote = time();

    //     // leer el csv
    //     foreach ($reader->getSheetIterator() as $sheet) {
    //         foreach ($sheet->getRowIterator() as $row) {
    //             $fila++;
    //             if($fila > 1) {
    //                 $validacion = $this->configureRow($row, $adviser, $fila, $lote);
    //                 if(is_array($validacion)) {
    //                     $response['cant_deudores'] += 1;
    //                     $response['total_campana'] += ($row[1] > 0) ? $row[1] : 0;
    //                 }else {
    //                     break;
    //                 }
    //             }
    //         }
    //     }
    //     $reader->close();        
        
    //     // Configuracion de respuesta al cliente
    //     $idSercice = $_POST['Campaing']['notificationType'];
    //     $notificacion = NotificationType::get($idSercice);
    //     $response['email_usuario'] = $emailUsuario;
    //     $response['notificacion_description'] = $notificacion[0]['name'];
    //     $response['archivo_temp'] = $destino;
    //     $response['valor_servicio'] = $_POST['Campaing']['serviceType'];
    //     $response['campana_name'] = $_POST['Campaing']['campaignName'];
    //     $response['service_name'] = $_POST['serviceName'];
    //     $response['notificacion'] = $idSercice;
    //     $response['valor_pagar'] = number_format($response['valor_servicio'] * $response['cant_deudores'], 2);
    //     $response['total_campana'] = number_format($response['total_campana'], 2);

    //     // Mostrar error o datos de la campaÃ±a
    //     if(! is_array($validacion)) {
    //         $this->apiResponse($validacion);
    //     }else {
    //         $this->apiResponse($response);
    //     }
    // }

    // // Esta funcion guarda la campaÃ±a serializada a la espera de recibir los datos del pago
    // public function actionGuardarCamapanaTemporal()
    // {
    //     $campaign = Campaigns::getIdCampaignByEmail($_POST['email_usuario']); 
    //     $data['data'] = serialize($_POST);
    //     $data['name'] = $_POST['campana_name'];
    //     $data['idCampaign'] = $campaign['idCampaign'];
    //     $resp = SerializeCampaign::create($data);
    //     if($resp > 0) {
    //         $this->notificarAdminCreacionCampana($data['name'], 0, 'Pendiente de pago');
    //         $this->apiResponse($resp);
    //     }else {
    //         $this->apiResponse(0);
    //     } 
    // }

    // // Devuelve la row para con los datos para el insert en la tabla - serializeCampaign
    // private function configureRow($row = [], $adviser = [], $fila = 0, $lote = 0)
    // {
    //     // Validacion de campos requeridos
    //     if(! (isset($row[0]) && !empty($row[0]))) {
    //         return 'Falta el campo NIT - Cedula en la fila ' . $fila;
    //     }
    //     if(! (isset($row[1]) && !empty($row[1]))) {
    //         return 'Falta el campo Monto en la fila ' . $fila;
    //     }
    //     if(! (isset($row[2]) && !empty($row[2]))) {
    //         return 'Falta el campo Nombre en la fila ' . $fila;
    //     }
    //     if(! (isset($row[3]) && !empty($row[3]))) {
    //         return 'Falta el campo Direcci&oacute;n en la fila ' . $fila;
    //     }
    //     if(! (isset($row[4]) && !empty($row[4]))) {
    //         return 'Falta el campo Tel&eacute;fono en la fila ' . $fila;
    //     }
    //     if(! (isset($row[5]) && !empty($row[5]))) {
    //         return 'Falta el campo Correo en la fila ' . $fila;
    //     }
    //     if(! (isset($row[6]) && !empty($row[6]))) {
    //         return 'Falta el campo Ciudad en la fila ' . $fila;
    //     }
    //     if(! (isset($row[7]) && !empty($row[7]))) {
    //         return 'Falta el campo Producto en la fila ' . $fila;
    //     }
    //     if(! (isset($row[8]) && !empty($row[8]))) {
    //         return 'Falta el campo Fecha de Vencimiento en la fila ' . $fila;
    //     }
    //     if(! (isset($adviser['idCampaign']) && !empty($adviser['idCampaign']))) {
    //         return 'No hay usuario para esta sessiÃ³n';
    //     }

    //     // Datos conectores
    //     $data['idAdviser'] = 0;
    //     $data['idCampaign'] = $adviser['idCampaign'];
    //     $data['migrate'] = 0;
    //     $data['lote'] = $lote;
    //     $data['idStatus'] = 1;
    //     // Campos para la db desde el excel 
    //     $data['idNumber'] = $row[0];
    //     $data['capitalValue'] = $row[1];
    //     $data['legalName'] = $row[2];
    //     $data['address'] = $row[3];
    //     $data['phone'] = $row[4];
    //     $data['email'] = $row[5];
    //     $data['ciudad'] = $row[6];
    //     $data['product'] = $row[7];
    //     $data['validThrough'] = $row[8];
    //     $data['accountNumber'] = $row[9];
    //     $data['titleValue'] = $row[10];
    //     $data['typePhone1'] = $row[11];
    //     $data['countryPhone1'] = $row[12];
    //     $data['cityPhone1'] = $row[13];
    //     $data['phone1'] = $row[14];
    //     $data['typePhone2'] = $row[15];
    //     $data['countryPhone2'] = $row[16];
    //     $data['cityPhone2'] = $row[17];
    //     $data['phone2'] = $row[18];
    //     $data['typePhone3'] = $row[19];
    //     $data['countryPhone3'] = $row[20];
    //     $data['cityPhone3'] = $row[21];
    //     $data['phone3'] = $row[22];
    //     $data['nameReference1'] = $row[23];
    //     $data['relationshipReferenc1'] = $row[24];
    //     $data['countryReference1'] = $row[25];
    //     $data['cityReference1'] = $row[26];
    //     $data['commentReference1'] = $row[27];
    //     $data['nameReference2'] = $row[28];
    //     $data['relationshipReference2'] = $row[29];
    //     $data['countryReference2'] = $row[30];
    //     $data['cityReference2'] = $row[31];
    //     $data['commentReference2'] = $row[32];
    //     $data['nameReference3'] = $row[33];
    //     $data['relationshipReference3'] = $row[34];
    //     $data['countryReference3'] = $row[35];
    //     $data['cityReference3'] = $row[36];
    //     $data['commentReference3'] = $row[37];
    //     $data['nameEmail1'] = $row[38];
    //     $data['email1'] = $row[39];
    //     $data['nameEmail2'] = $row[40];
    //     $data['email2'] = $row[41];
    //     $data['nameEmail3'] = $row[42];
    //     $data['email3'] = $row[43];
    //     $data['typeAddress1'] = $row[44];
    //     $data['address1'] = $row[45];
    //     $data['countryAdrress1'] = $row[46];
    //     $data['cityAddress1'] = $row[47];
    //     $data['typeAddress2'] = $row[48];
    //     $data['address2'] = $row[49];
    //     $data['countryAddress2'] = $row[50];
    //     $data['cityAddress2'] = $row[51];
    //     $data['typeAddress3'] = $row[52];
    //     $data['address3'] = $row[53];
    //     $data['countryAddress3'] = $row[54];
    //     $data['cityAddress3'] = $row[55];
    //     $data['typeAsset1'] = $row[56];
    //     $data['nameAsset1'] = $row[57];
    //     $data['commentAsset1'] = $row[58];
    //     $data['typeAsset2'] = $row[59];
    //     $data['nameAsset2'] = $row[60];
    //     $data['commentAsset2'] = $row[61];
    //     $data['typeAsset3'] = $row[62];
    //     $data['nameAsset3'] = $row[63];
    //     $data['commentAsset3'] = $row[64];

    //     return $data;
    // } 

    // // Esta funciÃ³n devuelve el cuerpo del correo "CreaciÃ³n de campaÃ±as"
    // private function getCuerpoCorreo($nombre, $idCampaign, $estado)
    // {
    //     // Obtener el id usuario
    //     $session = Yii::app()->session;
    //     $emailUsuario = $session['cojunal'];
    //     $accion = ($idCampaign == 0) ? 'una nueva campaña' : 'el pago de una campaña';

    //     return '<table width="100%" border="0" align="center">
    //                 <tr>
    //                     <td height="100%">
    //                         <table width="100%" border="0" align="center">
    //                             <tr>
    //                                 <td>
    //                                     <p>
    //                                         Hola, se ha registrado '.$accion.' en la plataforma Cojunal a continuación se muestran los datos.
    //                                     </p>  
    //                                     <p>
    //                                         -<b>Nombre campaña:</b> '.$nombre.' <br>
    //                                         -<b>Estado:</b> ' .$estado. '<br>
    //                                         -<b>Usuario:</b> ' .$emailUsuario. '<br>
    //                                     </p>
    //                                     <p style="text-align: center">
    //                                         <a style="cursor: pointer" href="'.Yii::app()->getBaseUrl(true).'">Visualizar</a>
    //                                     </p>
    //                                     <p>
    //                                         Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
    //                                     </p>
    //                                 </td>
    //                             </tr>
    //                         </table>
    //                     </td>
    //                 </tr>
    //             </table>';
    // }

    // // Esta funcion avisa a los admin typo 2 que se crearon nuevas campaÃ±as
    // private function notificarAdminCreacionCampana($nombreCampana, $idCampaign, $stado)
    // {
    //     //nicvalencia@gmail.com
    //     $correos = CmsUsuario::obtenerEmailsAdmins();
    //     $enviados = 0;
    //     foreach ($correos as $correo) {
    //         $subject = 'Se acaba de crear una nueva campaÃ±a.';
    //         $bodyEmail = $this->getCuerpoCorreo($nombreCampana, $idCampaign, $stado);
    //         if (Controller::sendMailMandrill($correo, $subject, $bodyEmail)) $enviados++;
    //     }
    // }

}