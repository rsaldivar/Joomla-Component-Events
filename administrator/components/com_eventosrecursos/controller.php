<?php 
defined('_JEXEC') or die ('acces deny');
jimport('joomla.application.component.controller');

class EventosRecursosController extends JController{

function salas(){

		JToolBarHelper::Title('Administracion de Salas');
		JHtml::_('behavior.framework', "core");
		JHtml::_('behavior.framework', "more");


		JSubMenuHelper::addEntry('Administrar Eventos', 'index.php?option=com_eventosrecursos&task=eventos');
		JSubMenuHelper::addEntry('Administrar Salas', 'index.php?option=com_eventosrecursos&task=salas');
		JSubMenuHelper::addEntry('Administrar Recursos', 'index.php?option=com_eventosrecursos&task=recursos');


		$document = JFactory::getDocument();
		JHtml::_('stylesheet','components/com_eventosrecursos/assets/style.css');
		JHtml::_('script','components/com_eventosrecursos/assets/jquery.min.js');
		JHtml::_('script','components/com_eventosrecursos/assets/jquery.validate.js');

		
		$app=JFactory::getApplication();
		$id=JRequest::getVar('id');
		$eliminar=JRequest::getVar('eliminar');
		$editar=JRequest::getVar('editar');
		$actualizar=JRequest::getVar('actualizar');
		$agregar=JRequest::getVar('agregar');


		$newNombre=JRequest::getVar('nombre');
		$newDescripcion = JRequest::getVar('descripcion');

		//LLAMADA A LA FUNCION PARA ELIMINAR REGISTROS
		if( $eliminar   == "true")$this->eliminar($id,"#__eventosrecursos_salas");
		//LLAMADA A LA FUNCION PARA ACTUALZIAR REGISTRO
		if( $actualizar == "true")$this->actualizar($id," SET nombre='$newNombre' , descripcion='$newDescripcion' ","#__eventosrecursos_salas");
		//LLAMADA A LA FUNCION PARA INGRESAR REGISTRO
		if( $agregar == "true" && $actualizar != "true" )$this->agregar(" (nombre , descripcion) VALUES ('$newNombre' ,'$newDescripcion') " , "#__eventosrecursos_salas");

		echo '	<div id="dialog" ></div>';
	
		//CONSULTA PARA MOSTRAR LAS SALAS
		$db=JFactory::getDBO();
		$sql = "SELECT * FROM `#__eventosrecursos_salas`";
		$db->setQuery($sql);
		$db->query();
		$Salas = $db->loadObjectList();
		if ($db->getErrorNum()) {
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }
	    else{
			if (count($Salas))
	        {
				  	echo "<form action='' method='post' ><table class='tableEvents' border='1'>";
					echo "<tr><th>Nombre</th><th>Descripción</th><th colspan='2'>Opciones</th></tr>";
				    foreach ($Salas as $fila)
				    {
				    	if($fila->id == $id && $editar == "true"){
				    		echo "<tr>";
					    	echo "<td><input type='text' value=\"$fila->nombre\" name='nombre'></td>";	
			    			echo "<td><input type='text' value=\"$fila->descripcion \" name='descripcion'></td>";
			   			 	echo "<input type='hidden' name='id' value='$fila->id' >";
					    	echo "<input type='hidden' name='actualizar' value='true' >";
					    	echo '<td><input type="submit"  class="myButton" value="Guardar"></td>';
					    	echo '<td><a class="myButton3" href="index.php?option=com_eventosrecursos&task=salas" /> Finalizar </td>';
							echo "</tr>";
				    	}
				    	else{
						    echo "<tr>";
					    	echo "<td>".$fila->nombre."</td>";	
					    	echo "<td>".$fila->descripcion."</td>";
					    	echo '<td><a class="myButton" href="index.php?option=com_eventosrecursos&task=salas&editar=true&id='.$fila->id.' " /> Editar </td><td><a class="myButton2" href="index.php?option=com_eventosrecursos&task=salas&eliminar=true&id='.$fila->id.' " /> Eliminar </td>';
							echo "</tr>";
						}
					}
					echo "</table></form>";
			}
			else
			{
				echo "<h1>No Hay Salas Registradas</h1>";
			}
		}


		echo '<form  id="formularioSalas" method="POST" style="float:left; width:32%" >
				<fieldset class="adminform">
      		
      			<h1>Agregar Sala</h1>
      			<label  class="hasTip " >Nombre</label>
	    		<input type="text" class="inputbox " placeholder="Nombre Sala" name="nombre">
	    		
	    		<label  class="hasTip " >Descripción</label>
	    		<textarea class="inputbox " placeholder="Descripción de la sala" name="descripcion"></textarea>
	    	
		    	<label  class="hasTip " ></label>
	    		<input type="hidden" name="agregar" value="true">
	    		<input type="submit" class="inputbox myButton " value="Agregar">

	    		</fieldset>
	    	</form>';
		
echo '
<script>
 $("#formularioSalas").validate(
 {
  rules: {
    nombre: {
      minlength: 3,
      required: true
    },
    descripcion: {
      minlength: 3,
      required: true
    }
 }
}); 
</script>
';

		/*
		echo "<pre> POST <br>";
		print_r($_POST);
		echo "</pre>";

		echo "<pre> GET <br>";
		print_r($_GET);
		echo "</pre>";
*/
	}

