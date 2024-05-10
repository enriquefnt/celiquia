<div class="container">
    <legend class="w-80 p-0 h-0 ">
        <p>Ficha de registro de enfermedad celíaca.
        </p>
    </legend>
    <fieldset class="border p-2">
        <form onkeydown="return event.key != 'Enter';" class="row g-3" action="" id="interFormulario" method="post" autocomplete="off">

            <input type="hidden" name="ficha[idficha]" id="idficha" value=<?= $datosInter['idficha'] ?? '' ?>>

            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Declarante
            </legend>
            <div class="col-sm-2">
                <label class="form-label-sm" for="fechanot">Fecha <span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="date" name="ficha[fechanot]" id="fechanot" min="2000-01-01" max="<?= date('Y-m-d'); ?>" required="required" value="<?= date('Y-m-d'); ?>">
            </div>

            <div class="col-sm-3">
                <label for="semana" class="form-label-sm">Semana Epidemiológica:</label>
                <span id="semana" class="form-control form-control-sm"></span>
            </div>

            <div class="col-sm-7">
                <label class="form-label-sm" for="institucion">Efector<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="text" name="ficha[institucion]" id="institucion" required="required" value="<?= $datosInter['institucion'] ?? '' ?>">

            </div>

            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Paciente
            </legend>

            <div class="col-sm-2">
                <label class="form-label-sm" for="nombre">Nombre<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="text" name="ficha[nombre]" id="nombre" required="required" value="<?= $datosInter['nombre'] ?? '' ?>">
            </div>
            <div class="col-sm-2">
                <label class="form-label-sm" for="apellido">Apellido<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="text" name="ficha[apellido]" id="apellido" required="required" value="<?= $datosInter['apellido'] ?? '' ?>">
            </div>

            <div class="col-sm-2">
                <label class="form-label-sm" for="sexo">Sexo<span class="text-danger">*</label>
                <select name="ficha[sexo]" id="sexo" class="form-control form-control-sm">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value=2>Femenino</option>
                    <option value=1>Masculino</option>
                    <option value=9>No determinado</option>
                </select>
            </div>

            <div class="col-sm-2">
                <label class="form-label-sm" for="dni">DNI<span class="text-danger">*</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" type="number" name="ficha[dni]" id="dni" min="0" max="99999999">
                    <span class="input-group-text">
                        <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Indique el número de documento sin puntos. En caso de ser idocumentado coloque 0 "></i>
                    </span>
                </div>
            </div>

            <div class="col-sm-2">
                <label class="form-label-sm" for="fechanac">Fecha de Nacimiento<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="date" name="ficha[fechanac]" id="fechanac" min="1920-01-01" max="<?= date('Y-m-d'); ?>" onchange="calcularEdad()" required="required" value="<?= $datosInter['fechanac'] ?? '' ?>">
            </div>

            <div class="col-sm-2">
                <label for="edad" class="form-label-sm">Edad:</label>
                <span id="resultado" class="form-control form-control-sm"></span>
            </div>


            <div class="col-sm-2">
                <label class="form-label-sm" for="historiaClinica">Nº de Historia Clínica</label>
                <input class="form-control form-control-sm" type="number" name="ficha[historiaClinica]" id="historiaClinica" value="<?= $datosInter['historiaClinica'] ?? '' ?>">
            </div>


            <div class="col-sm-6">
                <label class="form-label-sm" for="domicilio">Domicilio<span class="text-danger">*</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" type="text" name="ficha[domicilio]" id="domicilio" required="required" value="<?= $datosInter['domicilio'] ?? '' ?>">
                    <span class="input-group-text">
                        <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Indique 
                        calle-número-piso- n° de departamento-barrio, en caso de viviendas rurales indique la localidad o paraje mas 
                        cercano y describa brevemente la ubicación. 
                        En caso de domicilio extraprovincial indique provincia o país en este campo y en el campo LOCALIDAD seleccione OTRO PAIS u OTRA PROVINCIA"></i>
                    </span>
                </div>
            </div>

            <div class="col-sm-4">
                <label class="form-label-sm" for="localidad">Localidad<span class="text-danger">*</label>
                <input type="text" name="ficha[localidad]" id="localidad" class="form-control form-control-sm" autocomplete="off" value="<?= $datosDomi['localidad'] ?? '' ?>">

                <!-- <input type="hidden" name="ficha[IdResi]" value="<?= $datosDomi['IdResi'] ?? '' ?>"> -->
                <input type="hidden" name="ficha[Gid]" id="gid" value="<?= $data['value'] ?? $datosDomi['gid'] ?? '' ?>" />

            </div>

            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Diagnóstico
            </legend>

            <div class="col-sm-2">
                <label class="form-label-sm" for="fechadiag">Fecha de Diagnóstico<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="date" name="ficha[fechadiag]" id="fechadiag" min="1920-01-01" max="<?= date('Y-m-d'); ?>" required="required" value="<?= $datosInter['fechadiag'] ?? '' ?>">
            </div>


            <div class="col-sm-2">
                <label for="edadDiagnostico" class="form-label-sm">Edad diagnóstico:</label>
                <span id="edadDiagnostico" class="form-control form-control-sm"></span>
            </div>


            
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="biopsia" name="ficha[biopsia]" value="1" onchange="toggleObservaciones()" required="required">
                    <label class="form-check-label" for="biopsia">Biopsia<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Si no se realizó debe 
                                aclararlo en 'Observaciones'"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="endoscopia" name="ficha[endoscopia]" value="1">
                    <label class="form-check-label" for="endoscopia">Endoscopia</label>
                </div>
            </div>



            <div class="col-sm-2">
                <label class="form-label-sm" for="grados">Grados</label>
                <select name="ficha[grados]" id="grados" class="form-control form-control-sm" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="3a">3 a</option>
                    <option value="3b">3 b</option>
                    <option value="3c">3 c</option>
                    <option value="3c">4 </option>
                </select>
            </div>



            <div class="col-sm-2">
                <label class="form-label-sm" for="protocolo">Nº Protocolo</label>
                <input class="form-control form-control-sm" type="text" name="ficha[protocolo]" id="protocolo" value="<?= $datosInter['protocolo'] ?? '' ?>">
            </div>

            <!-- <legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;"> Síntomas y Signos Clínicos
   </legend> -->
            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;">Clínica</legend>

            <div class="col-sm-2">
                <label class="form-label-sm" for="fechadiag">Fecha de Consulta</label>
                <input class="form-control form-control-sm" type="date" name="ficha[fechaconsulta]" id="fechaconsulta" min="1920-01-01" max="<?= date('Y-m-d'); ?>" required="required" value="<?= $datosInter['fechaconsulta'] ?? '' ?>">
            </div>
            <div class="col-sm-4">
                <label class="form-label-sm" for="formaclin">Forma clínica de presentación<span class="text-danger">*</label>
                <select name="ficha[formaclin]" id="formaclin" class="form-control form-control-sm">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="Sintomática digestiva">Sintomática</option>
                    <option value="Sintomática extradigestiva">Asintomática</option>
                    <option value="Asintomática">Subclínica</option>
                    <!-- <option value="Familiar (SCR)">Familiar (SCR)</option> -->
                </select>
            </div>


            <div class="form-group">
                <label class="form-label-sm" for="enfermeasoc">Enfermedades asociadas</label>
                <textarea class="form-control" rows="2" id="enfermeasoc" name="ficha[enfermeasoc]" placeholder="Anotar separado por comas los diagnósticos de la patología asociada"><?= $datosNoti['enfermeasoc'] ?? '' ?></textarea>
            </div>
            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Laboratorio
            </legend>

            <div class="col-sm-3">
                <label class="form-label-sm" for="fechaestrac">Fecha de extracción<span class="text-danger">*</label>
                <input class="form-control form-control-sm" type="date" name="ficha[fechaestrac]" id="fechaestrac" min="1920-01-01" max="<?= date('Y-m-d'); ?>" required="required" value="<?= $datosInter['fechaestrac'] ?? '' ?>">
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="iga" name="ficha[iga]" value="1">
                    <label class="form-check-label" for="iga">IgA sérica total</label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="atgiga" name="ficha[atgiga]" value="1">
                    <label class="form-check-label" for="atgiga">tTG-IgA</label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="IgGPDG" name="ficha[IgGPDG]" value="1">
                    <label class="form-check-label" for="atgigg">IgGPDG</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="EMA" name="ficha[EMA]" value="1">
                    <label class="form-check-label" for="atgigg">EMA</label>
                </div>
            </div>

            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Estudio Grupo Familiar
            </legend>
            <div class="col-sm-6">
                <input type="hidden" name="idCaso" value="1"> <!-- Aquí se debe cambiar el valor del ID del formulario principal -->
                <!-- <h3>Familiares del Caso</h3> -->
                <div id="familiares-container">
                    <!-- Aquí se agregarán dinámicamente los campos de los familiares -->
                </div>
                <button type="button" class="btn btn-primary" onclick="agregarFamiliar()">Agregar Familiar</button>
            </div>

            <legend class="bg-secondary w-100 p-2 mb-0" style="font-size: 0.95rem; font-weight: bold;"> Medidas a observar
            </legend>

            <div class="form-group">
                <label class="form-label-sm" for="observaciones">Observaciones<span id="asterisk" class="text-danger">*</span></label>
                <textarea class="form-control" rows="2" id="observaciones" name="ficha[observaciones]" <?= $datosNoti['observaciones'] ?? '' ?>></textarea>
            </div>


    </fieldset>
    <fieldset class="border p-2">
        <div class="d-flex">
            <div class="col-sm-3">
                <a href="/login/home" class="btn btn-primary " role="button">Salir sin cambiar</a>
            </div>
            <div class="col-sm-3">
                <input type="submit" id="myButton" name=submit class="btn btn-primary " value="Guardar">
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


