<div class="container">
   <legend class="w-80 p-0 h-0 ">
    <p>Ficha de investigación de enfermedad celíaca.
    </p>
</legend>
<fieldset class="border p-2">
<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;">  Nombre del caso
   </legend>

<form onkeydown="return event.key != 'Enter';" class="row g-3" action=""   id="interFormulario" method="post" autocomplete="off" >

<input type="hidden" name="ficha[idficha]" id="Idint" value=<?=$datosInter['Idint'] ?? ''?> >
        

<div class="col-sm-2">	
			<label class="form-label-sm" for="fechanot">Fecha Ingreso</label>
			<input class="form-control form-control-sm" type="date" name="ficha[fechanot]" id="fechanot" 
            min="<?= $fechaMinima; ?>" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['fechanot'] ?? ''?>">
</div>

<div class="col-sm-3">	
			<label class="form-label-sm" for="institucion">Efector</label>
			<input class="form-control form-control-sm" type="text" name="ficha[institucion]" id="institucion" required="required" value="<?=$datosInter['institucion'] ?? ''?>">
			<!-- <input type="hidden" name="ficha[IntEfec]" id="IntEfec" value="<?= $data['value'] ?? $datosInter['IntEfec'] ?? '' ?>" /> -->
</div>
<div class="col-sm-3">	
			<label class="form-label-sm" for="nombre">Nombre</label>
			<input class="form-control form-control-sm" type="text" name="ficha[nombre]" id="nombre" required="required" value="<?=$datosInter['nombre'] ?? ''?>">
			</div>
 <div class="col-sm-3">	
			<label class="form-label-sm" for="apellido">Apellido</label>
			<input class="form-control form-control-sm" type="text" name="ficha[apellido]" id="apellido" required="required" value="<?=$datosInter['apellido'] ?? ''?>">
			</div>           
            

<div class="col-sm-2">
  <label class="form-label-sm" for="sexo">Sexo</label>
  <select name="ficha[sexo]" id="sexo" class="form-control form-control-sm">
  	<option hidden selected><?=$datosInter['sexo'] ?? '...'?></option>
    <option value=2>Femenino</option>
	<option value=1>Masculino</option>
	<option value=9>No determinado</option>
	</select>
 </div>
<div class="col-sm-2">	
			<label class="form-label-sm" for="fechanac">Fecha de Nacimiento</label>
			<input class="form-control form-control-sm" type="date" name="ficha[fechanac]" id="fechanac" 
            min="<?= $fechaMinima; ?>" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['fechanac'] ?? ''?>">
</div>
<div class="col-sm-2">	
			<label class="form-label-sm" for="fechanac">Edad</label>
			<input class="form-control form-control-sm" type="number" name="ficha[edad]" id="edad" 
             value="<?=$datosInter['fechanac'] ?? ''?>">
</div>

<div class="col-sm-3">	
			<label class="form-label-sm" for="domicilio">Domicilio</label>
			<input class="form-control form-control-sm" type="text" name="ficha[domicilio]" id="domicilio" required="required" value="<?=$datosInter['domicilio'] ?? ''?>">
			</div>    
 

<div class="col-sm-4">
    <label class="form-label-sm" for="diagnosticos">Motivos de ingreso</label>
    <input type="text" id="diagnosticos" class="form-control form-control-sm" placeholder="Ingrese un motivo de ingreso" /><br>
    <input type="button" value="Agregar motivo" id="agregar-diagnostico" class="btn btn-primary" />
    <ul id="lista-diagnosticos"></ul>
    <input type="hidden" name="ficha[diagnosticos][]" id="hidden-diagnosticos" value="" />
</div>

  <div class="col-sm-4">
  <ul id="lista-diagnosticos"></ul> 
  </div> 
 
  
 
 <div class="col-sm-2">	
			<label class="form-label-sm" for="IntFechalta">Fecha Egreso</label>
			<input class="form-control form-control-sm" type="date" name="ficha[IntFechalta]" id="IntFechalta" 
            min="<?= $fechaMinima; ?>" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['IntFechalta'] ?? ''?>">
</div>

<div class="col-sm-3">
  <label class="form-label-sm" for="IntTipoAlta">Tipo</label>
  <select name="ficha[IntTipoAlta]" id="IntTipoAlta" class="form-control form-control-sm">
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
    <input type="hidden" name="ficha[diag_egr][]" id="hidden-diag_egr" value="" />
</div>

  <div class="col-sm-4">
  <ul id="lista-diag_egr"></ul> 
  </div> 

 
<div class="form-group">
			<label class="form-label-sm" for="IntObserva">Observaciones</label>
			 <textarea class="form-control" rows="3" id="IntObserva" name="ficha[IntObserva]"
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


