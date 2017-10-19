<section class="cont_home">       
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      
      <section class="panelBG m_b_20 lista_all_deudor">
        <table class="bordered highlight responsive-table">
          <thead>
            <tr>
              <th>Campaña</th>
              <th>Cliente</th>
              <th>Saldo total</th>
              <th>Número deudores</th>
              <th>Asesor</th>
              <th>Tipo de servicio</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($clientesAsignados as $client): ?>
              <tr>
                <td> <?php echo $client['name'] ?> </td>
                <td> <?php echo $client['companyName'] ?> </td>
                <td> <?php echo '$'.number_format($client['saldo'], 2) ?> </td>
                <td class="txt_center"> <?php echo $client['num_deudores'] ?> </td>
                <td> <?php echo 'Falta' ?> </td>
                <td> <?php echo 'Falta' ?> </td>
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