<section class="cont_home">       
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      
      <section class="padding">
        
        <section class="bg_perfil m_b_20">

          <!--Global Dashboard-->              
          <section class="list_dash">
            <ul>
              <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                <div class="card_dash sin_margin waves-effect waves-light">                        
                  <div class="row txt_center">
                    <p class="block"><b>Número de campañas</b></p>
                  </div>
                    <div class="lineap"></div>
                  <div class="icon_num">
                    <?php echo $dashboardTotals[0]['campanas'] ?>
                  </div>                        
                  <div class="clear"></div>
                </div>
              </li>
              <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                <div class="card_dash sin_margin waves-effect waves-light">                        
                  <div class="row txt_center">
                    <p class="block"><b>Número de deudores</b></p>
                  </div>
                    <div class="lineap"></div>
                  <div class="icon_num">
                    <?php echo $dashboardTotals[0]['num_deudores'] ?>
                  </div>                        
                  <div class="clear"></div>
                </div>
              </li>
              <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                <div class="card_dash sin_margin waves-effect waves-light">                        
                  <div class="row txt_center">
                    <p class="block"><b>Saldo total recuperado</b></p>
                  </div>
                    <div class="lineap"></div>
                  <div class="icon_num">
                    <?php echo '$'.number_format($dashboardTotals[0]['recuperado'], 2) ?>
                  </div>                        
                  <div class="clear"></div>
                </div>
              </li>
              <li class="large-3 medium-3 small-12 columns animated fadeInLeft">                      
                <div class="card_dash sin_margin waves-effect waves-light">                        
                  <div class="row txt_center">
                    <p class="block"><b>Saldo total recuperado</b></p>
                  </div>
                    <div class="lineap"></div>
                  <div class="icon_num"> 0%</div>                        
                  <div class="clear"></div>
                </div>
              </li>                    
            </ul>
          </section>
          <!--Fin Global Dashboard-->
        </section>     

        <section class="all_tareas" style="display: none;">
          <div class="large-6 medium-6 small-12 columns">
            <div class="bg_panel padding animated fadeInUp">
              <table class="striped">
                <thead>                        
                  <tr>
                      <th data-field="id"><b>CAMPAÑAS NO ASIGNADAS</b></th>
                      <th data-field="name">
                        <!-- <a href="agenda" class="all_clic">
                          <i class="fa fa-calendar" aria-hidden="true"></i> Ver todo
                        </a> -->
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($campanasNoAsignadas as $camp): ?>
                    <tr>
                      <td><?php echo $camp['companyName'] ?></td>
                      <td>
                        <div class="formweb">
                          <select onchange="asignmentCoordinatorToCampaign(this, <?php echo $camp['idCampaign'] ?>)" placeholder="Seleccione...">
                            <option value="">Seleccione</option>
                            <?php foreach ($coordinators as $coord): ?>
                              <option value="<?php echo $coord['idAdviser'] ?>">
                                <?php echo $coord['name'] ?>
                              </option>
                            <?php endforeach ?>
                          </select> 
                        </div>
                      </td>
                    </tr>  
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="large-6 medium-6 small-12 columns">
            <div class="bg_panel padding animated fadeInUp">
              <table class="striped">
                <thead>
                  <tr>
                      <th data-field="id"><b>CAMPAÑAS POR CLIENTE</b></th>
                      <th data-field="name">
                        <!-- <a href="agenda" class="all_clic">
                          <i class="fa fa-calendar"></i> Ver todo
                        </a> -->
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($campanasXclientes as $camp): ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>  
                  <?php endforeach ?>
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

<script>
  <?php include realpath('./').'/themes/default/views/admin/main.js' ?>
  <?php include realpath('./').'/themes/default/views/admin/dashboard.js' ?>
</script>