	function recursos(){

		JToolBarHelper::Title('Administración de Recursos ');
		JHtml::_('behavior.framework', "core");
		JHtml::_('behavior.framework', "more");


		JSubMenuHelper::addEntry('Administrar Eventos', 'index.php?option=com_eventosrecursos&task=eventos');
		JSubMenuHelper::addEntry('Administrar Salas', 'index.php?option=com_eventosrecursos&task=salas');
		JSubMenuHelper::addEntry('Administrar Recursos', 'index.php?option=com_eventosrecursos&task=recursos');


		$document = JFactory::getDocument();
		JHtml::_('stylesheet','components/com_eventosrecursos/assets/style.css');
		JHtml::_('script','components/com_eventosrecursos/assets/jquery.min.js');
		JHtml::_('script','components/com_eventosrecursos/assets/jquery.validate.js');


		$app=JFactory::getApplication();
		$id=JRequest::getVar('id');
		$eliminar=JRequest::getVar('eliminar');
		$editar=JRequest::getVar('editar');
		$actualizar=JRequest::getVar('actualizar');
		$agregar=JRequest::getVar('agregar');


		$newNombre=JRequest::getVar('nombre');
		$newDescripcion = JRequest::getVar('descripcion');

		//LLAMADA A LA FUNCION PARA ELIMINAR REGISTROS
		if( $eliminar   == "true")$this->eliminar($id,"#__eventosrecursos_recursos");
		//LLAMADA A LA FUNCION PARA ACTUALZIAR REGISTRO
		if( $actualizar == "true")$this->actualizar($id," SET nombre='$newNombre' , descripcion='$newDescripcion' ","#__eventosrecursos_recursos");
		//LLAMADA A LA FUNCION PARA INGRESAR REGISTRO
		if( $agregar == "true" && $actualizar != "true" )$this->agregar(" (nombre , descripcion) VALUES ('$newNombre' ,'$newDescripcion') " , "#__eventosrecursos_recursos");
		

		$db=JFactory::getDBO();
		$sql = "SELECT * FROM `#__eventosrecursos_recursos";
		$db->setQuery($sql);
		$db->query();
		$Recursos = $db->loadObjectList();
	    if ($db->getErrorNum()) {
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }       

		if (count($Recursos))
		  {
		  	echo "<form action='' method='post' ><table class='tableEvents' border='1'>";
			echo "<tr><th>Nombre</th><th>Descripción</th><th colspan='2'>Opciones</th></tr>";
		    foreach ($Recursos as $fila)
		    {
		    	if($fila->id == $id && $editar == "true"){
		    		echo "<tr>";
			    	echo "<td><input type='text' value=\"$fila->nombre\" name='nombre'></td>";	
			    	echo "<td><input type='text' value=\"$fila->descripcion \" name='descripcion'></td>";
			    	echo "<input type='hidden' name='id' value='$fila->id' >";
			    	echo "<input type='hidden' name='actualizar' value='true' >";
			    	echo '<td><input type="submit"  class="myButton" value="Guardar"></td>';
			    	echo '<td><a class="myButton3" href="index.php?option=com_eventosrecursos&task=recursos" /> Finalizar </td>';
					echo "</tr>";
		    	}
		    	else {
				    echo "<tr>";
			    	echo "<td>".$fila->nombre."</td>";	
			    	echo "<td>".$fila->descripcion."</td>";
			    	echo '<td><a class="myButton" href="index.php?option=com_eventosrecursos&task=recursos&editar=true&id='.$fila->id.' " /> Editar </td><td><a class="myButton2" href="index.php?option=com_eventosrecursos&task=recursos&eliminar=true&id='.$fila->id.' " /> Eliminar </td>';
					echo "</tr>";
				}
			}
			echo "</table></form>";
		}
		else
		{ 
			echo "<h1>No Hay Recursos Registrados</h1>";
		}

	echo '<form  id="formularioRecursos" method="POST" style="float:left; width:32%" >
			<fieldset class="adminform">
      			<h1>Agregar Recurso</h1>
      			<label  class="hasTip " >Nombre del Recurso</label>
	    		<input type="text" class="inputbox " placeholder="nombre" name="nombre">
	    		
	    		<label  class="hasTip " >Descripción</label>
	    		<textarea class="inputbox " placeholder="Descripción" name="descripcion"></textarea>
	    	
	    		<label  class="hasTip " ></label>
	    		<input type="hidden" name="agregar" value="true">
	    		<input type="submit" class="inputbox myButton " value="Agregar">

	    		</fieldset>
	    	</form>';
			
echo '
<script>
 $("#formularioRecursos").validate(
 {
  rules: {
    nombre: {
      minlength: 3,
      required: true
    },
    descripcion: {
      minlength: 3,
      required: true
    }
 }
}); 
</script>
';
			/*
		echo "<pre> POST <br>";
		print_r($_POST);
		echo "</pre>";

		echo "<pre> GET <br>";
		print_r($_GET);
		echo "</pre>";
*/
		
	}

