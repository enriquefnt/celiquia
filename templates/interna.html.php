

<div class="container">
   <legend class="w-80 p-0 h-0 ">
    <p>Ficha de internación 
    </p>
</legend>
<fieldset class="border p-2">
<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;">  <?=$datosNinio['ApeNom'].' - '. $datosNinio['edad'] ;?>
   </legend>

<form onkeydown="return event.key != 'Enter';" class="row g-3" action=""   id="interFormulario" method="post" autocomplete="off" >

<input type="hidden"name="NOTIINTERNADOS[Idint]" id="Idint" value=<?=$datosInter['Idint'] ?? ''?> >
<input type="hidden" name="NOTIINTERNADOS[IdNotifica]"  id="IdNotifica"   value=<?=$Notificacion['NotId'] ?? ''?>>
<input type="hidden" name="NOTIINTERNADOS[IdNinio]"  id="IdNinio"   value=<?=$datosNinio['IdNinio'];?>>	          

<?php
 if ($_GET['tabla']=='egreso'){ ?> 
<input type="hidden"name="NOTIINTERNADOS[IntFecha]" id="Idint" value=<?=$datosInter['IntFecha'] ?? ''?> >
<input type="hidden" name="NOTIINTERNADOS[IntAo]"  id="IdNotifica"   value=<?=$datosInter['IntAo'] ?? ''?>>
<input type="hidden" name="NOTIINTERNADOS[IntEfec]"  id="IntEfec"   value=<?=$datosInter['IntEfec'];?>>	  
<input type="hidden" name="NOTIINTERNADOS[IntSala]"  id="IntSala"   value=<?=$datosInter['IntSala'];?>>	
<!-- <input type="hidden" name="NOTIINTERNADOS[IntObserva]"  id="IntObserva"   value=<?=$datosInter['IntObserva'];?>>	     -->
 <?php } ?>


<?php
 if ($_GET['tabla']=='ingreso'){ ?>
<div class="col-sm-2">	
			<label class="form-label-sm" for="IntFecha">Fecha Ingreso</label>
			<input class="form-control form-control-sm" type="date" name="NOTIINTERNADOS[IntFecha]" id="IntFecha" 
            min="<?= $fechaMinima; ?>" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['IntFecha'] ?? ''?>">
</div>

<div class="col-sm-3">	
			<label class="form-label-sm" for="Nombre_aop">Efector</label>
			<input class="form-control form-control-sm" type="text" name="NOTIINTERNADOS[Nombre_aop]" id="Nombre_aop" required="required" value="<?=$datosInter['Nombre_aop'] ?? ''?>">
			<input type="hidden" name="NOTIINTERNADOS[IntEfec]" id="IntEfec" value="<?= $data['value'] ?? $datosInter['IntEfec'] ?? '' ?>" />
</div>


<div class="col-sm-2">
  <label class="form-label-sm" for="IntSala">Sala</label>
  <select name="NOTIINTERNADOS[IntSala]" id="IntSala" class="form-control form-control-sm">
  	<option hidden selected><?=$datosInter['IntSala'] ?? '...'?></option>
    	
	<option value=2>Guardia</option>
	<option value=3>Terapia intensiva</option>
	<option value=9>Internación comun</option>
	<option value=10>CRENI</option>
    <option value=4>Recuperacion nutricional</option>
	</select>
 </div>

 

<div class="col-sm-4">
    <label class="form-label-sm" for="diagnosticos">Motivos de ingreso</label>
    <input type="text" id="diagnosticos" class="form-control form-control-sm" placeholder="Ingrese un motivo de ingreso" /><br>
    <input type="button" value="Agregar motivo" id="agregar-diagnostico" class="btn btn-primary" />
    <ul id="lista-diagnosticos"></ul>
    <input type="hidden" name="NOTIINTERNADOS[diagnosticos][]" id="hidden-diagnosticos" value="" />
</div>

  <div class="col-sm-4">
  <ul id="lista-diagnosticos"></ul> 
  </div> 
 <?php } else { ?>
  
 
 <div class="col-sm-2">	
			<label class="form-label-sm" for="IntFechalta">Fecha Egreso</label>
			<input class="form-control form-control-sm" type="date" name="NOTIINTERNADOS[IntFechalta]" id="IntFechalta" 
            min="<?= $fechaMinima; ?>" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['IntFechalta'] ?? ''?>">
</div>

<div class="col-sm-3">
  <label class="form-label-sm" for="IntTipoAlta">Tipo</label>
  <select name="NOTIINTERNADOS[IntTipoAlta]" id="IntTipoAlta" class="form-control form-control-sm">
  	<option hidden selected><?=$datosInter['IntTipoAlta'] ?? '...'?></option>
    	
	<option value=1>Médica</option>
	<option value=2>Derivación</option>
	<option value=3>Voluntaria</option>
	<option value=4>Defuncion</option>
    <option value=5>Migracion</option>
	</select>
 </div>

 <div class="col-sm-4">
    <label class="form-label-sm" for="diag_egr">Diagnósticos de egreso</label>
    <input type="text" id="diag_egr" class="form-control form-control-sm" placeholder="Ingrese diagnóstico" /><br>
    <input type="button" value="Agregar diagnóstico" id="agregar-diag_egr" class="btn btn-primary" />
    <ul id="lista-diagnosticos"></ul>
    <input type="hidden" name="NOTIINTERNADOS[diag_egr][]" id="hidden-diag_egr" value="" />
</div>

  <div class="col-sm-4">
  <ul id="lista-diag_egr"></ul> 
  </div> 

 <?php } ?>
