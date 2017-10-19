<?php
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
// print_r($idioma);
$idAdviser = Yii::app()->session['cojunal']->idAdviser;
$summary = Profilesummary::model()->findByAttributes(array('idAdvisers'=>$idAdviser));
if(isset($summary)){
  $porc = round(($summary->payments/$summary->assigned)*100,2);
}else{
  $porc = 0;
}
// echo "<pre>";
// print_r($idioma);
// die();
?>
<section class="cont_home">       
        <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
            
            <section class="padding">
              
              <section class="bg_perfil m_b_20">
                <!--Datos iniciales-->
                <section class="row">
                  <div class="dates_user">
                    <div class="large-8 medium-8 small-12 columns">
                      <div class="panel padd_all">
                        <h1><?= Yii::app()->session['cojunal']->name; ?></h1>
                        <h2><?= Yii::app()->session['cojunal']->email; ?></h2>
                        <p><a class="modal_clic" href="#new_pass"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Cambiar contraseña</a></p>
                      </div>
                    </div>
                    <div class="large-4 medium-4 small-12 columns">
                      <div class="panel padd_all">
                        <h3>SALDO TOTAL ASIGNADO</h3>
                        <?php 
                          if(isset($summary)){
                        ?>
                        <h4 class="val">$ <?= number_format($summary->assigned, 2, ',','.'); ?></h4>
                        <?php 
                          }else{
                        ?>
                        <h4 class="val">$ 0,00 </h4>
                        <?php 
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                </section>
                <!--Fin Datos iniciales-->

                <div class="porcent_user">
                  <div class="barra">
                    <div class="porcent" style="width:<?= $porc; ?>%"></div><span><?= $porc; ?>%</span>                           
                  </div>          
                </div>

                <!--Global Dashboard-->              
                <section class="list_dash">
                  <ul>
                    <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                      <div class="card_dash sin_margin waves-effect waves-light">                        
                        <div class="row txt_center">
                          <p class="block"><b>Número de campañas</b></p>
                        </div>
                          <div class="lineap"></div>
                        <div class="icon_num"><?= isset($summary)?$summary->campaigns:'0,00'; ?></div>                        
                        <div class="clear"></div>
                      </div>
                    </li>
                    <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                      <div class="card_dash sin_margin waves-effect waves-light">                        
                        <div class="row txt_center">
                          <p class="block"><b>Número de deudores</b></p>
                        </div>
                          <div class="lineap"></div>
                        <div class="icon_num"><?= isset($summary)?$summary->wallets:'0,00'; ?></div>                        
                        <div class="clear"></div>
                      </div>
                    </li>
                    <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                      <div class="card_dash sin_margin waves-effect waves-light">                        
                        <div class="row txt_center">
                          <p class="block"><b>Saldo total recuperado</b></p>
                        </div>
                          <div class="lineap"></div>
                        <div class="icon_num">$ <?= isset($summary)?number_format($summary->payments, 2, ',', '.'):'0,00';?></div>                        
                        <div class="clear"></div>
                      </div>
                    </li>
                    <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                      <div class="card_dash sin_margin waves-effect waves-light">                        
                        <div class="row txt_center">
                          <p class="block"><b>Saldo total recuperado</b></p>
                        </div>
                          <div class="lineap"></div>
                        <div class="icon_num"><?= $porc; ?>%</div>                        
                        <div class="clear"></div>
                      </div>
                    </li>                    
                  </ul>
                </section>
                <!--Fin Global Dashboard-->
              </section>     

              <section class="all_tareas">
                <div class="large-6 medium-6 small-12 columns">
                  <div class="bg_panel padding animated fadeInUp">
                    <?php 
                      setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                      $date = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));
                      $agendas = Yii::app()->db->createCommand()
                                 ->select('idWallet, legalName, phone, action')
                                 ->from('todaysmanagement')
                                 ->where('idAsesor=:idAsesor', array(':idAsesor'=>$idAdviser))
                                 ->andWhere('action!=:action', array(':action'=>'Promesa'))
                                 ->queryAll();
                      $todayDate = strftime("%d de %B de %Y",$date->getTimestamp());
                      $today = Todaysmanagement::model()->findAllByAttributes(array('idAsesor'=>$idAdviser, 'action'=>'!=Promesa'));                                            
                    ?>
                    <table class="striped">
                      <thead>                        
                        <tr>
                            <th data-field="id"><b>AGENDAS HOY <?= $todayDate; ?></b></th>
                            <th data-field="name"><a href="agenda" class="all_clic"><i class="fa fa-calendar" aria-hidden="true"></i> Ver todo</a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php              
                          foreach ($agendas as $agenda) {                            
                        ?>
                        <tr onClick="document.location.href='wallet/search/<?= $agenda['idWallet']; ?>';">
                          <td><?= $agenda['legalName']; ?> <br> <?= $agenda['phone']; ?></td>
                          <td><?= $agenda['action']; ?></td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="large-6 medium-6 small-12 columns">
                  <div class="bg_panel padding animated fadeInUp">
                    <?php 
                      $promises  = Yii::app()->db->createCommand()
                                   ->select('idWallet, legalName, phone, comment')
                                   ->from('todaysmanagement')
                                   ->where('idAsesor=:idAsesor', array(':idAsesor'=>$idAdviser))
                                   ->andWhere('action=:action', array(':action'=>'Promesa'))
                                   ->queryAll();
                    ?>
                    <table class="striped">
                      <thead>
                        <tr>
                            <th data-field="id"><b>PROMESAS HOY <?= $todayDate; ?></b></th>
                            <th data-field="name"><a href="agenda" class="all_clic"><i class="fa fa-calendar"></i> Ver todo</a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($promises as $promise) {
                        ?>
                        <tr onClick="document.location.href='wallet/search/<?= $promise['idWallet']?>';">
                          <td><?= $promise['legalName']?> <br> <?= $promise['phone']?></td>
                          <td><?= '$ '.number_format($promise['comment'], 2, ',', '.'); ?></td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>         

            </section>

            <div class="clear"></div>
          </section>
        </section>
          <div class="clear"></div>
      </section>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#profile").addClass("activo");
  });
</script>