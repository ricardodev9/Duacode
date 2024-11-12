<?php
require_once 'autoload.php';  
require_once 'config.php';    

if(isset($_GET['view']) && $_GET['view'] == 'players'){

}else{
    if(isset($_GET['team']) && $_GET['team']){
        $teamController->getTeamById($_GET['team']);
    }else{
        $teamController->getTeams();
    }
}

?>