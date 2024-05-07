<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Cierre de notificación: <?=$datosNinio['ApeNom'];?> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Edad: <b><?=$datosNinio['edad'];?></b></p> 
        <p>Lugar: <b><?= $datosDomi['ResiLocal'];?></b> </p> 
        <p>Fecha de notificación: <b><?=  date('d/m/Y', strtotime($Notificacion['NotFecha'])); ?></b></p>
        <p>Fecha del último control: <b><?= isset($Control['CtrolFecha']) && $Control['CtrolFecha'] > $Notificacion['NotFecha'] ? date('d/m/Y', strtotime($Control['CtrolFecha'])) 
        : 'No se cargaron controles'; ?></b></p>
        <p>Motivo: <b><?= $Notificacion['NotAlta']?></b></p>
           <p>Peso: <b><?=isset($Control['CtrolFecha']) ?$Control['CtrolPeso']:$Notificacion['NotPeso'];?> kg </b>
            Talla: <b><?=isset($Control['CtrolFecha']) ?$Control['CtrolTalla']:$Notificacion['NotTalla'];?> cm</b></p>

            <p> ZPE/E=<span style="color:<?=isset($Control['CtrolFecha']) ? $Control['colorPE']: $Notificacion['colorPE']; ?>">
            <?= isset($Control['CtrolFecha']) ? number_format($Control['CtrolZp'], 1):number_format($Notificacion['NotZpe'], 1); ?> </span> - 


            ZTA/E=<span style="color:<?=isset($Control['CtrolFecha']) ?$Control['colorTA']:$Notificacion['colorPE']; ?>">
            <?=isset($Control['CtrolFecha']) ? number_format($Control['CtrolZt'], 1):number_format($Notificacion['NotZta'], 1); ?> </span> - 

            ZIMC/E= <span style="color:<?=isset($Control['CtrolFecha']) ?$Control['colorIMC']:$Notificacion['colorPE']; ?>">
            <?= isset($Control['CtrolFecha']) ? number_format($Control['CtrolZimc'], 1):number_format($Notificacion['NotZimc'], 1); ?> </span></p>
</div>
     
 <div class="modal-footer">
           
           
            <a href="/login/home"  class="btn btn-primary btn-sm" role="button">Salir</a>
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