	function eventos(){
		
		JToolBarHelper::Title('Administración de Eventos ');
		JHtml::_('behavior.framework', "core");
		JHtml::_('behavior.framework', "more");


		JSubMenuHelper::addEntry('Administrar Eventos', 'index.php?option=com_eventosrecursos&task=eventos');
		JSubMenuHelper::addEntry('Administrar Salas', 'index.php?option=com_eventosrecursos&task=salas');
		JSubMenuHelper::addEntry('Administrar Recursos', 'index.php?option=com_eventosrecursos&task=recursos');


		$document = JFactory::getDocument();
		
		JHtml::_('stylesheet','components/com_eventosrecursos/assets/style.css');
		JHtml::_('script','components/com_eventosrecursos/assets/jquery.min.js');

		JHtml::_('stylesheet','components/com_eventosrecursos/assets/fullcalendar/fullcalendar.css');
		JHtml::_('stylesheet','components/com_eventosrecursos/assets/fullcalendar/fullcalendar.print.css');
		JHtml::_('script','components/com_eventosrecursos/assets/fullcalendar/jquery-ui.custom.min.js');
		JHtml::_('script','components/com_eventosrecursos/assets/fullcalendar/fullcalendar.js');

 		JHtml::_('script','components/com_eventosrecursos/assets/jquery-ui.js');
 		JHtml::_('stylesheet','components/com_eventosrecursos/assets/jquery-ui.css');
 		
		JHtml::_('stylesheet','components/com_eventosrecursos/assets/multipleselect/multiple-select.css');
 		JHtml::_('script','components/com_eventosrecursos/assets/multipleselect/jquery.multiple.select.js');

 		JHtml::_('stylesheet','components/com_eventosrecursos/assets/timeselect/jquery.ptTimeSelect.css');
		JHtml::_('script','components/com_eventosrecursos/assets/timeselect/jquery.ptTimeSelect.js');

		JHtml::_('script','components/com_eventosrecursos/assets/jquery.validate.js');


		
		$db=JFactory::getDBO();
		$user  = JFactory::getUser();
 		$userId = (int) $user->get('id');
 		$eliminar=JRequest::getVar('eliminar');
		$editar=JRequest::getVar('editar');
		$actualizar=JRequest::getVar('actualizar');
		$agregar=JRequest::getVar('agregar');
		$regresarsalas = JRequest::getVar('regresaralas');

		$id					=JRequest::getVar('id');
		$newNombre			=JRequest::getVar('titulo');
		$newDescripcion		=JRequest::getVar('descripcion');
		$newFechaInicio		=JRequest::getVar('fechaInicio');
		$newFechaFinal		=JRequest::getVar('fechaFinal');
		$newHoraInicio		=JRequest::getVar('horaInicio');
		$newHoraFinal		=JRequest::getVar('horaFinal');
		$newSala			=JRequest::getVar('sala');
		$newRecursos		=JRequest::getVar('recursos');
		
		$newHoraInicio =  strtotime($newHoraInicio);
		$newHoraInicio = date("His", $newHoraInicio);

		$newHoraFinal =  strtotime($newHoraFinal);
		$newHoraFinal = date("His", $newHoraFinal);

		//LLAMADA A LA FUNCION PARA ELIMINAR REGISTROS
		if( $eliminar   == "true")$this->eliminar($id,"#__eventosrecursos_eventos");
		//LLAMADA A LA FUNCION PARA ACTUALZIAR REGISTRO
		if( $actualizar == "true")$this->actualizar($id," SET nombre='$newNombre' , descripcion='$newDescripcion' ","#__eventosrecursos_recursos");
		//LLAMADA A LA FUNCION PARA INGRESAR REGISTRO

		$errorAgregar = NULL;
		if( $agregar == "true" && $actualizar != "true"){
		 $errorAgregar = $this->agregarEvento($newNombre, $newDescripcion,$newFechaInicio,$newFechaFinal,$newHoraInicio,$newHoraFinal,$newRecursos,$newSala,$userId);
		}
		if($errorAgregar){
			// ALERT GRACIAS
			echo '<script>alert("Evento agregado con exito!!");</script>';
		}else{
			// RELLENAR EL FORMULARIO
			echo 
				'<script>
				  $( document ).ready(function() {
					$("#titulo").val("'.$newNombre		.'");
					$("#descripcion").val("'.$newDescripcion	.'");
					$("#horaInicio").val("'.JRequest::getVar('horaInicio').'");
					$("#horaFinal").val("'.JRequest::getVar('horaFinal').'");
					$("#fechaInicio").val("'.JRequest::getVar('fechaInicio')	.'");
					$("#fechaFinal").val("'.JRequest::getVar('fechaFinal')	.'");
				});
				</script>';
		}


		//CON ESTE QUERY ES NECESARIO QUE EXISTAN RECUROSS ASOCIADOS
		$sql = "SELECT `#__eventosrecursos_eventos`.id , `#__eventosrecursos_eventos`.titulo , `#__eventosrecursos_eventos`.descripcion , `#__eventosrecursos_eventos`.fechaInicio,		 `#__eventosrecursos_eventos`.fechaFinal , `#__eventosrecursos_eventos`.horaInicio, `#__eventosrecursos_eventos`.horaFinal,  `#__eventosrecursos_salas`.nombre as sala , count(`#__eventosrecursos_recursos`.id) as recursos from `#__eventosrecursos_eventos` LEFT JOIN `#__eventosrecursos_recursoseventos` ON `#__eventosrecursos_recursoseventos`.evento = `#__eventosrecursos_eventos`.id  LEFT JOIN `#__eventosrecursos_recursos` ON `#__eventosrecursos_recursoseventos`.recurso = `#__eventosrecursos_recursos`.id INNER JOIN `#__eventosrecursos_salas` ON `#__eventosrecursos_eventos`.sala = `#__eventosrecursos_salas`.id GROUP BY `#__eventosrecursos_eventos`.id";
		$db->setQuery($sql);
		$db->query();
		$Eventos = $db->loadObjectList();
		if ($db->getErrorNum()) {
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }       

		if (count($Eventos))
		{
		  	echo "<form action='' method='post' action='' ><table class='tableEvents' border='1'>";
			echo "<tr>
					<th>Titulo</th>
					<th>Descripción</th>
					<th>Dia Inicio</th>
					<th>Dia Fin</th>
					<th>Hr Inicio</th>
					<th>Hr Fin</th>
					<th>Sala</th>
					<th>No. Recursos</th>
					<th colspan='2'>Opciones</th>
				</tr>";
		    foreach ($Eventos as $fila)
		    {
		    	if($fila->id == $id && $editar == "true"){
		    		echo "<tr>";
			    	echo "<td><input type='text' value=\"$fila->nombre\" name='nombre'></td>";	
			    	echo "<td><input type='text' value=\"$fila->descripcion\" name='descripcion'></td>";	
			    	echo "<td><input class='datepicker' type='text' value=\"$fila->fechaInicio \" name='descripcion'></td>";
			    	echo "<td><input class='datepicker' type='text' value=\"$fila->fechaFinal\" name='nombre'></td>";	
			    	echo "<td><input type='text' value=\"$fila->horaInicio \" name='descripcion'></td>";
			    	echo "<td><input type='text' value=\"$fila->horaFinal\" name='nombre'></td>";	
			    	echo "<td><input type='text' value=\"$fila->sala \" name='descripcion'></td>";
			    	echo "<td><input type='text' value=\"$fila->recursos\" name='nombre'></td>";	

			    	echo "<input type='hidden' name='id' value='$fila->id' >";
			    	echo "<input type='hidden' name='actualizar' value='true' >";
			    	echo '<td><input type="submit"  class="myButton" value="Guardar"></td>';
			    	echo '<td><a class="myButton" href="index.php?option=com_eventosrecursos&task=recursos" /> Cancelar </td>';
					echo "</tr>";
		    	}
		    	else {
				    echo "<tr>";
			    	echo "<td>".$fila->titulo."</td>";	
			    	echo "<td>".$fila->descripcion."</td>";	
			    	echo "<td>".$fila->fechaInicio."</td><td>".$fila->fechaFinal."</td><td>".$fila->horaInicio."</td><td>".$fila->horaFinal."</td>";	
			    	echo "<td>".$fila->sala."</td>";	
			    	echo "<td>".$fila->recursos."</td>";	
			    	echo '<!--a class="myButton" href="index.php?option=com_eventosrecursos&task=eventos&editar=true&id='.$fila->id.' " -->';
			    	echo '<td><a class="myButton2" href="index.php?option=com_eventosrecursos&task=eventos&eliminar=true&id='.$fila->id.' " /> Eliminar </td>';
					echo "</tr>";
				}
			}
			echo "</table></form>";
		}
		else
		{
			echo "<h1>No Hay Eventos Registrados</h1>";
		}


	echo '<div id="calendario" style="float:left; width:60%; margin:30px 0px;"></div>
			<style>
			table td { border: solid 0xp ;}
			fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {
				float: left;
				margin: 3px 9px;
				text-align: left;
				padding: 5px;
			}
			</style>
	';


	if (!$user->guest){
	echo 	'<script>
			function validarFechasTituloDescripcion(){
				var AT = $("#formularioEventos").valid(); // RETURN BOOLEAN
				if(AT == true){
					$(".salasYrecursos").show();
					$.ajax( {
							url : "index.php?option=com_eventosrecursos&task=responseAjaxSalas",
							data : "regresarsalas=true",
							success: function(respuesta) {
								for(respuesta in result) {
								   console.log(respuesta, result[respuesta]);
								}
								$contruccionSalas = ":::";
								$("#salas").append($contruccionSalas);
						    }, 
  							error: function() {
								console.log("No hay salas disponibles");
						    }
					});
				}//IF
			}
			</script>';
	echo 	'<form id="formularioEventos" method="POST" style="float:left; width:433px" >
			<fieldset class="adminform">
	      		<h1>Agregar Evento</h1>
	      		<table border="0" >
	      		
	      		<tr>
	      			<td><label  class="hasTip " >Titulo</label>
		    		<td><input type="text" class="inputbox " placeholder="Titulo" id="titulo" name="titulo"></td>
		    	</tr>	
		    	
		    	<tr>
		    		<td><label  class="hasTip " >Descripción</label>
		    		<td><input type="text" class="inputbox " id="descripcion" placeholder="Descripción" name="descripcion"></td>
		    	</tr>
		    
		    	<tr>
		    		<td><label  class="hasTip " >Hora y Fecha Inicio</label></td>
		    		<td><input onchange="validarFechasTituloDescripcion()" class="inputbox "  id="horaInicio"  name="horaInicio" /></td>
					<td><input onchange="validarFechasTituloDescripcion()" type="text" class="inputbox  datepicker" id="fechaInicio" placeholder="fechaInicio" name="fechaInicio"></td>
		    	</tr>

		    	<tr>
		    		<td><label  class="hasTip " >Hora y Fecha Final</label></td>
		    		<td><input onchange="validarFechasTituloDescripcion()" class="inputbox " id="horaFinal" name="horaFinal"></td>
		    		<td><input onchange="validarFechasTituloDescripcion()" type="text" class="inputbox  datepicker" id="fechaFinal" placeholder="fechaFinal" name="fechaFinal"></td>
		    	</tr>
		    	<tr id="salas">
		    	</tr>
				<tr>
					<td><input type="hidden" name="agregar" value="true"></td>
					<td class="salasYrecursos" style="display:none"><input type="submit" class="inputbox myButton " value="Agregar"></td>
				</tr>
				</table>
   				</div>
   				</form>
	';
		
	}

	if ($user->guest){
		echo "Logeate para agregar eventos";
	}





echo "
<script>

	$(document).ready(function() {
	
		$('#calendario').fullCalendar({
			theme: false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: [
			{
				title: 'Ejemplo',
				start: new Date(1970, 00, 4),
				end  : new Date(2000, 04, 17),
				description: 'This is a cool event'
			}";
$SQL ="SELECT titulo ,
Date_format(fechaInicio,'%Y') as inicioAnio,
Date_format(fechaInicio,'%m') as inicioMes,
Date_format(fechaInicio,'%d') as inicioDia,
Date_format(horaInicio,'%H')  as inicioHora,
Date_format(horaInicio,'%i')  as inicioMinuto,
Date_format(fechaFinal,'%Y')  as finalAnio,
Date_format(fechaFinal,'%m')  as finalMes,
Date_format(fechaFinal,'%d')  as finalDia,
Date_format(horaFinal,'%H')   as finalHora,
Date_format(horaFinal,'%i')   as finalMinuto, `#__eventosrecursos_eventos`.descripcion , `#__eventosrecursos_salas`.nombre as sala 
, GROUP_CONCAT( `#__eventosrecursos_recursos`.nombre ) as recursos
from `#__eventosrecursos_eventos` 
JOIN `#__eventosrecursos_salas`  
ON `#__eventosrecursos_eventos`.sala  = `#__eventosrecursos_salas`.id
LEFT JOIN `#__eventosrecursos_recursoseventos` 
ON `#__eventosrecursos_recursoseventos`.evento  = `#__eventosrecursos_eventos`.id 
LEFT JOIN `#__eventosrecursos_recursos`  
ON `#__eventosrecursos_recursos`.id  = `#__eventosrecursos_recursoseventos`.recurso 
GROUP BY `#__eventosrecursos_eventos`.titulo 
";

$db->setQuery($SQL);
$db->query();
if ($db->getErrorNum()) {// Check for a database error.
	        JError::raiseWarning(500, $db->getErrorMsg());
}    
$MapsEventos = $db->loadObjectList();
if (count($MapsEventos))
{
     foreach ($MapsEventos as $fila)
    {
		$fila->inicioMes = $fila->inicioMes-1;
		$fila->finalMes  = $fila->finalMes-1;
		$fila->inicioHora = $fila->inicioHora + 0;
		$fila->inicioMinuto= $fila->inicioMinuto + 0;
		$fila->finalHora  = $fila->finalHora + 0 ;
		$fila->finalMinuto  = $fila->finalMinuto + 0 ;

			echo 
				',{
					title: \'' .$fila->titulo.'\' ,
					className : \'colorClass' .$fila->sala.'\',
					nombre: \'' .$fila->titulo.'\' ,
					description : \'' .$fila->descripcion.'\',
					recursos : \'' .$fila->recursos.'\',					
					sala : \'' .$fila->sala.'\',
					start: new Date(' .$fila->inicioAnio.' ,' .$fila->inicioMes.' ,' .$fila->inicioDia.' ,' .$fila->inicioHora.' ,' .$fila->inicioMinuto.' ),
					end: new Date(' .$fila->finalAnio.' ,' .$fila->finalMes.' ,' .$fila->finalDia.' ,' .$fila->finalHora.' ,' .$fila->finalMinuto.' ),
					allDay: false
 		 		}';
	}//FIN EACH
}

echo "
			],

			eventAfterRender: function (event, element, view) {
		        var dataHoje = new Date(); 
		        //ACTUALES
		        if (event.start < dataHoje && event.end > dataHoje) {
		            element.css('background-color', '#17AA98');
		        } else if (event.start < dataHoje && event.end < dataHoje) { 
		        //TERMINADOS
		           element.css('background-color', '#7E7E7E');
		        }
		        //FALTANTES
		        else if (event.start > dataHoje && event.end > dataHoje) {
		            element.css('background-color', '#5E98FF');
		        } 
		    },

		    eventRender: function(event, element) { 
            	element.find('.fc-event-title').append('<hr/><b>Evento : </b><i>' + event.nombre + '</i>' ); 
            	element.find('.fc-event-title').append('<br/><b>Sala : </b><i>' + event.sala + '</i>' ); 
            	element.find('.fc-event-title').append('<br/><b>Descripción : </b><i>' + event.description + '</i>' ); 
            	element.find('.fc-event-title').append('<br/><b>Recursos : </b><i>' + event.recursos + '</i>' ); 
        	},

  			//NOMBRE DE MESES Y DIAS
    		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    		dayNamesShort : ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			dayNamesShort : ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],

    		timeFormat: 'h:mmtt{ - h:mm}'

		});
	});
