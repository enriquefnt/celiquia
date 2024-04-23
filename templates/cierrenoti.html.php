<div class="container">
<legend class="w-80 p-0 h-0 ">Cierre Notificacion:
   </legend>
<fieldset class="border p-2">
<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;">  <?=$datosNinio['ApeNom'].' - '.$datosNinio['edad'].' - '. $datosDomi['ResiLocal'] ;?>
   </legend>
<form onkeydown="return event.key != 'Enter';" class="row g-3"  action=""  onsubmit="myButton.disabled = true; return true;" method="post" autocomplete="off" >
		
<input type="hidden"name="Noticon[NotId]" id="NotId" value=<?=$datosNoti['NotId'] ?? ''?> >
	          
<div class="col-sm-2">	
			<label class="form-label-sm" for="NotFechaFin">Fecha</label>
			<input class="form-control form-control-sm" type="date" max="<?=date('Y-m-d');?>" min="<?=$fechaMinima;?>"
			name="Noticon[NotFechaFin]" id="NotFechaFin" required="required" >
</div>

<div class="col-sm-4">
	<label class="form-label-sm" for="NotAlta">Motivo</label>
	<select name="Noticon[NotAlta]" id="NotAlta" class="form-control form-control-sm">
		<option hidden selected><?=$datosNoti['NotAlta'] ?? '...'?></option>
		<option value='Recuperado'>Recuperado</option>
		<option value='Con secuela'>Con secuela</option>
		<option value='Médico'>Médico</option>
		<option value='Emigra'>Emigra</option>
		<option value='Obito domiciliario'>Obito domiciliario</option>
		<option value='Obito internado'>Obito internado</option>
		<option value='Obito' en transito>Obito en transito</option>
		<option value='Pérdida de seguimiento.'>Pérdida de seguimiento.</option>
				</select>
	</div>
    <div class="form-group">
			<label class="form-label-sm" for="NotObservafin">Observaciones</label>
			 <textarea class="form-control" rows="3" id="NotObservafin" name="Noticon[NotObservafin]"
			 value="<?=$datosNoti['NotObservafin'] ?? ''?>">
			</textarea>
</div> 
<div class="col-sm-3">
    <a href="/ninios/home"  class="btn btn-primary btn-sm" role="button">Salir sin cambiar</a>
    <input type="submit" id="myButton"  name=submit class="btn btn-primary btn-sm" value="Guardar">
</div>
	</fieldset>
 </form>
</div>