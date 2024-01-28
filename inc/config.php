<?php
$enProduccion 		= true;
$raizDelSitio		= 'http://'.$_SERVER['SERVER_NAME'].'/web/urace/pregrado/estudiantes/i_turno/';
$urlDelSitio		= 'http://www.poz.unexpo.edu.ve/web/';

$tProceso			= 'Turno de Inscripci&oacute;n Pregrado Ingenier&iacute;a';
$lapsoProceso		= '2021-1I';

$tLapso				= ' Lapso '.$lapsoProceso;
$laBitacora			=  $_SERVER[DOCUMENT_ROOT].'/log/pregrado/estudiantes/turnos_'.$lapsoProceso.'.log';

$inscHabilitada		= true;// Abre y Cierra el modulo
$motrarMat			= false;// Muestra u oculta las materias
$fase				= '2';

switch($fase){
	case '1':
		$fechap = "16 de Agosto";
		//$proposito = "<b>Cambio de Materias Preinscritas</b><br><b>Inscribir Materias No Preinscritas</b>";
		$proposito = "<b>Confirmar la INSCRIPCI&Oacute;N de las Materias Preinscritas</b>.<br><br>TURNO SOLO PARA ESTUDIANTES PREINSCRITOS.<br>SI NO PREINSCRIBI&Oacute; ASIGNATURAS NO PODR&Aacute; INGRESAR.";
		//$proposito = "<b>Turno fase 1, para estudiantes preinscritos";
		//$proposito = "<b>El proceso de Inscripcion ha sido suspendido hasta nuevo aviso.";
		break;
	case '2':
		$fechap = "17 de Agosto";
		$proposito = "<b>Cambio de Materias Preinscritas</b><br><b>Inscribir Materias No Preinscritas</b>";
		break;
}

$msgfase = "";

$sedesUNEXPO = array (	'BQTO' => array('BQTO', 'CARORA'), 
						'CCS'  => array('DACECCS'),
						'POZ'  => array('DACEPTO')
				);

//$sedeActiva = 'BQTO';
//$sedeActiva = 'CCS';
$sedeActiva = 'POZ';
$pensumPoz = '5';

$nucleos = $sedesUNEXPO[$sedeActiva];

//$vicerrectorado		= "Luis Caballero Mej&iacute;as";
//$vicerrectorado		= "Barquisimeto";
$vicerrectorado		= "Puerto Ordaz";
$nombreDependencia = 'Unidad Regional de Admisi&oacute;n y Control de Estudios';

// * * * * * OJO OJO OJO OJO * * * * * 
// Cambiar esto manualmente de acuerdo a la jornada.
// Tipo de jornada
//	0 : deshabilitado 
//	1 : solo preinscritos en las materias preinscritas.
//	2 : solo preinscritos, pero pueden cambiar las materias.
//	3 : todos preinscritos o no preinscritos
$tipoJornada = '1';
$tablaOrdenInsc = 'ORDEN_INSCRIPCION3';


//Unidad Tributaria y Costo de las materias:
$unidadTributaria	= 46.00;
$valorPreMateria	= 0.2*$unidadTributaria;
$valorMateria		= 109.2;

// Maximo numero de depositos a presentar:
$maxDepo			= 8;
//Usuario maestro
$masterID		  = 'dace1';
// Proteccion de las paginas contra boton derecho, no javascript y navegadores no soportados:
if ($enProduccion){
	$botonDerecho = 'oncontextmenu="return false"';
	$noJavaScript = '<noscript><meta http-equiv="REFRESH" content="0;URL=no-javascript.php"></noscript>';
	$noCache	  = "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	$noCache	 .= '<meta http-equiv="Expires" content="-1">';
	$noCacheFin	  = '<head><meta http-equiv="Pragma" content="no-cache"></head>';
}
else {
	$botonDerecho = '';
	$noJavaScript = '';
	$noCache	  = '';
	$noCacheFin	  = '';
}
?>