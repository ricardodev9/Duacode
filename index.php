<?php
require_once 'autoload.php';  
require_once 'config.php';    

/**
 * Indicaciones para las rutas
 */

if(isset($_GET['team']) && $_GET['team']){
    $teamController->getTeamById($_GET['team'], $teamController->getCaptains($_GET['team']));
    $playerController->getPlayersByTeam($_GET['team']);
}else if(isset($_GET['player']) && $_GET['player'] !=''){
    $playerController->getPlayerById($_GET['player'], $teamController->getTeamsObject());
}else{
    $teamController->getTeams();
}


?>