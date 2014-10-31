<?php 
defined('_JEXEC') or die ('acces deny');
jimport('joomla.application.component.controller');

class EventosRecursosController extends JController{


	function eventos(){

		JHtml::_('behavior.framework', "core");
		JHtml::_('behavior.framework', "more");
		
		$document = JFactory::getDocument();
		
		$document->addStyleSheet("/joomla/components/com_eventosrecursos/assets/style.css",'text/css',"screen");
		$document->addScript('/joomla/components/com_eventosrecursos/assets/jquery.min.js');

		$document->addStyleSheet('/joomla/components/com_eventosrecursos/assets/fullcalendar/fullcalendar.css','text/css',"screen");
		$document->addStyleSheet('/joomla/components/com_eventosrecursos/assets/fullcalendar//fullcalendar.print.css','text/css',"screen");
		$document->addScript('/joomla/components/com_eventosrecursos/assets/fullcalendar//jquery-ui.custom.min.js');
		$document->addScript('/joomla/components/com_eventosrecursos/assets/fullcalendar//fullcalendar.js');

 		$document->addScript('/joomla/components/com_eventosrecursos/assets//jquery-ui.js');
 		$document->addStyleSheet('/joomla/components/com_eventosrecursos/assets/jquery-ui.css','text/css',"screen");
 		
		$document->addStyleSheet("/joomla/components/com_eventosrecursos/assets/multipleselect/multiple-select.css",'text/css',"screen");
 		$document->addScript('/joomla/components/com_eventosrecursos/assets/multipleselect/jquery.multiple.select.js');

 		$document->addStyleSheet("/joomla/components/com_eventosrecursos/assets/timeselect/jquery.ptTimeSelect.css",'text/css',"screen");
		$document->addScript('/joomla/components/com_eventosrecursos/assets/timeselect/jquery.ptTimeSelect.js');

		$document->addScript('/joomla/components/com_eventosrecursos/assets/jquery.validate.js');


		
		$db=JFactory::getDBO();
		$user  = JFactory::getUser();
 		$userId = (int) $user->get('id');
 		$eliminar=JRequest::getVar('eliminar');
		$editar=JRequest::getVar('editar');
		$actualizar=JRequest::getVar('actualizar');
		$agregar=JRequest::getVar('agregar');

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
			echo '<script>
					$(function() {
						$( "#dialog" ).append("Evento agregado con Exito!!");
				    	$( "#dialog" ).dialog();
				  	});
				  </script>';
		}else{
			// RELLENAR EL FORMULARIO
			echo 
				'<script>
					$("#titulo").val("'.$newNombre		.'");
					$("#descripcion").val("'.$newDescripcion	.'");
					$("#horaInicio").val("'.JRequest::getVar('horaInicio').'");
					$("#horaFinal").val("'.JRequest::getVar('horaFinal').'");
					$("#fechaInicio").val("'.JRequest::getVar('fechaInicio')	.'");
					$("#fechaFinal").val("'.JRequest::getVar('fechaFinal')	.'");
				</script>';
		}


	echo '	<div id="dialog" ></div>

			<input class="inputbox myButton " style="width:100%" onclick="AbrirFormulario()" value="Agregar Evento"> 

			<div id="calendario" style="float:left; width:100%; margin:3px;"></div>
			<style>
			.adminform table tr { border: solid 0px !important;}
			.adminform table td { border: solid 0px !important;}
			fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {
				float: left;
				margin: 3px 9px;
				text-align: left;
				padding: 5px;
			}
			</style>
	';


		if (!$user->guest){
	echo '
			<script>
				function AbrirFormulario(){
					$( "#formularioEventos" ).dialog({ minWidth :700 });
				}

				function CerrarFormulario(){
					$( "#formularioEventos" ).dialog( "close" );
				}
			</script>
			<form id="formularioEventos" title="Agregar Evento" method="POST" style="float:left; display:none; width:700px" >
			<fieldset class="adminform">
	      		<table border="0" >
	      		
	      		<tr>
	      			<td><label  class="hasTip " >Titulo</label>
		    		<td><input type="text" class="inputbox " placeholder="Titulo" id="titulo" name="titulo"></td>
		    	</tr>	
		    	
		    	<tr>
		    		<td><label  class="hasTip " >Descripción</label>
		    		<td><input type="text" class="inputbox " id="descripcion" placeholder="descripción del evento" name="descripcion"></td>
		    	</tr>
		    
		    	<tr>
		    		<td><label  class="hasTip " >Hora y Fecha Inicio</label></td>
		    		<td><input class="inputbox "  id="horaInicio" placeholder="Hora inicio" name="horaInicio" /></td>
					<td><input type="text" class="inputbox  datepicker" id="fechaInicio" placeholder="Fecha Inicio" name="fechaInicio"></td>
		    	</tr>

		    	<tr>
		    		<td><label  class="hasTip " >Hora y Fecha Final</label></td>
		    		<td><input class="inputbox " id="horaFinal" placeholder="Hora cierre" name="horaFinal"></td>
		    		<td><input type="text" class="inputbox  datepicker" id="fechaFinal" placeholder="Fecha Cierre" name="fechaFinal"></td>
		    	</tr>
		    	';


	    echo '	<tr>
	    			<td><label  class="hasTip " >Sala</label></td>
		    		<td><select name="sala" class="inputbox " > ';

		  				$db=JFactory::getDBO();
						$sql = "SELECT * FROM #__eventosrecursos_salas";
						$db->setQuery($sql);
						$db->query();
						$Salas = $db->loadObjectList();
						if (count($Salas))
					    {
					     foreach ($Salas as $item)
					     {
						    	echo "<option value=\"{$item->id} \" >".$item->nombre."</option>";	 
					     }
					    }
					    unset ($Salas);
						echo ' 	</select>
						</td>
				</tr>
						';

		echo '  <tr>
					<td><label  class="hasTip" >Recursos</label></td>
		    		<td><select class="inputbox selectmultiple" name="recursos[]"    multiple="multiple">
		   					';
		  				$db=JFactory::getDBO();
						$sql = "SELECT * FROM #__eventosrecursos_recursos";
						$db->setQuery($sql);
						$db->query();
						$Recursos = $db->loadObjectList();
						if (count($Recursos))
					    {
					     foreach ($Recursos as $item)
					     {
						    	echo "<option value=\"{$item->id} \" >".$item->nombre."-".$item->descripcion."</option>";	 
					     }
					    }
					    unset ($Recursos);
						echo ' 	</select>
						</td>
					</tr>
					<tr>
						<td><input type="hidden" name="agregar" value="true"></td>
						<td><input type="submit" class="inputbox myButton " value="Agregar"></td>
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
			echo '<script>
					$(function() {
						$( "#dialog" ).append("Error: Horario Ocupado!!");
				    	$( "#dialog" ).dialog();
				  	});
				</script>';	
		}

		//VALIDAR RECURSOS
		if( $newRecursos != NULL ){
			$recurosAmostrar  = NULL;
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
			if( $recurosAmostrar != NULL ){
				echo '<script>
					$(function() {
						$( "#dialog" ).append("Recursos Ocupados!! '.$recurosAmostrar.' ");
				    	$( "#dialog" ).dialog();
				  	});
					</script>';
			}
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
}//CLASS CONTROLLER

 ?>