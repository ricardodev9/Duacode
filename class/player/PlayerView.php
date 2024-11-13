<?php

class PlayerView
{

    // Incluir archivos CSS y scripts
    public function includeAssets()
    {
        // Incluir CSS
        echo '<link rel="stylesheet" href="assets/css/index.css">';
        echo '<link rel="stylesheet" href="assets/css/navbar.css">';
        // Incluir Bootstrap 5 y otras dependencias
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">';
    }

    // Renderizar el encabezado HTML con los assets
    public function renderHeader()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista de jugadores</title>
            <?php $this->includeAssets(); ?> <!-- Incluir CSS y scripts -->
        </head>

        <body>
        <?php
    }

    // Incluir el archivo de la barra de navegación
    public function includeNavbar()
    {
        include 'resources/navbar.php';
    }


    // Mostrar la lista de equipos
    public function renderPlayersList($players)
    {
        ?>
            <div class="container">
                <div class="table-wrapper">
                    <h2 class="text-center my-4">Lista de jugadores</h2>
                    <?php if(count($players) > 0): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Número</th>
                                <th>Capitán</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($players as $player): ?>
                                <tr>
                                    <td><?= $player['name'] ?></td>
                                    <td><?= $player['number'] ?></td>
                                    <td><?= $player['is_captain'] == 1 ? 'Sí' : 'No' ?></td>
                                    <td class="action-btns">
                                        <a href="index.php?player=<?= $player['id'] ?>"><i class="bi bi-pencil-square"></i></a>
                                        <i class="bi bi-trash delete"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Delete"
                                            data-player-id="<?= htmlspecialchars($player['id']); ?>"></i>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                    <button type="button" class="btn btn-custom" id="openModalAddPlayer">
                        <i class="bi bi-plus-circle"></i> Añadir jugador
                    </button>
                </div>
            </div>
        <?php
    }

    // Renderizar el pie de página y scripts
    public function renderFooter()
    {
        ?>
            <!-- Enlace al JS de Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybY3P+Yc7JzEgaE20/2v4C5WcsaZtmP7p4I6Knxg8pH4Evaj5" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0R5lB6JvR1sM8fqchj+GYvQQr1lXYJY3Fj91bM6R3P3mIEmR" crossorigin="anonymous"></script>
        </body>
        <script src="assets/js/player.js"></script>
        </html>
    <?php
    }

    // Método para renderizar un solo Equipo
    public function renderSinglePlayer($player, $teams)
    {
    ?>
        <!-- Formulario sin `action` ni `method` -->
        <div class="container">
            <div class="table-wrapper">
                <div class="single-team-view container">
                    <h2 class="text-center my-4">Editar Detalles del Jugador</h2>
                    <div class="card">
                        <div class="card-header">
                            <h3>
                                <label for="playerNameInput" class="form-label">Nombre del Jugador</label>
                                <input type="text" id="playerNameInput" class="form-control" name="name" value="<?= htmlspecialchars($player['name']); ?>" required>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="playerNumberInput" class="form-label">Número</label>
                                <input type="number" id="playerNumberInput" class="form-control" name="number" value="<?= htmlspecialchars($player['number']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="playerTeamSelect" class="form-label">Equipo</label>
                                <select id="playerTeamSelect" class="form-select" name="team" required>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?= htmlspecialchars($team['id']); ?>" <?= $team['id'] == $player['team_id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($team['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isCaptain" name="is_captain" value="1" <?= $player['is_captain'] == 1 ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="isCaptain">Capitán</label>
                            </div>
                            <!-- Botón de guardar sin enviar el formulario por defecto -->
                            <button type="button" class="btn btn-success" id="savePlayerBtn" data-player-id="<?= $player['id']; ?>">Guardar Cambios</button>
                        </div>
                    </div>
                    <a href="index.php?team=<?= $player['team_id'] ?>" class="btn btn-secondary mt-3">Volver a la lista de jugadores</a>
                </div>
            </div>
        </div>

    <?php
    }

    // Método para añadir nuevo jugador
    public function renderAddPlayerModal()
    {
    ?>
        <!-- Modal para añadir un jugador -->
        <div id="addPlayerModal" class="modal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir Nuevo Jugador</h5>
                        <button type="button" class="btn-close" id="closeAddPlayerModalBtn" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addPlayerForm">
                            <input type="hidden" name="playerTeam" id="playerTeam" value="<?=$_GET['team']?>">
                            <div class="mb-3">
                                <label for="playerName" class="form-label">Nombre del Jugador</label>
                                <input type="text" class="form-control" id="playerName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="playerNumber" class="form-label">Número del Jugador</label>
                                <input type="number" class="form-control" id="playerNumber" name="number" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="playerCaptain" name="captain">
                                <label class="form-check-label" for="playerCaptain">Capitán</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeAddPlayerModalBtnFooter">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="saveNewPlayerBtn">Añadir Jugador</button>
                    </div>
                </div>
            </div>
        </div>


<?php
    }


    // Método para renderizar toda la página
    public function render($players, $type, $teams = null)
    {
        $this->renderHeader();
        $this->includeNavbar();
        if ($type == 'getAllPlayersByTeam') {
            $this->renderPlayersList($players);
            $this->renderAddPlayerModal();
        } else if ($type == 'getPlayerById') {
            $this->renderSinglePlayer($players, $teams);
        }
        $this->renderFooter();
    }
}
?>