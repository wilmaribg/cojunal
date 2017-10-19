<?php

class WalletsController extends GxController {

        public $defaultAction = 'admin';

        public function filters() {
            Yii::app()->getComponent('booster');
            return array(
                'accessControl', 
            );
        }

        public function accessRules() {
            return array(
                array('allow',
                        'expression'=>'Controller::validateAccess()',
                        ),
                array('deny', 
                        'users'=>array('*'),
                        ),
            );
        }
        

	public function actionCreate() {
		$model = new Wallets;
        $now = date("Y-m-d H:m:s");
        $sysParams = Sysparams::model()->findByPk(1);
        $feeValue = $sysParams->feeRate;
        $interestRate = $sysParams->interestRate;
        $modelWalletsHasCampaigns = new WalletsHasCampaigns;
		$this->performAjaxValidation($model, 'wallets-form');
		if (isset($_POST['Wallets'])) {
            $modelCampaigns = $_POST['Campaigns'];
			$model->setAttributes($_POST['Wallets']);
            $model->dUpdate = $now ;
            $model->currentDebt = 0;
            $model->feeValue = ($model->capitalValue*$feeValue)/100;
            $model->interestsValue = ($model->capitalValue*$interestRate)/100;
            $modelWalletsHasCampaigns->idCampaign = $modelCampaigns['idCampaign'];
            if(isset($model->walletsHasCampaigns))
                $model->unsetAttributes(array('walletsHasCampaigns'));
			if ($model->save()) {
                $modelWalletsHasCampaigns->idWallet = $model->idWallet;
                if($modelWalletsHasCampaigns->save()){
                            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                                Yii::app()->end();
                            }else{
                                Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                                $this->redirect(array('admin'));
                            }
                }else{
                    $model->delete();
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido registrar el deudor"));
                }
                $this->redirect(array('admin'));
			}
		}
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
        $now = date("Y-m-d H:m:s");
        $sysParams = Sysparams::model()->findByPk(1);
        $feeValue = $sysParams->feeRate;
        $interestRate = $sysParams->interestRate;
		$model = $this->loadModel($id, 'Wallets');
		$this->performAjaxValidation($model, 'wallets-form');
		if (isset($_POST['Wallets'])) {
			$model->setAttributes($_POST['Wallets']);
            $modelCampaigns = $_POST['Campaigns'];
            $walletsHasCampaigns = WalletsHasCampaigns::model()->findByPk($model->walletsHasCampaigns);
            $walletsHasCampaigns->idCampaign = $modelCampaigns['idCampaign'];
            $model->feeValue = ($model->capitalValue*$feeValue)/100;
            $model->interestsValue = ($model->capitalValue*$interestRate)/100;
            $model->dUpdate = $now ;
			if ($model->save()) {
                if($walletsHasCampaigns->save()){
                            Yii::app()->user->setFlash("success", Yii::t('app', "Registro guardado con éxito"));
                            $this->redirect(array('admin'));
                }else{
                    $model->delete();
                    Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido actualizar el deudor"));
                }
                $this->redirect(array('admin'));
			}
		}
		$this->render('update', array( 'model' => $model));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
                    $this->loadModel($id, 'Wallets')->delete();
                    if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                        Yii::app()->user->setFlash("success", Yii::t('app', "Registro eliminado con éxito"));
                        $this->redirect(array('admin'));
                    }
		} else{
                    throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
                }
	}

	public function actionAdmin() {
		$model = new Wallets('search');
		$model->unsetAttributes();
		if (isset($_GET['Wallets'])){
			$model->setAttributes($_GET['Wallets']);
                }
		$this->render('admin', array('model' => $model));
	}

}