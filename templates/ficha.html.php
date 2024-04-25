 <div class="container"> 
   <legend class="w-80 p-0 h-0 ">
    <p>Ficha de investigación de enfermedad celíaca.
    </p>
</legend>
<fieldset class="border p-2">
<form onkeydown="return event.key != 'Enter';" class="row g-3" action="" id="interFormulario" method="post" autocomplete="off" >

<input type="hidden" name="ficha[idficha]" id="Idint" value=<?=$datosInter['Idint'] ?? ''?> >

<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;">  Declarante
   </legend>    
<div class="col-sm-3">	
			<label class="form-label-sm" for="fechanot">Fecha </label>
			<input class="form-control form-control-sm" type="date" name="ficha[fechanot]" id="fechanot" 
            min="2024-01-01" max="<?=date('Y-m-d');?>" required="required" value="<?=date('Y-m-d');?>">
</div>

<div class="col-sm-9">	
			<label class="form-label-sm" for="institucion">Efector</label>
			<input class="form-control form-control-sm" type="text" name="ficha[institucion]" id="institucion" required="required" value="<?=$datosInter['institucion'] ?? ''?>">
			<!-- <input type="hidden" name="ficha[IntEfec]" id="IntEfec" value="<?= $data['value'] ?? $datosInter['IntEfec'] ?? '' ?>" /> -->
</div>
<!-- </fieldset>

<fieldset class="border p-1"> -->
<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;"> Paciente
   </legend>

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
            min="1920-01-01" max="<?=date('Y-m-d');?>" onchange="calcularEdad()" required="required" value="<?=$datosInter['fechanac'] ?? ''?>">
</div>

<div class="col-sm-2">
<label>Edad:</label>
        <span id="resultado"></span>
</div>

<div class="col-sm-8">	
			<label class="form-label-sm" for="domicilio">Domicilio</label>
			<input class="form-control form-control-sm" type="text" name="ficha[domicilio]" id="domicilio" required="required" value="<?=$datosInter['domicilio'] ?? ''?>">
			</div>    
 
   <div class="col-sm-4">
  <label class="form-label-sm" for="ResiLocal">Localidad</label>
  <input type="text" name="ficha[ResiLocal]" id="ResiLocal" class="form-control form-control-sm" autocomplete="off"  value="<?=$datosDomi['ResiLocal'] ?? ''?>" >
   
  <input type="hidden" name="ficha[IdResi]" value="<?=$datosDomi['IdResi'] ?? ''?>">
   <input type="hidden" name="ficha[Gid]" id="Gid" value="<?= $data['value'] ?? $datosDomi['gid'] ?? '' ?>" />
   
</div>
<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;"> Diagnóstico
   </legend>

   <div class="col-sm-2">	
			<label class="form-label-sm" for="fechadiag">Fecha de Diagnóstico</label>
			<input class="form-control form-control-sm" type="date" name="ficha[fechadiag]" id="fechadiag" 
            min="1920-01-01" max="<?=date('Y-m-d');?>" required="required" value="<?=$datosInter['fechadiag'] ?? ''?>">
</div>    

<div class="col-sm-2">
<label>Edad diagnóstico:</label>
        <span id="resultado"></span>
</div>
 <div class="col-sm-2">
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1">
    <label class="form-check-label" for="inlineCheckbox1">Biopsia</label>
    </div>
   </div>  
   <div class="col-sm-2">
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="2">
  <label class="form-check-label" for="inlineCheckbox2">Endoscopia</label>
</div>
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
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('fecha').addEventListener('change', function() {
                calcularEdad();
            });
        });

        function calcularEdad() {
            var fechaNacimiento = document.getElementById('fechanac').value;
            var fechaControl = document.getElementById('fechanot').value;

            // Convertir fechas a objetos Date
            var nacimiento = new Date(fechaNacimiento);
            var control = new Date(fechaControl);

            // Calcular diferencia de tiempo en milisegundos
            var diffTiempo = control.getTime() - nacimiento.getTime();

            // Calcular diferencia de años
            var edad = new Date(diffTiempo);
            var anios = Math.abs(edad.getUTCFullYear() - 1970);
            var meses = edad.getUTCMonth();
            var dias = edad.getUTCDate() - 1; // Restar 1 día para evitar la diferencia por timezone

            // Mostrar la edad en el formulario
            var resultado = document.getElementById('resultado');
            if (anios > 0) {
                resultado.textContent = anios + " años " + meses + " meses";
            } else {
                resultado.textContent = meses + " meses " + dias + " días";
            }
        }
    </script>
   
   
   <script>
var auto_complete = new Autocom(document.getElementById('ResiLocal'), {
	data: <?php echo json_encode($data); ?>,
	maximumItems: 10,
	highlightTyped: true,
	highlightClass: 'fw-bold text-primary',
	onSelectItem: function(selectedItem) {
		document.getElementById('Gid').value = selectedItem.value; // Asignar el valor del item seleccionado al input hidden
	//document.getElementById('idNinio').value = selectedItem.value; 
  }
});
