<?php 
    $zScoreP = $antro->calcularZScore(2,'p',15,'2020-01-01','2022-01-01');
    echo "El ZScore calculado es: " . $zScoreP;

    $zScoreT = $antro->calcularZScore(2,'t',70,'2020-01-01','2022-01-01');
    echo "El ZScore calculado es: " . $zScoreT;

?>
<div class="container">
<fieldset class="border p-2">
 <legend class="w-80 p-0 h-0 ">Notificación:
   </legend>
<form onkeydown="return event.key != 'Enter';" class="row g-3"  action=""  onsubmit="myButton.disabled = true; return true;" method="post" autocomplete="off" >
		
<input type="hidden"name="Antro[idAnt]" id="idAnt" value=<?=$datosNinio['idAnt'] ?? ''?> >
	<input type="hidden" name="Antro[idNoti]"  id="idNoti"   value=<?=$datosNinio['idNoti'] ?? ''?>>
	

    <div class="col-sm-4">
 <label class="form-label-sm" for="nombre">Nombre</label>
 <input class="form-control form-control-sm" type="text" name="Antro[nombre]" id="nombre" required="required" value="<?=$datosNinio['nombre'] ?? ''?>">
</div>
    <div class="col-sm-2">	
			<label class="form-label-sm" for="fecha_nace">Fecha de Nacimiento</label>
			<input class="form-control form-control-sm" type="date" name="Antro[fecha_nace]" id="fecha_nace" required="required" min="2017-01-01"  max="<?=date('Y-m-d');?>"  value="<?=$datosNinio['fecha_nace'] ?? ''?>">
</div>

<div class="col-sm-2">
  <label class="form-label-sm" for="sexo">sexo</label>
  <select name="Antro[sexo]" id="sexo" class="form-control form-control-sm">
  	<option hidden selected><?=$datosNinio['sexo'] ?? '...'?></option>
  <!--  <option value='1'>Administrador</option> -->
    <option value='Femenino'>Femenino</option>
    <option value='Masculino'>Masculino</option>
    <option value='No determinado'>No determinado</option>
        </select>
 </div>
<div class="col-sm-2">	
			<label class="form-label-sm" for="fecha_control">Fecha</label>
			<input class="form-control form-control-sm fecha_control" type="date" name="Antro[fecha_control]" id="fecha_control" 
            required="required" value="<?=$datosNinio['fecha_control'] ?? ''?>">
</div>
<div class="col-sm-2">    
    <label class="form-label-sm" for="peso">Peso (kg)</label>
    <input class="form-control form-control-sm peso-input" type="number"  step="0.1" min="1" max="60" name="Antro[peso]"
         id="peso" required="required" value="<?=$datosNinio['peso'] ?? ''?>">
</div>
<div class="col-sm-2">    
    <label class="form-label-sm" for="talla">Talla (cm)</label>
    <input class="form-control form-control-sm talla-input" type="number" step="0.1" min="30" max="150" name="Antro[talla]"
         id="talla" required="required" value="<?=$datosNinio['talla'] ?? ''?>">
</div>
<div class="col-sm-2">    
    <label class="form-label-sm" for="ZPE">Z P/E</label>
    <input class="form-control form-control-sm zpe-result" type="number" name="Antro[ZPE]"
         id="ZPE" readonly>
</div>
<div class="col-sm-2">    
    <label class="form-label-sm" for="ZTE">Z T/E</label>
    <input class="form-control form-control-sm zte-result" type="number" name="Antro[ZTE]"
         id="ZTE" readonly>
</div>
<div class="col-sm-2">    
    <label class="form-label-sm" for="ZIMCE">Z IMC/E</label>
    <input class="form-control form-control-sm zimce-result" type="number" name="Antro[ZIMCE]"
         id="ZIMCE" readonly>
</div>

<div class="col-sm-12">
    <button class="btn btn-primary" type="submit" id="myButton" name="myButton" value="submit">Guardar</button>
 </div>
 </form>
 </fieldset>
 </div>

 <!-- Bloque para definir la variable global 'antro' -->



<script>
var antroData = <?= json_encode(['antro' => $antro]); ?>;
console.log(antroData);
var calcularZScore = antroData.antro.calcularZScore;
console.log(calcularZScore);
$(document).ready(function () {
  // Handle the change in the weight field
  $('.peso-input, .talla-input').on('input', function () {
    actualizarResultados();
  });

  function actualizarResultados() {
    // Extract relevant data from the form
    var peso = parseFloat($('#peso').val()) || 0;
    var talla = parseFloat($('#talla').val()) || 0;
    var sexo = $('#sexo').val() === "Femenino" ? 2 : 1;
    var fecha_nace = $('#fecha_nace').val();
    var fecha_control = $('#fecha_control').val();

    // Calculate Z scores using the retrieved function
    $('#ZPE').val(calcularZScore(sexo, 'p', peso, fecha_nace, fecha_control));
    $('#ZTE').val(calcularZScore(sexo, 't', talla, fecha_nace, fecha_control));
    $('#ZIMCE').val(calcularZScore(sexo, 'i', peso / (talla / 100 * talla / 100), fecha_nace, fecha_control));
  }
});

</script>