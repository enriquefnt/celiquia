
<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Se notifico a <?=$datosNinio['ApeNom'];?> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Edad: <?=$datosNinio['edad'];?> </p> 
        <p>Lugar: <?='Localidad: '. $datosDomi['ResiLocal'];?> </p> 
        <p>Peso: <?=$Notificacion['NotPeso'];?> kg 
            Talla: <?=$Notificacion['NotTalla'];?> cm</p>

            <p> ZPE/E=<span class="badge bg-<?=$Notificacion['alertPE']; ?>" ><b>
            <?= number_format($Notificacion['NotZpe'], 1); ?> </b></span> - 

            ZTA/E=<span class="badge bg-<?=$Notificacion['alertTA']; ?> " ><b>
            <?= number_format($Notificacion['NotZta'], 1); ?> </b></span> - 

            ZIMC/E= <span class="badge bg-<?=$Notificacion['alertIMC']; ?> " ><b>
            <?= number_format($Notificacion['NotZimc'], 1); ?> </b></span></p>

      </div>
 <div class="modal-footer">
           
 
          <div class="col-sm-3">
            <a href="/interna/inter?id=<?= $datosNinio['IdNinio'] ?? '' ?>&idNoti=<?=$notificacion['IdNotifica'] ?? '' ?>&tabla=ingreso" class="btn btn-primary" role="button">Internación</a>
            </div>	
            <div class="col-sm-3">		
            <a href="/ninios/home"  class="btn btn-primary " role="button">Salir</a>
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
