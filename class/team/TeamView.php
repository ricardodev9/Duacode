<?php

class TeamView
{

    // Incluir archivos CSS y scripts
    public function includeAssets()
    {
        // Incluir CSS
        echo '<link rel="stylesheet" href="assets/css/index.css">';
        echo '<link rel="stylesheet" href="assets/css/navbar.css">';
        echo '<link rel="stylesheet" href="assets/css/footer.css">';
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
            <title>Duacode</title>
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

    // Mostrar el formulario para añadir un nuevo equipo
    public function renderAddTeamForm()
    {
        ?>
            <!-- Modal para añadir un nuevo equipo -->
            <div class="modal" id="addTeamModal" tabindex="-1" aria-labelledby="addTeamModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTeamModalLabel">Añadir nuevo equipo</h5>
                            <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario para añadir un equipo -->
                            <form id="teamForm">
                                <div class="mb-3">
                                    <label for="teamName" class="form-label">Nombre del equipo</label>
                                    <input type="text" class="form-control" id="teamName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="teamCity" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="teamCity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="teamSport" class="form-label">Deporte</label>
                                    <select class="form-select" id="teamSport" required>
                                        <option selected>Football</option>
                                        <option>Basketball</option>
                                        <option>Baseball</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="teamFoundationDate" class="form-label">Foundation Date</label>
                                    <input type="date" class="form-control" id="teamFoundationDate" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closeModalBtnFooter">Close</button>
                            <button type="button" class="btn btn-custom" id="saveTeamBtn">Save Team</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

    // Mostrar la lista de equipos
    public function renderTeamList($teams)
    {
        ?>
            <div class="container">
                <div class="table-wrapper">
                    <h2 class="text-center my-4">Lista de equipos</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre del equipo</th>
                                <th>Ciudad</th>
                                <th>Deporte</th>
                                <th>Fecha de fundación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teams as $team): ?>
                                <tr>
                                    <td><?= $team['name'] ?></td>
                                    <td><?= $team['city'] ?></td>
                                    <td><?= $team['sport'] ?></td>
                                    <td><?= $team['foundation_date'] ?></td>
                                    <td class="action-btns">
                                        <a href="index.php?team=<?= $team['id'] ?>"><i class="bi bi-eye-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-custom" id="openModalBtn">
                        <i class="bi bi-plus-circle"></i> Add Team
                    </button>
                </div>
            </div>
        <?php
    }

    // Método para renderizar un solo Equipo
    public function renderSingleTeam($team, $captains = null)
    {
    ?>
        <div class="container">
            <div class="table-wrapper">
                <div class="single-team-view container">
                    <h2 class="text-center my-4">Detalles del del equipo</h2>
                    <div class="card">
                        <div class="card-header">
                            <h3><?= htmlspecialchars($team['name']); ?></h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Ciudad:</strong> <?= htmlspecialchars($team['city']); ?></p>
                            <p><strong>Deporte:</strong> <?= htmlspecialchars($team['sport']); ?></p>
                            <p><strong>Fecha de fundación:</strong> <?= htmlspecialchars($team['foundation_date']); ?></p>
                            <p><strong>Capitanes: </strong></p>

                            <?php if ($captains && count($captains) > 0):
                            ?> <ul><?php
                                        foreach ($captains as $captains):
                                        ?>
                                        <li><?= $captains['name'] ?></li>
                                    <?php
                                        endforeach;
                                    ?>
                                </ul>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <a href="index.php" class="btn btn-secondary mt-3">Ver equipos</a>
                </div>
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
            <!-- JS personalizado para la gestión de Teams -->
            <script src="assets/js/team.js"></script>
        </body>
        </html>
    <?php
    }
    
    // Método para renderizar toda la página
    public function render($teams, $type, $captains = null)
    {
        $this->renderHeader();
        $this->includeNavbar();
        if ($type == "getAllTeams") {
            $this->renderTeamList($teams);
        } else if ($type == "getTeamById") {
            if ($captains) {
                $this->renderSingleTeam($teams, $captains);
            } else {
                $this->renderSingleTeam($teams);
            }
        }
        $this->renderAddTeamForm();
        $this->renderFooter();
    }
}
?>