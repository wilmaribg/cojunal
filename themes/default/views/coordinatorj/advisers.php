<section class="cont_home">       
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      
      <section class="panelBG m_b_20 lista_all_deudor">
        <table class="bordered highlight responsive-table">
          <thead>
            <tr>
              <th class="txt_center">Asesor</th>
              <th class="txt_center">Número de campañas</th>
              <th class="txt_center">Fecha de asignación</th>
              <th class="txt_center">Total asignado</th>
              <th class="txt_center">Total recuperado</th>
              <th class="txt_center">% de recuperación</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($asesores as $adviser): ?>
              <tr>
                <td> <?php echo $adviser['name'] ?> </td>
                <td class="txt_center"> <?php echo $adviser['num_campana'] ?> </td>
                <td> <?php // echo date('d-m-Y', strtotime($client['fCreacion'])) ?> </td>
                <td class="txt_right"> <?php echo '$'.number_format($adviser['total'], 2) ?> </td>
                <td class="txt_right"> <?php // echo '$'.number_format($adviser['total'], 2) ?> </td>
                <td class="txt_right"> <?php // echo '$'.number_format($adviser['total'], 2) ?> </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>

        <br><br>
        
        <div class="padding">
          <?php //include realpath('./') . '/themes/default/views/admin/utilities.php'; ?>
          <?php //$currentPage = (isset($_GET['page']) ? $_GET['page'] : 1) ?>
          <?php //echo pagination($totalRecords, 10, $currentPage, 'http://cojunal.com/plataforma/beta/admin/clientes?page=%s') ?>
        </div>

      </section>

    </section>
  </section>
</section>


  

<script>
  <?php // include realpath('./').'/themes/default/views/admin/usuarios/listado_coordinadores.js' ?>
</script>