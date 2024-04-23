

<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Control de <?=$datosNinio['ApeNom'];?> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Edad: <b><?=$datosNinio['edad'];?></b> </p> 
        <p>Lugar: <b><?= $datosDomi['ResiLocal'];?></b> </p> 
        <p>Fecha: <b><?=date('d/m/Y',strtotime($Control['CtrolFecha']));?></b> </p> 
               <p>Peso: <b><?=$Control['CtrolPeso'];?> kg </b>
            Talla: <b><?=$Control['CtrolTalla'];?> cm</b></p>

            <p> ZPE/E=<span class="badge bg-<?=$Control['alertPE']; ?>"><b>
            <?= number_format($Control['CtrolZp'], 1); ?> </b></span> - 

            ZTA/E=<span class="badge bg-<?=$Control['alertTA']; ?> "><b>
            <?= number_format($Control['CtrolZt'], 1); ?> </b></span> - 

            ZIMC/E= <span class="badge bg-<?=$Control['alertIMC']; ?> " ><b>
            <?= number_format($Control['CtrolZimc'], 1); ?> </b></span></p>
      </div>
  
 <div class="modal-footer">

           <?php if (!$datosInter || $datosInter['IntAlta']=="SI") { ?>
            <div class="col-sm-3">		
            <a href="/interna/inter?Idint=<?= $datosInter['Idint'] ?? '' ?>&id=<?= $datosNinio['IdNinio'] ?? '' ?>&tabla=ingreso" class="btn btn-primary" role="button">Ingreso Internación</a>
             </div>	
             <?php } elseif ($datosInter==true|| $datosInter['IntAlta']=="NO") { ?>
              <div class="col-sm-3">		
            <a href="/interna/inter?Idint=<?= $datosInter['Idint'] ?? '' ?>&id=<?= $datosNinio['IdNinio'] ?? '' ?>&tabla=egreso" class="btn btn-primary" role="button">Alta Internación</a>
           
             </div>
            <?php } ?>
             
             <div class="col-sm-3">		
            <a href="/ninios/home"  class="btn btn-primary " role="button">Guardar</a>
            </div>	
      </div> 
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function() {$('#SucessModal').modal('show');
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
});
</script>