<!-- ///////edad //////////////////////////// -->
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
<!-- //// edad al diagnostico ///////////// -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('fechadiag').addEventListener('change', function() {
            calcularEdadDiag();
        });
    });

    function calcularEdadDiag() {
        var fechaNacimiento = document.getElementById('fechanac').value;
        var fechaDiagno = document.getElementById('fechadiag').value;


        // Convertir fechas a objetos Date
        var nacimiento = new Date(fechaNacimiento);
        var control = new Date(fechaDiagno);

        // Calcular diferencia de tiempo en milisegundos
        var diffTiempo = control.getTime() - nacimiento.getTime();

        // Calcular diferencia de años
        var edad = new Date(diffTiempo);
        var anios = Math.abs(edad.getUTCFullYear() - 1970);
        var meses = edad.getUTCMonth();
        var dias = edad.getUTCDate() - 1; // Restar 1 día para evitar la diferencia por timezone

        // Mostrar la edad en el formulario
        var resultado = document.getElementById('edadDiagnostico');
        if (anios > 0) {
            resultado.textContent = anios + " años " + meses + " meses";
        } else {
            resultado.textContent = meses + " meses " + dias + " días";
        }
    }
</script>





<script>
    function calcularSemanaEpidemiologica() {
        // Obtener la fecha ingresada
        var fechaInput = document.getElementById("fechanot").value;
        var fecha = new Date(fechaInput);

        // Calcular la semana epidemiológica
        var firstDayOfYear = new Date(fecha.getFullYear(), 0, 1);
        var pastDaysOfYear = (fecha - firstDayOfYear) / 86400000;
        var week = Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);

        return week;
    }

    document.getElementById("fechanot").addEventListener("change", function() {
        var semana = calcularSemanaEpidemiologica();
        document.getElementById("semana").textContent = semana;
    });

    // Calcular la semana epidemiológica al cargar la página
    window.addEventListener('load', function() {
        var semana = calcularSemanaEpidemiologica();
        document.getElementById("semana").textContent = semana;
    });
