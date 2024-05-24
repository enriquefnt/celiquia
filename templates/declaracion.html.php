<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Declaración de Responsabilidad y Confidencialidad</h2>
            </div>
            <div class="card-body">
                <p><strong>Uso de Datos Personales en el Sistema de Registros de Diagnósticos de Enfermedad Celíaca</strong></p>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">
                        <strong>Responsabilidad del Usuario</strong>
                        <p>Al acceder al sistema de registros de diagnósticos de enfermedad celíaca, usted, como profesional médico, declara bajo juramento que comprende y acepta su responsabilidad en el manejo y protección de los datos personales de los pacientes. Usted se compromete a utilizar esta información exclusivamente para los fines médicos y administrativos permitidos por la legislación vigente.</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Confidencialidad de los Datos Personales</strong>
                        <p>En virtud de su acceso al sistema, usted reconoce y acepta que toda la información personal de los pacientes es estrictamente confidencial. Se compromete a no divulgar, compartir ni utilizar dicha información para ningún propósito que no esté explícitamente autorizado por las leyes y regulaciones aplicables en materia de protección de datos personales y secreto profesional.</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Cumplimiento de la Legislación Vigente</strong>
                        <p>Usted declara conocer y aceptar las disposiciones establecidas en la Ley de Protección de Datos Personales (Ley N° 25.326) y las regulaciones asociadas. Asimismo, se compromete a cumplir con todas las normativas específicas relacionadas con el manejo de información sensible y la confidencialidad de los datos de salud de los pacientes.</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Obligación de Seguridad</strong>
                        <p>Como usuario del sistema, usted se compromete a adoptar todas las medidas necesarias para garantizar la seguridad y la integridad de los datos personales almacenados en el sistema. Esto incluye, pero no se limita a, la implementación de prácticas seguras de acceso, almacenamiento y transmisión de datos, conforme a las mejores prácticas y estándares de seguridad de la información.</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Declaración de Aceptación</strong>
                        <p>Al hacer clic en "Aceptar" o al acceder al sistema, usted manifiesta su conformidad con esta declaración de responsabilidad y confidencialidad, y se compromete a cumplir con todas las obligaciones aquí descritas. Cualquier violación de estas condiciones puede resultar en la suspensión de su acceso al sistema y en acciones legales correspondientes.</p>
                    </li>
                </ol>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="acceptDeclaration" onchange="toggleButton()">
                    <label class="form-check-label" for="acceptDeclaration">
                        Acepto y Declaro Conocer los Aspectos Legales del Resguardo de Datos Personales
                    </label>
                </div>
                <div class="mt-3 hidden" id="continueButtonDiv">
                    <a href="login" class="btn btn-primary">Continuar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleButton() {
            var checkBox = document.getElementById('acceptDeclaration');
            var buttonDiv = document.getElementById('continueButtonDiv');
            if (checkBox.checked) {
                buttonDiv.classList.remove('hidden');
            } else {
                buttonDiv.classList.add('hidden');
            }
        }
        
        // Ensure the button is hidden on initial page load
        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('continueButtonDiv').classList.add('hidden');
        });
    </script>