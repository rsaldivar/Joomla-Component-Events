<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
defined('_JEXEC') or die('acces deny');

jimport('joomla.application.component.controller');



//CREARMOS LA INSTANCIA AL CONTROLADOR
$controller = JController::getInstance('EventosRecursos');

//EJECUTAMOS ALGO
$controller->execute(JRequest::getCmd('task'));

$controller->redirect();

 ?>