</script>
<style>

#calendario{
	margin:30px;
}

</style>


 <script>
  	$(function() 
  	{
  		$( '.datepicker' ).datepicker({ minDate: 0, maxDate: '+3M +15D' });
	    $( '.datepicker' ).datepicker( 'option', 'dateFormat', 'yy-mm-dd' );
  	});
    $('.selectmultiple').multipleSelect({
            position: 'top'
        });
    $('#horaInicio').ptTimeSelect();
 	$('#horaFinal').ptTimeSelect();
  </script>
	";

	
echo '
<script>


function evaluarHoras(){
	return (Date.parse($("#horaFinal").val()) > Date.parse($("#horaInicio").val()));
}

function evaluarFechas(){
	return $.datepicker.parseDate("yy-mm-dd", $("#fechaInicio").val() ) <= $.datepicker.parseDate("yy-mm-dd", $("#fechaFinal").val() );
}

function evaluarHoraFecha(){
	if($.datepicker.parseDate("yy-mm-dd", $("#fechaInicio").val() ) >= $.datepicker.parseDate("yy-mm-dd", $("#fechaFinal").val() )){
		return evaluarHoras();
	}
	return  true;
}

$.validator.addMethod("fechaInicioMayor", function(value, element ) {
	return this.optional(element) || evaluarFechas()
}, "Error el horario de inicio es mayor a horario de cierre");


