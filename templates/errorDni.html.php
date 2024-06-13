<!-- <php? var_dump($ficharepe); ?> -->

<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">El DNI Nº <?=$ficharepe['dni'];?> ya está notificado </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Nombre: <?=$ficharepe['nombre'].' '.$ficharepe['apellido'] ?></p>
      <p>Edad: <?=$ficharepe['edad'];?> </p> 
      <p>Localidad: <?=$ficharepe['localidad'];?> </p> 
              </div>
 <div class="modal-footer">
        
          <div class="col-sm-3">
                   <a href="/ficha/listar" class="btn btn-primary " role="button">Revise la lista <i class="fa-solid fa-check"></i></a>
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
