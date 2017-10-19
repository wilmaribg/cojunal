<?php ob_start();?>

    
<table>
<tr>
    <td><img src="/plataforma/beta/assets/img/logo.png" alt="" style="max-width:100%"></td>
    <td><p style="font-size:1.2em">COJUNAL<br>COBRANZAS JURIDICAS NACIONALES</p></td>
    <td>Remision #: <?php echo $DataRemisiones[0]['id'] ?></td>
</tr>
</table>




<div class="container">
       

    <br><br>
        <div class="row" >
            <div class="row voffset4" >
                <p style="font-size:1em">Remision corresponde a la prestación de servicios de cobranza<br><hr></p>
                <table width="100%">
                <tr>
                    <td>Cliente: <?php echo $DataRemisiones[0]['name'] ?></td>
                    <td>Nit: <?php echo $DataRemisiones[0]['idNumber'] ?></td>
                    <td>Periodo: <?php echo $DataRemisiones[0]['idNumber'] ?></td>
                </tr>
                </table>
            </div>

            <div class="row voffset4">
            <table width="100%">
                <tr>
                    <td>Campaña: <?php echo $DataRemisiones[0]['campaignName'] ?></td>
                    <td>Fecha: <?php echo $DataRemisiones[0]['fecha'] ?></td>                  
                </tr>
                </table>           
            </div>


        <div class="row voffset4">
            <p style="font-size:1em">Esta campaña se desarrollo bajo la siguiente negociación<br><hr></p>
            <table width="100%">
                <tr>
                    <td>Honorarios: <?php echo $DataRemisiones[0]['honorarios'] ?></td>
                    <td>Intereses: <?php echo $DataRemisiones[0]['intereses'] ?></td>        
                    <td>Comision de recaudo: <?php echo $DataRemisiones[0]['comision'] ?></td>                  
                </tr>
                <tr>
                    <td>% de recuperación: <?php echo $DataRemisiones[0]['honorarios'] ?></td>
                    <td>Valor inicial: <?php echo $DataRemisiones[0]['intereses'] ?></td>        
                    <td>Saldo pendiente por recaudar : <?php echo $DataRemisiones[0]['comision'] ?></td>                  
                </tr>
                </table> 
        </div>
        <br><br>

        <div class="row voffset8">
        <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-1"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-1"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>

                <table width="100%">
                <tr>
                    <th>#</th>
                    <th>Nombre del deudor</th>
                    <th>Saldo adeudado</th>        
                    <th>Honorarios cobrados</th>   
                    <th>% comision</th>   
                    <th>Valor total recaudado</th> 
                    <th>Valor total cojunal</th>  
                </tr>
                <?php $cont = 1;  foreach($Walletslist as $list_info_re){?>
                <tr>
                    <td><?php echo $cont; ?></td>
                    <td align="left"><p style="font-size:0.8em;"><?php echo $list_info_re['legalName'] ?></p></td>
                    <td align="center">$<?php echo number_format($list_info_re['intereses'] *  $list_info_re['monto'])?></td>        
                    <td align="center"><p style="font-size:0.8em;"><?php echo number_format($list_info_re['honorarios']) ?></p></td>   
                    <td align="center"><p style="font-size:0.8em;"><?php echo number_format($list_info_re['comision']) ?>%</p></td>   
                    <td align="center">$<?php echo number_format($list_info_re['recaudo']) ?></td> 
                    <td align="center">$<?php echo number_format( ($list_info_re['recaudo'] * $list_info_re['comision']) / 100 ) ?></td>  
                </tr>
                <?php $cont++; }?>
                </table> 

            </div> 
           
        </div>
    <br><br>
<hr>
    <div class="container-fluid text-center voffset9">
        <div class="row content">
            <p>El valor total recaudado fue de  el valor correspondiente para COJUNAL por la prestacion del servicio es de </p>


        </div>
    </div>

    <footer class="container-fluid text-center">
        <p>Consideraciones legales y firmas de cojunal</p>
    </footer>

        </div>


        </div>    
        
            </body>
            </html>
<?php
 $content = ob_get_clean();

 $mpdf = new \mPDF();
 //$stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css');
 //$mpdf->WriteHTML($stylesheet,1);
 $mpdf->WriteHTML($content,2);
 $mpdf->Output();
?>

       


   
