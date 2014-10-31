<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
defined('_JEXEC') or die('acces deny');




// import joomla controller library
jimport('joomla.application.component.controller');

//CREARMOS LA INSTANCIA AL CONTROLADOR
$controller = JController::getInstance('EventosRecursos');

//EJECUTAMOS ALGO
$controller->execute(JRequest::getCmd('task'));


// Redirect if set by the controller
$controller->redirect();

 ?>