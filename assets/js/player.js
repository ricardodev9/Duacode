$(document).ready(function () {
    const $savePlayerBtn = $('#savePlayerBtn'); // Botón de guardar

    const $playerNameEdit = $('#playerNameInput');
    const $playerNumberEdit = $('#playerNumberInput');
    const $playerTeamEdit = $('#playerTeamSelect');

    // Función de validación del formulario
    function validateFormEdit() {
        let valid = true;
        let errorMessages = [];

        // Validar el nombre
        if ($playerNameEdit.val().trim() === "") {
            valid = false;
            errorMessages.push("El nombre del jugador es requerido.");
            $playerNameEdit.addClass("is-invalid");
        } else {
            $playerNameEdit.removeClass("is-invalid");
        }

        // Validar número del jugador
        if ($playerNumberEdit.val().trim() === "") {
            valid = false;
            errorMessages.push("El número del jugador es requerido.");
            $playerNumberEdit.addClass("is-invalid");
        } else {
            $playerNumberEdit.removeClass("is-invalid");
        }

        // Validar equipo
        if ($playerTeamEdit.val().trim() === "") {
            valid = false;
            errorMessages.push("El equipo es requerido.");
            $playerTeamEdit.addClass("is-invalid");
        } else {
            $playerTeamEdit.removeClass("is-invalid");
        }

        // Mostrar mensajes de error si la validación falla
        if (!valid) {
            alert(errorMessages.join("\n"));
        }

        return valid;
    }
    // Enviar datos actualizados al hacer clic en "Guardar"
    $savePlayerBtn.on('click', function () {
        const playerId = $(this).data('player-id');
        const formData = {
            method: 'update_player',
            playerId: playerId,
            is_captain: $('#isCaptain').is(':checked') ? 1 : 0
        };
        if (validateFormEdit()) {
            $.ajax({
                url: './inc/functions.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function () {
                    alert('Ha ocurrido un error en la solicitud.');
                }
            });
        }
    });

    // Handle para eliminar el player
    $('.delete').on('click', function () {
        const playerId = $(this).data('player-id');
        const formData = {
            method: 'delete_player',
            playerId: playerId,
        };

        if (confirm("Seguro que quieres eliminar el usuario?") == true) {
            $.ajax({
                url: './inc/functions.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function () {
                    alert('Ha ocurrido un error en la solicitud.');
                }
            });
        }
    });

    // Función para agregar el fondo oscuro del modal
    function addBackdrop() {
        $('body').append('<div class="modal-backdrop show"></div>');
    }

    // Función para remover el fondo oscuro del modal
    function removeBackdrop() {
        $('.modal-backdrop').remove();
    }

    const $addPlayerModal = $('#addPlayerModal'); // Abrir modal para form de crear nuevo jugador
    const $saveNewPlayerBtn = $('#saveNewPlayerBtn'); // Botón para guardar el nuevo jugador

    // Mostrar el modal al hacer clic en el botón de añadir jugador
    $('#openModalAddPlayer').on('click', function () {
        addBackdrop();
        $addPlayerModal.css('display', 'block');
    });

    // Cerrar el modal 
    $('#closeAddPlayerModalBtn').on('click', function () {
        removeBackdrop();
        $addPlayerModal.css('display', 'none');
    });
    $('#closeAddPlayerModalBtnFooter').on('click', function () {
        removeBackdrop();
        $addPlayerModal.css('display', 'none');
    });

    // Formulario de añadir jugador
    const $playerNameInput = $('#playerName');
    const $playerNumberInput = $('#playerNumber');
    const $playerTeamInput = $('#playerTeam');

    // Función de validación del formulario
    function validateForm() {
        let valid = true;
        let errorMessages = [];

        // Validar el nombre
        if ($playerNameInput.val().trim() === "") {
            valid = false;
            errorMessages.push("El nombre del jugador es requerido.");
            $playerNameInput.addClass("is-invalid");
        } else {
            $playerNameInput.removeClass("is-invalid");
        }

        // Validar número del jugador
        if ($playerNumberInput.val().trim() === "") {
            valid = false;
            errorMessages.push("El número del jugador es requerido.");
            $playerNumberInput.addClass("is-invalid");
        } else {
            $playerNumberInput.removeClass("is-invalid");
        }

        // Validar equipo
        if ($playerTeamInput.val().trim() === "") {
            valid = false;
            errorMessages.push("El equipo es requerido.");
            $playerTeamInput.addClass("is-invalid");
        } else {
            $playerTeamInput.removeClass("is-invalid");
        }

        // Mostrar mensajes de error si la validación falla
        if (!valid) {
            alert(errorMessages.join("\n"));
        }

        return valid;
    }
    // Guardar el nuevo jugador
    $saveNewPlayerBtn.on('click', function () {
        const formData = {
            method: 'add_player',
            name: $('#playerName').val(),
            number: $('#playerNumber').val(),
            team: $('#playerTeam').val(),
            captain: $('#playerCaptain').is(':checked') ? 1 : 0,
        };
        if (validateForm()) {
            $.ajax({
                url: './inc/functions.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.msg);
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function () {
                    alert('Hubo un error al agregar el jugador.');
                }
            });
        }
    });
});
