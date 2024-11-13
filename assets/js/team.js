$(document).ready(function () {
    // Obtener los elementos necesarios
    const $modal = $('#addTeamModal');
    const $openModalBtn = $('#openModalBtn');
    const $closeModalBtns = $('#closeModalBtn, #closeModalBtnFooter'); // Botones de cierre del modal
    const $saveTeamBtn = $('#saveTeamBtn'); // Botón de guardar

    // Formulario de Añadir equipo
    const $teamForm = $('#teamForm');
    const $teamNameInput = $('#teamName');
    const $teamCityInput = $('#teamCity');
    const $teamSportInput = $('#teamSport');
    const $teamFoundationDateInput = $('#teamFoundationDate');

    // Función de validación del formulario
    function validateForm() {
        let valid = true;
        let errorMessages = [];

        // Validar Team Name
        if ($teamNameInput.val().trim() === "") {
            valid = false;
            errorMessages.push("El nombre del equipo es requerido.");
            $teamNameInput.addClass("is-invalid");
        } else {
            $teamNameInput.removeClass("is-invalid");
        }

        // Validar Foundation Date
        if ($teamFoundationDateInput.val().trim() === "") {
            valid = false;
            errorMessages.push("La fecha de fundación es requerida.");
            $teamFoundationDateInput.addClass("is-invalid");
        } else {
            $teamFoundationDateInput.removeClass("is-invalid");
        }

        // Validar City
        if ($teamCityInput.val().trim() === "") {
            valid = false;
            $teamCityInput.addClass("is-invalid");
        } else {
            $teamCityInput.removeClass("is-invalid");
        }

        // Mostrar mensajes de error si la validación falla
        if (!valid) {
            alert(errorMessages.join("\n"));
        }

        return valid;
    }

    // Función para agregar el fondo oscuro del modal
    function addBackdrop() {
        $('body').append('<div class="modal-backdrop show"></div>');
    }

    // Función para remover el fondo oscuro del modal
    function removeBackdrop() {
        $('.modal-backdrop').remove();
    }

    // Función para guardar el equipo
    $saveTeamBtn.on('click', function () {
        // Validar el formulario
        if (validateForm()) {
            // Si es válido, enviar la información al servidor usando AJAX
            const formData = {
                method: 'add_team',
                teamName: $teamNameInput.val(),
                teamCity: $teamCityInput.val(),
                teamSport: $teamSportInput.val(),
                teamFoundationDate: $teamFoundationDateInput.val()
            };
            
            $.ajax({
                url: './inc/functions.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.msg);
                        location.reload();  // Recargar la página para ver los cambios
                    } else {
                        alert(data.msg);
                    }
                },
                error: function () {
                    alert('An error occurred during the AJAX request. Please try again.');
                }
            });
        }
    });

    // Mostrar el modal al hacer clic en "Add Team"
    $openModalBtn.on('click', function () {
        $teamForm[0].reset();  // Limpiar el formulario
        $teamNameInput.removeClass("is-invalid");
        $teamFoundationDateInput.removeClass("is-invalid");
        $teamCityInput.removeClass("is-invalid");
        $modal.show(); 
        addBackdrop();
    });

    // Cerrar el modal al hacer clic en los botones de cierre
    $closeModalBtns.on('click', function () {
        $teamForm[0].reset();  // Limpiar el formulario
        $teamNameInput.removeClass("is-invalid");
        $teamFoundationDateInput.removeClass("is-invalid");
        $teamCityInput.removeClass("is-invalid");
        $modal.hide(); 
        removeBackdrop(); 
    });
});
