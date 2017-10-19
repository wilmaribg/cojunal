<?php

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class DashboardController extends Controller {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $session = Yii::app()->session;
        //$session->destroy();
        if(isset($session['cojunal'])){
            Yii::log($session['cojunal'] ." -> Profile => ". $session['profile'],"error","init");
            if($session['profile']=="asesor"){
                $this->layout = 'layout_secure';
            }else {
                if($session['profile']=="empresa"){
                    $this->layout = 'layout_campaign';
                }else {
                    $this->actionLogin();
                }

            }
            if(!isset($session['idioma'])){
                $session['idioma'] = 1;
            }
            parent::init();
            Yii::app()->errorHandler->errorAction = 'site/error';
        }else {
            if(isset($_POST['user']) && isset($_POST['passwd'])){
                $_POST['YII_CSRF_TOKEN'] = Yii::app()->request->csrfToken;
                $this->actionLogin();
            }else {
                $this->actionLogout();
            }

            //$this->redirect(Yii::app()->homeUrl);
        }

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

    public function actionIndex() {
        $session = Yii::app()->session;
        switch ($session['profile']) {
            case 'Asesor':
                $this->profileAdvisers();
            break;
            case 'Asesor jurídico':
                $this->profileAdvisers();
            break;
            case 'Asesor pre jurídico':
                $this->profileAdvisers();
            break;
            case 'Coordinador':
                $this->profileAdvisers();
            break;
            case 'Coordinador jurídico':
                $this->profileAdvisers();
            break;
            case 'Coordinador pre jurídico':
                $this->profileCoordinatorPreJuridic_cpj();
            break;
            case 'empresa':
                $this->profileCampaign();
            break;
            default:
                $this->actionLogout();
            break;
        }
    }

    private function profileAdvisers(){
        $sesion = Yii::app()->session;
        $user = $sesion['cojunal'];
        $idAdviser = $user->idAdviser;

        $modelAuthAssignment = AuthAssignment::model()->findByPk($user->idAuthAssignment);

        //print_r($modelAuthAssignment);

        if($modelAuthAssignment->itemname == "Asesor"){
            $whereQs = 'idCampaign in (select idCampaign from wallets_has_campaigns where idCampaign in (Select idCampaign from `advisers_campaigns` where idAdvisers = '.$idAdviser.'))';
            $whereCommands= 'idAdvisers='.$idAdviser;
            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('viewlistdebtors v')
                    ->join('advisers_campaigns ac', 'ac.idCampaign = v.idCampaign')
                    ->where($whereCommands)
                    ->order('validThrough')
                    ->queryAll();

        }else {
            $whereCommands= '';
            $whereQs = '';
            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('viewlistdebtors v')
                    ->order('validThrough')
                    ->queryAll();

        }







        // $model = Viewlistdebtors::model()->with(array(
        //        'advisers_campaigns','advisers_campaigns.idAdvisers'=> array(
        //             'select' => false,
        //             'condition' => 'idAdvisers='.$idAdviser,
        //         ) ,
        //     ))->findAll(array('order'=>'validThrough', ''));


        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors v');
        if($modelAuthAssignment->itemname == "Asesor"){
            $command->join('advisers_campaigns ac', 'ac.idCampaign = v.idCampaign');
            $command->where($whereCommands);
        }
        //$command->where('target_product_id=:id', array(':id'=>$id));
        $valueUnity = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('(sum(currentDebt)*100)/sum(capitalValue)');
        $command->from('viewlistdebtors v');
        if($modelAuthAssignment->itemname == "Asesor"){
            $command->join('advisers_campaigns ac', 'ac.idCampaign = v.idCampaign');
            $command->where($whereCommands);
        }
        // $command->where('target_product_id=:id', array(':id'=>$id));
        $recover = $command->queryScalar();
        setlocale(LC_MONETARY, "en_US");

        // Quadrant 1
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q1');
        if($modelAuthAssignment->itemname == "Asesor"){
            $q->where($whereQs);
        }
        $q1Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q1');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        // $q1Value = money_format('%n',$q->queryScalar());
        $q1Value = "$ ".number_format($q->queryScalar(), 2, ',', '.');

        // Quadrant 2
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q2');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        $q2Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q2');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        // $q2Value = money_format('%n',$q->queryScalar());
        $q2Value = "$ ".number_format($q->queryScalar(), 2, ',', '.');

        // Quadrant 3
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q3');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        $q3Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q3');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        // $q3Value = money_format('%n',$q->queryScalar());
        $q3Value = "$ ".number_format($q->queryScalar(), 2, ',', '.');

        // Quadrant 4
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q4');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        $q4Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q4');
        if($modelAuthAssignment->itemname == "Asesor")
            $q->where($whereQs);
        // $q4Value = money_format('%n',$q->queryScalar());
        $q4Value = "$ ".number_format($q->queryScalar(), 2, ',', '.');

        $quadrants = array(
                'q1' => array(
                        'days' => $q1Days,
                        'value' => $q1Value
                    ),
                'q2' => array(
                        'days' => $q2Days,
                        'value' => $q2Value
                    ),
                'q3' => array(
                        'days' => $q3Days,
                        'value' => $q3Value
                    ),
                'q4' => array(
                        'days' => $q4Days,
                        'value' => $q4Value
                    ),
            );

        // $this->render('dashboard',array('debtorsCount'=>count($model), 'valueUnity'=>money_format('%n',($valueUnity)), 'recover'=>$recover, 'quadrants'=>$quadrants));
        $this->render('dashboard',array('debtorsCount'=>count($model), 'valueUnity'=>number_format($valueUnity, 2, ',', ' '), 'recover'=>$recover, 'quadrants'=>$quadrants));
    }

    /**
    * Functión que permite cargar la lista de deudores
    *
    */
    public function actionListDebtor($q=null) {
        $sesion = Yii::app()->session;
        $user = $sesion['cojunal'];
        $idAdviser = $user->idAdviser;

        $modelAuthAssignment = AuthAssignment::model()->findByPk($user->idAuthAssignment);

        if($modelAuthAssignment->itemname == "Asesor"){
            $whereQs = 'idCampaign in (select idCampaign from wallets_has_campaigns where idCampaign in (Select idCampaign from `advisers_campaigns` where idAdvisers = '.$idAdviser.'))';

            $whereViewDebtors = 'idCampaign in (Select idCampaign from `advisers_campaigns` where idAdvisers = '.$idAdviser.')';
        }

        $criteria = new CDbCriteria();
        if($modelAuthAssignment->itemname == "Asesor")
            $criteria->condition = $whereQs;
        $criteria->order = "dAssigment";

        $criteriaDebtors = new CDbCriteria();
        if($modelAuthAssignment->itemname == "Asesor")
            $criteriaDebtors->condition = $whereQs;
        $criteriaDebtors->order = "dAssigment";


        switch ($q) {
           case 1:
                $model = Q1::model()->findAll($criteria);
                $q=1;
                $table = 'q1';
            break;
            case 2:
                $model = Q2::model()->findAll($criteria);
                $q=2;
                $table = 'q2';
            break;
            case 3:
                $model = Q3::model()->findAll($criteria);
                $q=3;
                $table = 'q3';
            break;
            case 4 :
                $model = Q4::model()->findAll($criteria);
                $q=4;
                $table = 'q4';
            break;
           default:
                $model = Viewlistdebtors::model()->findAll($criteriaDebtors);
                $q=0;
                $table = 'viewlistdebtors';
           break;
       }
        $this->layout = 'layout_secure';
        $command=Yii::app()->db->createCommand();
        $command->select('(sum(currentDebt)*100)/sum(capitalValue)');
        $command->from($table);
        if($modelAuthAssignment->itemname == "Asesor")
            $command->where($whereQs);
        // $command->where('target_product_id=:id', array(':id'=>$id));
        $recover = $command->queryScalar();
        $this->render('dashboard_list', array('debtorsCount'=> count($model), 'allDebtors' => $model, 'recover'=>$recover, 'q'=> $q, 'modelFilter'=> $model));
    }

    /**
    * Functión que permite cargar la lista de deudores por un atributo específico
    *
    */
    public function actionListDebtorByAttribute($attribute,$id,$q=null) {
    //public function actionListDebtorByAttribute() {

        /*$attribute = $_REQUEST['attribute'];
        $id = $_REQUEST['valor'];
        $q = $_REQUEST['q'];
        */

        switch ($attribute) {
            case 'idNumber':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id,
                    'order'=>'dAssigment'
                ));
            break;
            case 'valueAssigment':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id,
                    'order'=>'dAssigment'
                ));
            break;
            case 'capitalValue':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id,
                    'order'=>'dAssigment'
                ));
            break;
            case 'interest':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id,
                    'order'=>'dAssigment'
                ));
            break;
            case 'feeValue':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id,
                    'order'=>'dAssigment'
                ));
            break;

            case 'name':
                $queryDistricts = new CDbCriteria(array(
                        'condition' => "name LIKE '%".$id."%'"
                    ));
                $wallets = Districts::model()->with("wallets")->findAll($queryDistricts);

                $idWallets = "";
                foreach ($wallets as $value) {

                    foreach ($value->wallets as $wallet) {
                        $idWallets = $idWallets.$wallet->idWallet.",";
                    }
                }

                $query = new CDbCriteria( array(
                    'condition' => "idWallet in(".substr($idWallets, 0,-1).")",
                    'order'=>'dAssigment'
                ));
            break;

            default:
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " LIKE '%".$id."%'",
                    'order'=>'dAssigment'
                ));
            break;
        }

        switch ($q) {
            case 1:
                if($id=="0")
                    $listDebtors = Q1::model()->findAll(array('order'=>'dAssigment'));
                else
                    $listDebtors = Q1::model()->findAll($query);
                $q=1;
            break;
            case 2:
                if($id=="0")
                    $listDebtors = Q2::model()->findAll(array('order'=>'dAssigment'));
                else
                    $listDebtors = Q2::model()->findAll($query);
                $q=2;
            break;
            case 3:
                if($id=="0")
                    $listDebtors = Q3::model()->findAll(array('order'=>'dAssigment'));
                else
                    $listDebtors = Q3::model()->findAll($query);
                $q=3;
                Yii::log("Entre a Q3" , "error", "Busqueda de Q3");
            break;
            case 4 :
                if($id=="0")
                    $listDebtors = Q4::model()->findAll(array('order'=>'dAssigment'));
                else
                    $listDebtors = Q4::model()->findAll($query);
                $q=4;
            break;
            default:
                $listDebtors = Viewlistdebtors::model()->findAll($query);
                $q=0;
            break;
        }

        $table = "";
        // if(!count($listDebtors)>0){
        //     $listDebtors = Viewlistdebtors::model()->findAll();
        // }
        foreach ($listDebtors as $listDebtor) {
            setlocale(LC_MONETARY, "en_US");
            $wallet = Wallets::model()->findByPk($listDebtor->idWallet);
            $district = Districts::model()->findByPk($wallet->idDistrict);
            $table.="<tr>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">". $listDebtor->name . "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->idNumber. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->legalName. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$district->name. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->dAssigment ."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->gestion ."días</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->description."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',($listDebtor->valueAssigment))."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',$listDebtor->capitalValue)."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',$listDebtor->interestMonth)."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',$listDebtor->feeValue)."</td>"
                          ."<td class=\"txt_center\"><div class=\"estado " . Yii::t("semaforo","color" . $listDebtor->type). " tooltipped\" data-position=\"top\" data-delay=\"50\" data-tooltip=\" " .Yii::t("semaforo", "type".$listDebtor->type). "\" data-id=\"".$listDebtor->idWallet."\"></div></td>"
                        ."</tr>";
        }

        echo $table;

    }

    /**
    * Método para listado de cuadrantes de campañas.
    *
    */
    private function profileCampaign(){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));

        $query = new CDbCriteria( array(
            'condition' => 'idCampaign' . "= " .$campaign->idCampaign,
            'order'=>'validThrough'
        ));

        $where = 'idCampaign=' .$campaign->idCampaign;

        $model = Viewlistdebtors::model()->findAll($query);
        $command=Yii::app()->db->createCommand();
        $command->select('sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where($where);
        $valueUnity = $command->queryScalar();

        $command=Yii::app()->db->createCommand();
        $command->select('(sum(currentDebt)*100)/sum(capitalValue)');
        $command->from('viewlistdebtors');
        $command->where($where);
        $recover = $command->queryScalar();
        setlocale(LC_MONETARY, "en_US");

        // Quadrant 1
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q1');
        $q->where($where);
        $q1Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q1');
        $q->where($where);
        $q1Value = money_format('%n',$q->queryScalar());

        // Quadrant 2
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q2');
        $q->where($where);
        $q2Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q2');
        $q->where($where);
        $q2Value = money_format('%n',$q->queryScalar());

        // Quadrant 3
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q3');
        $q->where($where);
        $q3Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q3');
        $q->where($where);
        $q3Value = money_format('%n',$q->queryScalar());

        // Quadrant 4
        $q = Yii::app()->db->createCommand();
        $q->select('max(DATEDIFF(CURRENT_DATE, validThrough))');
        $q->from('q4');
        $q->where($where);
        $q4Days = $q->queryScalar();
        $q = Yii::app()->db->createCommand();
        $q->select('sum(capitalValue)');
        $q->from('q4');
        $q->where($where);
        $q4Value = money_format('%n',$q->queryScalar());

        $quadrants = array(
                'q1' => array(
                        'days' => $q1Days,
                        'value' => $q1Value
                    ),
                'q2' => array(
                        'days' => $q2Days,
                        'value' => $q2Value
                    ),
                'q3' => array(
                        'days' => $q3Days,
                        'value' => $q3Value
                    ),
                'q4' => array(
                        'days' => $q4Days,
                        'value' => $q4Value
                    ),
            );

        $data = array(
            'debtorsCount'=>count($model), 
            'valueUnity'=>money_format('%n',($valueUnity)), 
            'recover'=>$recover, 
            'quadrants'=>$quadrants, 
        );

        $this->render('dashboard_campaign', $data);

    }


    public function actionListCampaign($q=null){
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $query = new CDbCriteria( array(
            'condition' => 'idCampaign' . "= " .$campaign->idCampaign,
            'order'=>'dAssigment'
        ));
        switch ($q) {
           case 1:
                $model = Q1::model()->findAll($query);
                $q=1;
                $table = 'q1';
            break;
            case 2:
                $model = Q2::model()->findAll($query);
                $q=2;
                $table = 'q2';
            break;
            case 3:
                $model = Q3::model()->findAll($query);
                $q=3;
                $table = 'q3';
            break;
            case 4 :
                $model = Q4::model()->findAll($query);
                $q=4;
                $table = 'q4';
            break;
           default:
                $model = Viewlistdebtors::model()->findAll($query);
                $q=0;
                $table = 'viewlistdebtors';
           break;
       }
        $this->layout = 'layout_campaign';
        $command=Yii::app()->db->createCommand();
        $command->select('(sum(currentDebt)*100)/sum(capitalValue)');
        $command->from($table);
        $command->where('idCampaign=:id', array(':id'=>$campaign->idCampaign));
        $recover = $command->queryScalar();
        $this->render('list_campaign', array('debtorsCount'=> count($model), 'allDebtors' => $model, 'recover'=>$recover, 'q'=> $q, 'modelFilter'=> $model));
    }


    /**
    * Functión que permite cargar la lista de deudores por un atributo específico
    *
    */
    public function actionListDebtorByAttributeCampaign($attribute,$id,$q=null) {
        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));

        $where = 'idCampaign=' .$campaign->idCampaign;

        $queryBasic = new CDbCriteria( array(
            'condition' => 'idCampaign' . "= " .$campaign->idCampaign,
            'order'=>'dAssigment'
        ));

        switch ($attribute) {
            case 'idNumber':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id . " and " . $where,
                    'order'=>'dAssigment'
                ));
            break;
            case 'valueAssigment':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id . " and " . $where,
                    'order'=>'dAssigment'
                ));
            break;
            case 'debt':
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " = ".$id . " and " . $where,
                    'order'=>'dAssigment'
                ));
            break;

            case 'name':
                $queryDistricts = new CDbCriteria(array(
                        'condition' => "name LIKE '%".$id."%'"
                    ));
                $wallets = Districts::model()->with("wallets")->findAll($queryDistricts);

                $idWallets = "";
                foreach ($wallets as $value) {

                    foreach ($value->wallets as $wallet) {
                        $idWallets = $idWallets.$wallet->idWallet.",";
                    }
                }

                $query = new CDbCriteria( array(
                    'condition' => "idWallet in(".substr($idWallets, 0,-1).") and " . $where,
                    'order'=>'dAssigment'
                ));
            break;

            default:
                $query = new CDbCriteria( array(
                    'condition' => $attribute . " LIKE '%".$id."%'" . " and " . $where,
                    'order'=>'dAssigment'
                ));
            break;
        }

        switch ($q) {
            case 1:
                if($id=="0")
                    $listDebtors = Q1::model()->findAll($queryBasic);
                else
                    $listDebtors = Q1::model()->findAll($query);
                $q=1;
            break;
            case 2:
                if($id=="0")
                    $listDebtors = Q2::model()->findAll($queryBasic);
                else
                    $listDebtors = Q2::model()->findAll($query);
                $q=2;
            break;
            case 3:
                if($id=="0")
                    $listDebtors = Q3::model()->findAll($queryBasic);
                else
                    $listDebtors = Q3::model()->findAll($query);
                $q=3;
                Yii::log("Entre a Q3" , "error", "Busqueda de Q3");
            break;
            case 4 :
                if($id=="0")
                    $listDebtors = Q4::model()->findAll($queryBasic);
                else
                    $listDebtors = Q4::model()->findAll($query);
                $q=4;
            break;
            default:
                $listDebtors = Viewlistdebtors::model()->findAll($query);
                $q=0;
            break;
        }

        $table = "";
        // if(!count($listDebtors)>0){
        //     $listDebtors = Viewlistdebtors::model()->findAll();
        // }
        foreach ($listDebtors as $listDebtor) {
            setlocale(LC_MONETARY, "en_US");
            $wallet = Wallets::model()->findByPk($listDebtor->idWallet);
            $district = Districts::model()->findByPk($wallet->idDistrict);
            $table.="<tr onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\">"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->idNumber. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->legalName. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/wallet/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$district->name. "</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->dAssigment ."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->gestion ."días</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".$listDebtor->description."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\"><div class=\"estado " . Yii::t("semaforo","color" . $listDebtor->type). " tooltipped\" data-position=\"top\" data-delay=\"50\" data-tooltip=\" " .Yii::t("semaforo", "type".$listDebtor->type). "\" data-id=\"".$listDebtor->idWallet."\"></div></td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',($listDebtor->valueAssigment))."</td>"
                          ."<td onClick=\"document.location.href='". Yii::app()->baseUrl ."/campaign/search/".$listDebtor->idWallet."'\" class=\"txt_center\">".money_format('%n',$listDebtor->debt)."</td>"
                        ."</tr>";
        }

        echo $table;

    }

    public function actionDatabase(){
        Yii::import('application.models.NotificationType');

        $session = Yii::app()->session;
        $user = $session['cojunal'];
        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user));
        $data = [ 
            'notifications' => NotificationType::getAll(),
            'campaign' => $campaign
         ];
        $this->render('database', $data);
    }

    //ejemplo login *****
    public function actionLogout() {
        Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion";
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    //login con user and password
    public function actionLogin() {
        Yii::import('application.recaptcha.ReCaptcha.*');
        require_once("ReCaptcha.php");
        // Register API keys at https://www.google.com/recaptcha/admin
        if (isset($_POST['g-recaptcha-response'])){
        $recaptcha = new ReCaptcha;
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if ($resp->isSuccess()){
            Yii::log("Entre en resp", "error", "Login" );
            if (isset($_POST['user'], $_POST['passwd']) && $this->validateCsrfTokenPost()) {
                Yii::log("Entre en user and pass", "error", "Login" );
                $user = $_POST['user'];
                $passwd = $_POST['passwd'];
                $authAssigment = AuthAssignment::model()->findByAttributes(array('userid'=>$user));
                Yii::log("Entre a validar en Assigment", "error", "login");
                if(isset($authAssigment) && count($authAssigment)==1){
                    Yii::log("Entre en authassigment", "error", "Login" );
                    $advisers = Advisers::model()->findByAttributes(array('idAuthAssignment'=>$authAssigment->idAuthAssignment, 'passwd'=>md5($passwd)));
                    // Obtenemos el perfil del usuario
                    $user_perfile = AuthAssignment::getProfile($advisers['email']);
                    if(isset($advisers) && count($advisers)==1){
                        Yii::log("Entre en advisers", "error", "Login" );
                        $session = Yii::app()->session;
                        Yii::app()->session['cojunal'] = $advisers;
                        $session['cojunal'] = $advisers;
                        $session['profile'] = $user_perfile['itemname'];
                        $this->redirect(Yii::app()->homeUrl . "dashboard");
                    }else {
                        $campaign = Campaigns::model()->findByAttributes(array('contactEmail'=>$user, 'passwd'=>md5($passwd)));
                        Yii::log("Campaign=>" . print_r($campaign,true), "error", "Login" );
                        if(count($campaign)==1){
                            $session = Yii::app()->session;
                            $session['cojunal'] = $user;
                            $session['campaign'] = $campaign;
                            $session['profile'] = 'empresa';
                            $this->redirect(Yii::app()->homeUrl . "dashboard");
                        }else {
                            Yii::log("Entre a validar en else campañas", "error", "login");
                            Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion/errorLogin";
                            Yii::app()->user->logout();
                            $this->redirect(Yii::app()->homeUrl);
                        }
                    }
                }else {
                    if(count(Campaigns::model()->findByAttributes(array('contactEmail'=>$user, 'passwd'=>md5($passwd))))==1){
                        $session = Yii::app()->session;
                        $session['cojunal'] = $user;
                        $session['profile'] = 'empresa';
                        $this->redirect(Yii::app()->homeUrl . "dashboard");
                    }else {
                        Yii::log("Entre a validar en else campañas", "error", "login");
                        Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion/errorLogin";
                        Yii::app()->user->logout();
                        $this->redirect(Yii::app()->homeUrl);
                    }
                }

            }
        }
    }
        // header('Content-type: application/json');
        // echo CJSON::encode($message);
    }

    //ejemplo connect social
    public function actionConnectSocial() {
        $session = Yii::app()->session;
        Yii::import('ext.hybridauth.Hybrid.Auth', true);
        // include hybridauth lib
        $url = $this->createAbsoluteUrl('site/connectSocial');
        $config = $this->configSocial($url);
        $hybridauth = new Hybrid_Auth($config);
        //posibles errores
        if (isset($_REQUEST['hauth_done']) && (($_REQUEST['hauth_done'] == 'Twitter' && isset($_REQUEST['denied'])) || ($_REQUEST['hauth_done'] == 'LinkedIn' && isset($_REQUEST['oauth_problem'])))
        ) {
            if (isset($session['social'])) {
                unset($session['social']);
            }
            $hybridauth->logoutAllProviders();
            $this->redirect(array('zonaSegura'));
            Yii::app()->end();
        }
        //validar auto sesiones
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
            Yii::import('ext.hybridauth.Hybrid.Endpoint', true);
            Hybrid_Endpoint::process();
        }
        // start login with facebook?
        if (isset($_GET["login"]) && ($_GET["login"] == "Facebook" || $_GET["login"] == "Google" || $_GET["login"] == "Twitter" || $_GET["login"] == "LinkedIn")) {
            try {
                $adapter = $hybridauth->authenticate($_GET["login"]);
                $user_profile = $adapter->getUserProfile();
                if (isset($user_profile)) {
                    if ((isset($user_profile->emailVerified) && $user_profile->emailVerified != "") || ($hybridauth->isConnectedWith('twitter') && isset($_GET["login"]) && $_GET["login"] == "Twitter")) {
                        $session['social'] = get_object_vars($user_profile);
                        $session['typeSocial'] = $_GET["login"];
                    } elseif (isset($session['social'])) {
                        unset($session['social']);
                        $hybridauth->logoutAllProviders();
                    }
                }
            } catch (Exception $e) {
                die("<b>got an error!</b> " . $e->getMessage());
            }
        }
        if (isset($session['social'])) {
            //campo en la base de datos
            $idred = "idfacebook";
            $identifier = $session['social']['identifier'];
            switch ($session['typeSocial']) {
                case "Facebook":
                    $idred = "idfacebook";
                    break;
                case "Google":
                    $idred = "idgoogle";
                    break;
                case "Twitter":
                    $idred = "idtwitter";
                    break;
                case "LinkedIn":
                    $idred = "idlinkedin";
                    break;
            }
            $resp = $this->validateUserFront($identifier, $identifier, false, $idred);
            //si el acceso es correcto
            if ($resp == "ok") {
                Yii::app()->user->setFlash('success', Yii::t('front', 'Bienvenido ' . Yii::app()->user->getState('title')));
                $this->redirect(array('zonaSegura'));
                //si el usuario no existe y debe registrarse
            } elseif (Usuario::model()->count("idfacebook='$identifier'") == 0) {
                $this->redirect(array('index', 't' => 'register'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('front', $resp));
                $this->redirect(array('index'));
            }
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

    public function actionUpdateType($idWallet,$type){
        $model = Wallets::model()->findByPk($idWallet);
        $model->type = $type;
        Yii::log(print_r($model,true),"error", "updateType");
        if($model->save()){
            Yii::app()->user->setFlash('success', Yii::t('front', "Se ha guardado el tipo exitosamente"));
            return "ok";
        }else {
            Yii::app()->user->setFlash('error', Yii::t('front', "No se pudo actualizar el tipo"));
            Yii::log(print_r($model->getErrors(),true),"error", "updateType");
            return "error";
        }
    }

    /*=========================================================================================
        14/09/2017 Wilmar Ibarguen - Unisoft
    =========================================================================================*/
    
    // Nomenclatura (prefijo en las funciones)
    // _cj = coordinador juridico
    // _cpj = coordinador pre juridico
    // _aj = asesor juridico
    // _apj = asesor pre juridico

    // Esta funcion imprime una salida en formato json
    function apiResponse($data) 
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Esta funcion me renderiza el perfil coordinador
    public function profileCoordinatorPreJuridic_cpj() {
        $this->layout = 'layout_coordinador_pre_juridico';
        $this->render('coord_pre_juridico/campanas');
    }

    // Esta funcione me devuelve Cliente # campañas por cliente  Valor total  Saldo a la fecha  % recaudo  # deudores 
    function actionGetCampanasPorCliente_cpj()
    {
        $session = Yii::app()->session;
        $this->apiResponse(Campaigns::getCampanasPorClienteMin_cpj($session['cojunal']['email']));
    } 

    // Esta funcion es la respuesta del pago de la campaÃ±a
    public function actionPagoOk($id)
    {
        // Obtenemos le ID de la campaÃ±a serializada
        $idCampanaSerializada = $_GET['id'];

        // Obtener los datos de la campaÃ±a
        $temp = SerializeCampaign::get($idCampanaSerializada);
        if(!isset($temp) || empty($temp)) {
            $error = [ 'Tipo' => 'Error', 'Mensaje' => 'No es posible migrar esta campaÃ±a, comunicate con el proveedor del servicio para mÃ¡s informaciÃ³n.' ];
            $this->apiResponse($error);
            exit();
        }

        $temp = unserialize($temp[0]['data']);


        // Leer archivo csv
        $reader = ReaderFactory::create(Type::CSV);         
        $reader->open($temp['archivo_temp']);
       
        // Obtener el id usuario
        $session = Yii::app()->session;
        $emailUsuario = $session['cojunal'];
        $adviser['idCampaign'] = Campaigns::getIdCampaignPorEmail($emailUsuario);
        
        // var_dump($emailUsuario);
        // echo "<br>";
        // echo "<br>";
        // var_dump($session);
        // echo "<br>";
        // echo "<br>";
        // var_dump($adviser['idCampaign']);
        // exit();

        $adviser['idCampaign'] = $adviser['idCampaign'][0];
        
        // Creamos la campaÃ±a
        $datosCampana = [];
        $datosCampana['idCampaign'] = $adviser['idCampaign'];
        $datosCampana['campaignName'] = $temp['campana_name'];
        $datosCampana['serviceType'] = $temp['service_name'];
        $datosCampana['notificationType'] = $temp['notificacion'];
        if(! WalletsByCampaign::save_data($datosCampana)) {
            $error = [ 'Tipo' => 'Error', 'Mensaje' => 'No se pudo crear la campaÃ±a.' ];
            $this->apiResponse($error);
            exit();
        }else {
            // Obtenemos el id del insert del wallet (CampaÃ±a como tal)
            $idWalletByCampaign = WalletsByCampaign::getLastID();
            $datosFinancieros = Campaigns::getCampaingsValues($adviser['idCampaign']);
            $datos['fee'] = $datosFinancieros['fees'];
            $datos['interests'] = $datosFinancieros['interest'];
            $datos['comisions'] = $datosFinancieros['percentageCommission'];
            $datos['idWalletByCampaign'] = $idWalletByCampaign;
            WalletsByCampaign::setDatosFinacieros($datos);

            // Insertamos los emails de notificacion
            foreach ($temp['emails'] as $email) {
                CampaignsEmailsNotifications::agregarEmailNotificacion([
                    'email' => $email,
                    'idCampaign' => $idWalletByCampaign
                ]);
            }
        }

        // Posicion de los datos en el csv
        $fila = 0;
        $lote = time();

        // Alamacenamos los datos para el insert multiple
        $datosAinsertar = [];

        // leer el csv
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $row) {
                $fila++;
                if($fila > 1) {
                    $r = $this->configureRow($row, ['idCampaign' => $idWalletByCampaign], $fila, $lote);
                    $datosAinsertar[] = $r;
                }
            }
        }
        $reader->close();

        // Guadamos los datos de los deuores
        if($cant = WalletsTempo::save_campaign_deudores($datosAinsertar)) {
            $final = SerializeCampaign::update_callback_migration($idCampanaSerializada);
            $this->notificarAdminCreacionCampana($datosCampana['campaignName'], $idWalletByCampaign, 'Pago regsitrado');
            $this->apiResponse($final);
        }
    }

    // Devuelve la row para con los datos para el insert en la tabla - serializeCampaign
    private function configureRow($row = [], $adviser = [], $fila = 0, $lote = 0)
    {
        // Validacion de campos requeridos
        if(! (isset($row[0]) && !empty($row[0]))) {
            return 'Falta el campo NIT - Cedula en la fila ' . $fila;
        }
        if(! (isset($row[1]) && !empty($row[1]))) {
            return 'Falta el campo Monto en la fila ' . $fila;
        }
        if(! (isset($row[2]) && !empty($row[2]))) {
            return 'Falta el campo Nombre en la fila ' . $fila;
        }
        if(! (isset($row[3]) && !empty($row[3]))) {
            return 'Falta el campo Direcci&oacute;n en la fila ' . $fila;
        }
        if(! (isset($row[4]) && !empty($row[4]))) {
            return 'Falta el campo Tel&eacute;fono en la fila ' . $fila;
        }
        if(! (isset($row[5]) && !empty($row[5]))) {
            return 'Falta el campo Correo en la fila ' . $fila;
        }
        if(! (isset($row[6]) && !empty($row[6]))) {
            return 'Falta el campo Ciudad en la fila ' . $fila;
        }
        if(! (isset($row[7]) && !empty($row[7]))) {
            return 'Falta el campo Producto en la fila ' . $fila;
        }
        if(! (isset($row[8]) && !empty($row[8]))) {
            return 'Falta el campo Fecha de Vencimiento en la fila ' . $fila;
        }
        if(! (isset($adviser['idCampaign']) && !empty($adviser['idCampaign']))) {
            return 'No hay usuario para esta sessiÃ³n';
        }

        // Datos conectores
        $data['idAdviser'] = 0;
        $data['idCampaign'] = $adviser['idCampaign'];
        $data['migrate'] = 0;
        $data['lote'] = $lote;
        $data['idStatus'] = 1;
        // Campos para la db desde el excel 
        $data['idNumber'] = $row[0];
        $data['capitalValue'] = $row[1];
        $data['legalName'] = $row[2];
        $data['address'] = $row[3];
        $data['phone'] = $row[4];
        $data['email'] = $row[5];
        $data['ciudad'] = $row[6];
        $data['product'] = $row[7];
        $data['validThrough'] = $row[8];
        $data['accountNumber'] = $row[9];
        $data['titleValue'] = $row[10];
        $data['typePhone1'] = $row[11];
        $data['countryPhone1'] = $row[12];
        $data['cityPhone1'] = $row[13];
        $data['phone1'] = $row[14];
        $data['typePhone2'] = $row[15];
        $data['countryPhone2'] = $row[16];
        $data['cityPhone2'] = $row[17];
        $data['phone2'] = $row[18];
        $data['typePhone3'] = $row[19];
        $data['countryPhone3'] = $row[20];
        $data['cityPhone3'] = $row[21];
        $data['phone3'] = $row[22];
        $data['nameReference1'] = $row[23];
        $data['relationshipReferenc1'] = $row[24];
        $data['countryReference1'] = $row[25];
        $data['cityReference1'] = $row[26];
        $data['commentReference1'] = $row[27];
        $data['nameReference2'] = $row[28];
        $data['relationshipReference2'] = $row[29];
        $data['countryReference2'] = $row[30];
        $data['cityReference2'] = $row[31];
        $data['commentReference2'] = $row[32];
        $data['nameReference3'] = $row[33];
        $data['relationshipReference3'] = $row[34];
        $data['countryReference3'] = $row[35];
        $data['cityReference3'] = $row[36];
        $data['commentReference3'] = $row[37];
        $data['nameEmail1'] = $row[38];
        $data['email1'] = $row[39];
        $data['nameEmail2'] = $row[40];
        $data['email2'] = $row[41];
        $data['nameEmail3'] = $row[42];
        $data['email3'] = $row[43];
        $data['typeAddress1'] = $row[44];
        $data['address1'] = $row[45];
        $data['countryAdrress1'] = $row[46];
        $data['cityAddress1'] = $row[47];
        $data['typeAddress2'] = $row[48];
        $data['address2'] = $row[49];
        $data['countryAddress2'] = $row[50];
        $data['cityAddress2'] = $row[51];
        $data['typeAddress3'] = $row[52];
        $data['address3'] = $row[53];
        $data['countryAddress3'] = $row[54];
        $data['cityAddress3'] = $row[55];
        $data['typeAsset1'] = $row[56];
        $data['nameAsset1'] = $row[57];
        $data['commentAsset1'] = $row[58];
        $data['typeAsset2'] = $row[59];
        $data['nameAsset2'] = $row[60];
        $data['commentAsset2'] = $row[61];
        $data['typeAsset3'] = $row[62];
        $data['nameAsset3'] = $row[63];
        $data['commentAsset3'] = $row[64];

        return $data;
    } 

    // Esta funciÃ³n devuelve el cuerpo del correo "CreaciÃ³n de campaÃ±as"
    private function getCuerpoCorreo($nombre, $idCampaign, $estado)
    {
        // Obtener el id usuario
        $session = Yii::app()->session;
        $emailUsuario = $session['cojunal'];
        $accion = ($idCampaign == 0) ? 'una nueva campaña' : 'el pago de una campaña';

        return '<table width="100%" border="0" align="center">
                    <tr>
                        <td height="100%">
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <td>
                                        <p>
                                            Hola, se ha registrado '.$accion.' en la plataforma Cojunal a continuación se muestran los datos.
                                        </p>  
                                        <p>
                                            -<b>Nombre campaña:</b> '.$nombre.' <br>
                                            -<b>Estado:</b> ' .$estado. '<br>
                                            -<b>Usuario:</b> ' .$emailUsuario. '<br>
                                        </p>
                                        <p style="text-align: center">
                                            <a style="cursor: pointer" href="'.Yii::app()->getBaseUrl(true).'">Visualizar</a>
                                        </p>
                                        <p>
                                            Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>';
    }

    // Esta funcion avisa a los admin typo 2 que se crearon nuevas campaÃ±as
    private function notificarAdminCreacionCampana($nombreCampana, $idCampaign, $stado)
    {
        //nicvalencia@gmail.com
        $correos = CmsUsuario::obtenerEmailsAdmins();
        $enviados = 0;
        foreach ($correos as $correo) {
            $subject = 'Se acaba de crear una nueva campaña.';
            $bodyEmail = $this->getCuerpoCorreo($nombreCampana, $idCampaign, $stado);
            if (Controller::sendMailMandrill($correo, $subject, $bodyEmail)) $enviados++;
        }
    } 

    // Esta funcion devuelve los datos para crear una campaÃ±a 
    public function actionCrearCamapanaTemporal()
    {
        // Crear el csv para cuando se reciba el ok del pago 
        $destino = './uploadCampaigns/'.time().'.csv';
        $archivo_temp = $_FILES['file']['tmp_name'];
        move_uploaded_file($archivo_temp, $destino);
        chmod($destino, 0777);
        $reader = ReaderFactory::create(Type::CSV); 
        $reader->open($destino);

        // inicializar variables
        $response['cant_deudores'] = 0;
        $response['total_campana'] = 0;

        $session = Yii::app()->session;
        $emailUsuario = $session['cojunal'];
        $adviser['idCampaign'] = Campaigns::getIdCampaignPorEmail($emailUsuario);

        // Posicion de los datos en el csv
        $fila = 0;
        $validacion = [];
        $lote = time();

        // leer el csv
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $fila++;
                if($fila > 1) {
                    $validacion = $this->configureRow($row, $adviser, $fila, $lote);
                    if(is_array($validacion)) {
                        $response['cant_deudores'] += 1;
                        $response['total_campana'] += ($row[1] > 0) ? $row[1] : 0;
                    }else {
                        break;
                    }
                }
            }
        }
        $reader->close();        
        
        // Configuracion de respuesta al cliente
        $idSercice = $_POST['Campaing']['notificationType'];
        $notificacion = NotificationType::get($idSercice);
        $response['email_usuario'] = $emailUsuario;
        $response['notificacion_description'] = $notificacion[0]['name'];
        $response['archivo_temp'] = $destino;
        $response['valor_servicio'] = $_POST['Campaing']['serviceType'];
        $response['campana_name'] = $_POST['Campaing']['campaignName'];
        $response['service_name'] = $_POST['serviceName'];
        $response['notificacion'] = $idSercice;
        $response['valor_pagar'] = number_format($response['valor_servicio'] * $response['cant_deudores'], 2);
        $response['total_campana'] = number_format($response['total_campana'], 2);

        // Mostrar error o datos de la campaÃ±a
        if(! is_array($validacion)) {
            $this->apiResponse($validacion);
        }else {
            $this->apiResponse($response);
        }
    }

    // Esta funcion guarda la campaÃ±a serializada a la espera de recibir los datos del pago
    public function actionGuardarCamapanaTemporal()
    {
        $campaign = Campaigns::getIdCampaignByEmail($_POST['email_usuario']); 
        $data['data'] = serialize($_POST);
        $data['name'] = $_POST['campana_name'];
        $data['idCampaign'] = $campaign['idCampaign'];
        $resp = SerializeCampaign::create($data);
        if($resp > 0) {
            $this->notificarAdminCreacionCampana($data['name'], 0, 'Pendiente de pago');
            $this->apiResponse($resp);
        }else {
            $this->apiResponse(0);
        } 
    }

    // Esta funcion me devuelve las campañas del cliente que tenga iniciada session
    public function actionObtenerCampanasParaUsuario()
    {
        $session = Yii::app()->session;
        $idCampaign = Campaigns::getIdCampaignByEmail($session['cojunal']);
        $this->apiResponse(Campaigns::getIdCampaignByUsers($idCampaign["idCampaign"]));
    }

}
