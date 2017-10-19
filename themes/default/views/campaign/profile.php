<?php
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
  //Para probar idioma
  // Yii::app()->language = "en";
if($session['idioma']==2){
    Yii::app()->language = "en";
}else {
	Yii::app()->language = "es";
}
?>

<section class="cont_home">       
    <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
          <section class="padding">
                <section class="panelBG padd_all wow fadeInUp m_b_20 adding_db">
	          	<div class="dates_all">
			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"Nombre de la empresa")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->companyName ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"identificacion")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->idNumber ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"country")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= str_replace("-", "/", $district->fullDistrict) ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"address")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->address ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"contactName")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->contactName ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"email")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->contactEmail ?></p>
			        </div>

			        <div class="large-4 medium-3 small-12 columns padd_all">
			          <h2><?= Yii::t('profile',"phone")?></h2>
			        </div>
			        <div class="large-8 medium-3 small-12 columns padd_all">
			        	<p><?= $campaign->phone ?></p>
			        </div>

		      	</div>  
		      	</section>
		      </section>
          	<section class="padding">
                    <section class="panelBG padd_all wow fadeInUp m_b_20 adding_db">
                    	<p><a class="modal_clic" href="#new_pass"><i class="fa fa-unlock-alt" aria-hidden="true"></i> <?=Yii::t('profile',"changePassword")?></a></p>  
                    	<p><?=str_replace(":url", "</a>",str_replace("url:","<a href='$base/contactus'>",Yii::t("profile","parrafoProfile")))?></p>
                      <div class="clear"></div>
                      
                    </section>                    
                  </section>        	
        </section>

        <div class="clear"></div>
          
    </section>
  	<div class="clear"></div>
</section>