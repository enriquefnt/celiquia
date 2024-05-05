
// pone el guion en los campos numero del celular :)

function llenarCampo(idCampo) {
    var campo = document.getElementById(idCampo);
    var valor = campo.value;

    if (valor.length === 3) {
        campo.value = valor + "-";
    } else if (valor.length > 3 && !valor.includes("-")) {
        var primeraParte = valor.substr(0, 3);
        var segundaParte = valor.substr(3);
        campo.value = primeraParte + "-" + segundaParte;
    }
}

window.addEventListener("DOMContentLoaded", function() {
    var camposCarga = document.querySelectorAll("[data-llenar-campo]");
    camposCarga.forEach(function(campo) {
        var idCampo = campo.dataset.llenarCampo;
        campo.addEventListener("keydown", function() {
            llenarCampo(idCampo);
        });
    });
});

 // pone la fecha del día por defecto en formulario de pedidos


document.addEventListener("DOMContentLoaded", function() {
    var fechaInput = document.getElementById("fecha_ped");
    var fechaActual = new Date();
    var dia = ("0" + fechaActual.getDate()).slice(-2);
    var mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
    var fechaHoy = fechaActual.getFullYear() + "-" + mes + "-" + dia;

    fechaInput.value = fechaHoy;
  });

  // COntrola el switch en cargar producto

  const activoSwitch = document.getElementById('activoSwitch');
    const activoInput = document.getElementById('activoInput');

    activoSwitch.addEventListener('change', function() {
      activoInput.value = this.checked ? '1' : '0';
    });

    // icono ayuda
    ///agrega campos para familiares
    function agregarFamiliar() {
        var container = document.getElementById("familiares-container");
        var div = document.createElement("div");
        div.classList.add("row");
        div.innerHTML = `
            <div class="col-sm-4">
                <label class="form-label-sm" for="familiar_nombre">Nombre:</label>
                <input type="text" class="form-control form-control-sm" name="ficha[familiar_nombre][]" >
            </div>
            <div class="col-sm-4">
                <label class="form-label-sm" for="familiar_apellido">Apellido:</label>
                <input type="text" class="form-control form-control-sm" name="ficha[familiar_apellido][]" >
            </div>
            <div class="col-sm-4">
                <label class="form-label-sm" for="familiar_parentezco">Parentesco:</label>
                <select name="ficha[familiar_parentezco][]" id="familiar_parentezco" class="form-control form-control-sm">
                <option value="" disabled selected>Seleccione una opción</option>
                <option value='Hermano/a'>Hermano/a</option>
                <option value='Padre/Madre'>Padre/Madre</option>
                <option value='Hijo/a'>Hijo/a</option>
                <option value='Tio/a'>Tio/a</option>
                <option value='Abuelo/a'>Abuelo/a</option>
                </select>
            </div>
          
            
        `;
        container.appendChild(div);
    
        var filas = container.getElementsByClassName('row');
        if (filas.length > 1) {
            var ultimaFila = filas[filas.length - 1];
            var labels = ultimaFila.querySelectorAll('label');
            labels.forEach(function(label) {
                label.style.display = 'none';
            });
        }
    }

   // placehoders en select
   document.addEventListener('DOMContentLoaded', function() {
    const selectElements = document.querySelectorAll('.form-control.form-control-sm');
  
    selectElements.forEach(function(selectElement) {
      validateSelect(selectElement);
      selectElement.addEventListener('change', function() {
        validateSelect(this);
      });
    });
  });
  
  function validateSelect(selectElement) {
    if (selectElement.value === '') {
      selectElement.nextElementSibling.textContent = 'Seleccione una opción.';
      selectElement.form.onsubmit = function(event) {
        event.preventDefault(); // Prevent form submission if placeholder is selected
      };
    } else {
      selectElement.nextElementSibling.textContent = ''; // Clear error message if selection is made
      selectElement.form.onsubmit = null; // Remove validation if selection is made
    }
  }
  