</script>


<script>
    var auto_complete = new Autocom(document.getElementById('localidad'), {
        data: <?php echo json_encode($dataLocalidad); ?>,
        maximumItems: 10,
        highlightTyped: true,
        highlightClass: 'fw-bold text-primary',
        onSelectItem: function(selectedItem) {
            document.getElementById('gid').value = selectedItem.value; // Asignar el valor del item seleccionado al input hidden
            //document.getElementById('idNinio').value = selectedItem.value; 
        }
    });
</script>

<script>
    function toggleObservaciones() {
        var biopsiaCheckbox = document.getElementById("biopsia");
        var observacionesTextarea = document.getElementById("observaciones");
        var observacionesLabel = document.querySelector('label[for="observaciones"] span.text-danger');

        if (!biopsiaCheckbox.checked) {
            observacionesLabel.style.display = "inline"; // Mostrar el asterisco
            observacionesTextarea.setAttribute("required", "required");
            observacionesTextarea.setAttribute("placeholder", "Debe justificar acá el diagnóstico sin biopsia"); // Agregar el placeholder
        } else {
            observacionesLabel.style.display = "none"; // Ocultar el asterisco
            observacionesTextarea.removeAttribute("required");
            observacionesTextarea.placeholder = ""; // Eliminar el placeholder
        }
    }
</script>

<script>
    var options = {
        data: <?php echo json_encode($data_insti); ?>,
        maximumItems: 10,
        highlightTyped: true,
        highlightClass: 'fw-bold text-primary',
        onSelectItem: function(selectedItem) {
            document.getElementById('codi_esta').value = parseInt(selectedItem.value); // Asignar el valor del item seleccionado al input hidden
        }
    };

    var auto_complete = new Autocom(document.getElementById('institucion'), options);
</script>