//SE RETORNA EL MENSAJE, Y DESPUES DE || VA LO DESEADO
$.validator.addMethod("fechaIgualHoraMayor", function(value, element ) {
	return this.optional(element) ||  evaluarHoraFecha()
}, "La hora de inicio es mayor a la hora fin ");


$.validator.addMethod("time", function(value, element) {  
return this.optional(element) || /^(0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/i.test(value);  
}, "Concentrate por favor : ingresa hora valida.");

 $("#formularioEventos").validate(
 {
  rules: {
    titulo: {
      minlength: 3,
      required: true
    },
    descripcion: {
      minlength: 3,
      required: true
    },
    horaInicio:{
    	required: true,
        time: "selecciona hora inicio"
    },
    fechaInicio:{
    	required: true,
    	date: true
    },
    horaFinal:{
    	required: true,
        time: "selecciona hora final",
        fechaIgualHoraMayor : "Error horario"
    },
    fechaFinal:{
    	required: true,
      	date: true,
        fechaInicioMayor : "Error fechas"
    },
    sala:{
    	required: true
    }
 },
  messages: {
    titulo: "Escribe nombre del evento",
    descripcion: "Agrega descripción del evento"

  }
}); 


</script>
';



	}


	function eliminar($id,$tabla){
		$db=JFactory::getDBO();
		$sql = "DELETE FROM ".$tabla." where id=".$id;
		$db->setQuery($sql);
		$db->query();

	 	if ($db->getErrorNum()) {// Check for a database error.
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }     		
	}
	
	function actualizar($id,$set,$tabla){
		$db=JFactory::getDBO();
		$sql = "UPDATE $tabla $set where id=".$id;
		$db->setQuery($sql);
		$db->query();

	 	if ($db->getErrorNum()) {// Check for a database error.
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }     		
	}
	function agregar($values,$tabla){
		$db=JFactory::getDBO();
		$sql = "INSERT INTO $tabla $values ";
		$db->setQuery($sql);
		$db->query();

	 	if ($db->getErrorNum()) {// Check for a database error.
	        JError::raiseWarning(500, $db->getErrorMsg());
	    }     		
	}


	function agregarEvento($newNombre, $newDescripcion,$newFechaInicio,$newFechaFinal,$newHoraInicio,$newHoraFinal,$newRecursos,$newSala,$userId){
		$db=JFactory::getDBO();
		return false;
		//QUITAR CUANDO ESTEN LISTO LOS SELECT	
		$ErrorHorario = 0;
		$ErrorRecurso = 0;

		//VALIDAR SALA Y HORARIO
		$tbl_eventos  		 = "#__eventosrecursos_eventos";
		$tbl_recursos 		 = "#__eventosrecursos_recursos";
		$tbl_recursoseventos = "#__eventosrecursos_recursoseventos";
		$tbl_salas    		 = "#__eventosrecursos_salas";

		$SQL = ' 
			( select * from '.$tbl_eventos.' where "'.$newFechaInicio.'" between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraInicio.'" >= '.$tbl_eventos.'.horaInicio  and "'.$newHoraInicio.'" < '.$tbl_eventos.'.horaFinal AND sala='.$newSala.')
			UNION
			( select * from '.$tbl_eventos.' where "'.$newFechaFinal.'"  between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraInicio.'" >= '.$tbl_eventos.'.horaInicio  and "'.$newHoraInicio.'" < '.$tbl_eventos.'.horaFinal AND sala='.$newSala.')
			UNION
			( select * from '.$tbl_eventos.' where "'.$newFechaInicio.'"  between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraFinal.'" >  '.$tbl_eventos.'.horaInicio  and "'.$newHoraFinal.'"  <= '.$tbl_eventos.'.horaFinal AND sala='.$newSala.')
			UNION
			( select * from '.$tbl_eventos.' where "'.$newFechaFinal.'"  between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraFinal.'"  >  '.$tbl_eventos.'.horaInicio  and "'.$newHoraFinal.'"  <= '.$tbl_eventos.'.horaFinal AND sala='.$newSala.')
			';
		$db->setQuery($SQL);
		$db->query();
	 	$EventosConflictivos = $db->loadObjectList();
		if (count($EventosConflictivos))
		{
			$ErrorHorario++;
			echo '<script>alert("La sala esta ocupada en este horario");</script>';	
		}

		//VALIDAR RECURSOS
		if( $newRecursos != NULL ){
			$recurosAmostrar  ="";
			foreach ($newRecursos as $key => $value) {
				$SQL = '
				( select '.$tbl_recursos.'.nombre , '.$tbl_recursos.'.descripcion  from '.$tbl_eventos.' JOIN '.$tbl_recursoseventos.' ON '.$tbl_recursoseventos.'.evento = '.$tbl_eventos.'.id JOIN '.$tbl_recursos.' ON '.$tbl_recursoseventos.'.recurso = '.$tbl_recursos.'.id where "'.$newFechaInicio.'" between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraInicio.'" > '.$tbl_eventos.'.horaInicio  and "'.$newHoraInicio.'" < '.$tbl_eventos.'.horaFinal AND '.$tbl_recursos.'.id = '.$value.'  )
				UNION
				( select '.$tbl_recursos.'.nombre , '.$tbl_recursos.'.descripcion  from '.$tbl_eventos.' JOIN '.$tbl_recursoseventos.' ON '.$tbl_recursoseventos.'.evento = '.$tbl_eventos.'.id JOIN '.$tbl_recursos.' ON '.$tbl_recursoseventos.'.recurso = '.$tbl_recursos.'.id where "'.$newFechaFinal.'" between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal  AND "'.$newHoraInicio.'" > '.$tbl_eventos.'.horaInicio  and "'.$newHoraInicio.'" < '.$tbl_eventos.'.horaFinal AND '.$tbl_recursos.'.id = '.$value.'  )
				UNION
				( select '.$tbl_recursos.'.nombre , '.$tbl_recursos.'.descripcion  from '.$tbl_eventos.' JOIN '.$tbl_recursoseventos.' ON '.$tbl_recursoseventos.'.evento = '.$tbl_eventos.'.id JOIN '.$tbl_recursos.' ON '.$tbl_recursoseventos.'.recurso = '.$tbl_recursos.'.id where "'.$newFechaInicio.'" between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal AND "'.$newHoraFinal.'"  > '.$tbl_eventos.'.horaInicio  and "'.$newHoraInicio.'" < '.$tbl_eventos.'.horaFinal AND '.$tbl_recursos.'.id = '.$value.'  )
				UNION
				( select '.$tbl_recursos.'.nombre , '.$tbl_recursos.'.descripcion  from '.$tbl_eventos.' JOIN '.$tbl_recursoseventos.' ON '.$tbl_recursoseventos.'.evento = '.$tbl_eventos.'.id JOIN '.$tbl_recursos.' ON '.$tbl_recursoseventos.'.recurso = '.$tbl_recursos.'.id where "'.$newFechaFinal.'" between '.$tbl_eventos.'.fechaInicio and '.$tbl_eventos.'.fechaFinal  AND "'.$newHoraFinal.'"  > '.$tbl_eventos.'.horaInicio  and "'.$newHoraFinal.'" < '.$tbl_eventos.'.horaFinal AND '.$tbl_recursos.'.id = '.$value.'  )
				';
				$db->setQuery($SQL);
				$db->query();
		 		$RecursosConflictivos = $db->loadObjectList();
				if( count($RecursosConflictivos)){
					$ErrorRecurso ++;
					foreach ($RecursosConflictivos as $fila)
				    {
						$recurosAmostrar .= $fila->nombre . " " .$fila->descripcion. " , " ;
					}
				}
			}
			if($recurosAmostrar != "")echo '<script>alert("Estos recursos no estan disponibles : '.$recurosAmostrar.' ") </script>';
		}

		if( $ErrorHorario  == 0 AND $ErrorRecurso == 0 AND $newNombre != NULL AND $newDescripcion != NULL AND $newHoraFinal != NULL AND $newHoraInicio != NULL AND $newFechaFinal != NULL AND $newFechaInicio != NULL ){
			$SQL  = " INSERT INTO $tbl_eventos ( titulo, descripcion, horaInicio, fechaInicio, horaFinal, fechaFinal, usuario , sala)";
			$SQL .= " VALUES( ";
			$SQL .=  ' "' .$newNombre    . ' " , ';
			$SQL .=  ' "' .$newDescripcion . ' " , ';
			$SQL .=  ' "' .$newHoraInicio  . ' " , ';
			$SQL .=  ' "' .$newFechaInicio . ' " , ';
			$SQL .=  ' "' .$newHoraFinal   . ' " , ';
			$SQL .=  ' "' .$newFechaFinal  . ' " , ';
			$SQL .=  ' "' .$userId.'" , ';
			$SQL .=  $newSala ;
			$SQL   .=  " ) ";
			$db->setQuery($SQL);
			$db->query();

	 		if ($db->getErrorNum()) {
	       		 JError::raiseWarning(500, $db->getErrorMsg());
	  		}  

	  		$SQL="SELECT max(id) from `#__eventosrecursos_eventos`";
			$db->setQuery($SQL);
			$db->query();
			$idEvento = $db->loadResult();//TREA COUNT
	 		//echo 'ULTIMO ID '.$idEvento;

			if( $newRecursos != NULL ){
				foreach ($newRecursos as $key => $value) {
					$SQL = 'INSERT INTO '.$tbl_recursoseventos.' VALUES('.$value.','.$idEvento.' )';
					$db->setQuery($SQL);
					$db->query();
				}
			}
			return true;
		}//FIN IF
		return false;
	}// INSERT EVENTOS


	//FUCIONES AJAX
	function responseAjaxSalas(){
		JFactory::getDocument()->setMimeEncoding( 'application/json' );
    	JResponse::setHeader('Content-Disposition','attachment;filename="progress-report-results.json"');

    		$data = array(
    				'Sala 1' => '1',
    				'Sala 2' => '2',
    				'Sala 3' => '3'
    			);
    	echo json_encode( $data );
    	JFactory::getApplication()->close(); // or jexit();
	
	}

	function responseAjaxRecursos(){
		JFactory::getDocument()->setMimeEncoding( 'application/json' );
	    JResponse::setHeader('Content-Disposition','attachment;filename="progress-report-results.json"');

	    $data = array(
	        'foo' => 'bar'
	    );
	    echo json_encode( $data );
	    JFactory::getApplication()->close(); // or jexit();
	}


}//CLASS CONTROLLER
?>


