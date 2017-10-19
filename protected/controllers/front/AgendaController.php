<?php 

	class AgendaController extends GxController {
	

		public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_secure';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
    }

		public function actionIndex(){
			$session = Yii::app()->session;
			$this->render('agenda');
		}

	}
?>