<div class="form-group">
			<label class="form-label-sm" for="IntObserva">Observaciones</label>
			 <textarea class="form-control" rows="3" id="IntObserva" name="NOTIINTERNADOS[IntObserva]"
			 value="<?=$datosInter['IntObserva'] ?? ''?>">
			</textarea>
         </div>
	</fieldset>

<fieldset class="border p-2">   
<div class="d-flex">  
        <div class="col-sm-3">		
            <a href="/ninios/home"  class="btn btn-primary " role="button">Salir sin cambiar</a>
        </div>
        <div class="col-sm-3">	
            <input type="submit" id="myButton"  name=submit class="btn btn-primary " value="Guardar">
        </div>
   </div>      
	</fieldset>
 </form>
</div>


<script>
var options = {
 data: <?php echo json_encode($data_insti); ?>,
 maximumItems: 10,
 highlightTyped: true,
 highlightClass: 'fw-bold text-primary',
 onSelectItem: function(selectedItem) {
    document.getElementById('IntEfec').value = parseInt(selectedItem.value); // Asignar el valor del item seleccionado al input hidden
}
};

var auto_complete = new Autocom(document.getElementById('Nombre_aop'), options);
</script>

<script>
var NOTIINTERNADOS = {
    diagnosticos: []
};
</script>

<script>
$(document).ready(function() {
  
    $("#agregar-diagnostico").click(function() {
        var diagnosticos = $("#diagnosticos").val();
        NOTIINTERNADOS.diagnosticos.push(diagnosticos);
        $("#lista-diagnosticos").append("<li>" + diagnosticos + "</li>");
        $("#diagnosticos").val("");

        $("#hidden-diagnosticos").val(NOTIINTERNADOS.diagnosticos.join(','));
    });
});
</script>
<script>
$(document).ready(function() {
    var NOTIINTERNADOS = {diag_egr: [] };
    $("#agregar-diag_egr").click(function() {
        var diag_egr = $("#diag_egr").val();
        NOTIINTERNADOS.diag_egr.push(diag_egr);
        $("#lista-diag_egr").append("<li>" + diag_egr + "</li>");
        $("#diag_egr").val("");

        $("#hidden-diag_egr").val(NOTIINTERNADOS.diag_egr.join(','));
    });
});
</script>


