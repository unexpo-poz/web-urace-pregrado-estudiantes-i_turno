<?php
	include_once ('inc/odbcss_c.php');
	include_once ('inc/config.php');
	include_once ('inc/activaerror.php');

	$claveOK=false;
	$datosOK=false;
	
	$Cdatos = new ODBC_Conn("CENTURA-DACE","c","c",$ODBCC_conBitacora, $laBitacora);
	$Cdatos->iniciarTransaccion("Inicio Consulta: ".$_POST['cedula']." - ");
	$uSQL	= "SELECT exp_e,carrera,nombres,nombres2,apellidos,apellidos2  FROM dace002 a, tblaca010 b ";
	$uSQL	.= "WHERE ci_e='".$_POST['cedula']."' and a.c_uni_ca=b.c_uni_ca";
	$Cdatos->ExecSQL($uSQL,__LINE__,true);
	$datosOK = $Cdatos->filas == 1;
	if ($datosOK){
		$esp=$Cdatos->result[0][1];

		$ape=$Cdatos->result[0][4]." ".$Cdatos->result[0][5];
		$nom=$Cdatos->result[0][2]." ".$Cdatos->result[0][3];
			
		$Cusers = new ODBC_Conn("USERSDB","c","c",$ODBCC_conBitacora, $laBitacora);
		$uSQL	= "SELECT userid FROM usuarios WHERE userid='".$Cdatos->result[0][0]."' ";
		$uSQL  .= "AND password='".md5($_POST['contra'])."'";
		$Cusers->ExecSQL($uSQL,__LINE__,true);
		$claveOK = $Cusers->filas == 1;
		if (!$claveOK) { //use la clave maestra		
			$uSQL  = "SELECT password FROM usuarios WHERE userid='master' ";
			$uSQL .= "AND password='".md5($_POST['contra'])."'";
			// 
			$Cusers->ExecSQL($uSQL,__LINE__,true);
			$claveOK = $Cusers->filas == 1;
			if (!$claveOK){
				$Cdatos->finalizarTransaccion("Clave incorrecta: ".$_POST['cedula']);
			}
		}
	}else{
		$Cdatos->finalizarTransaccion("Cédula incorrecta: ".$_POST['cedula']);
	}
	//$claveOK=true;
	if ($claveOK && $datosOK){
		$Cturno = new ODBC_Conn("CENTURA-DACE","c","c");

		

		$tSQL = "SELECT ord_exp,ord_ape,ord_nom,ord_dia,ord_fec,ord_tur ";
		$tSQL.= "FROM ".$tablaOrdenInsc." ";
		$tSQL.= "WHERE ord_ced='".$_POST['cedula']."' ";
		//$tSQL.= " AND ord_exp IN (SELECT exp_e FROM dace006 WHERE lapso='".$lapsoProceso."' AND status IN ('P') ) ";
		$Cturno->ExecSQL($tSQL);
		$turno=$Cturno->result;

		if ($Cturno->filas == 1){
			$hora1=substr($turno[0][5],0,2);
			$minuto1=substr($turno[0][5],2,2);
			$hora2=substr($turno[0][5],4,2);
			$minuto2=substr($turno[0][5],6,2);
		
			//echo $turno[0][0].$turno[0][1].$turno[0][2].$turno[0][3].$turno[0][4];

			$exp=$turno[0][0];
			$dia=$turno[0][3];$fecha=$turno[0][4];
			$hora="De ".$hora1.":".$minuto1." a ".$hora2.":".$minuto2;
			$Cdatos->finalizarTransaccion("Finaliza consulta: ".$_POST['cedula']);
		}else{
			$Cdatos->finalizarTransaccion("No tiene turno: ".$_POST['cedula']);
		}		
	}	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE><?=$tProceso.$tLapso?></TITLE>
	<style type="text/css">
		<!--
		.tit14 {
		  text-align: center; 
		  font-family: Arial; 
		  font-size: 13px; 
		  font-weight: bold;
		  letter-spacing: 1px;
		  font-variant: small-caps;
		}
		.instruc {
		  font-family:Arial; 
		  font-size: 12px; 
		  font-weight: normal;
		  background-color: #FFFFCC;
		  text-align: center;
		}
		.instruc1 {
		  font-family:Arial; 
		  font-size: 12px; 
		  font-weight: normal;
		  text-align: right;
		}
		.boton {
		  text-align: center; 
		  font-family:Arial; 
		  font-size: 11px;
		  font-weight: normal;
		  background-color:#e0e0e0; 
		  font-variant: small-caps;
		  height: 20px;
		  padding: 0px;
		}
		.enc_p {
		  color:#FFFFFF;
		  text-align: center; 
		  font-family:Arial; 
		  font-size: 11px; 
		  font-weight: normal;
		  background-color:#3366CC;
		  height:20px;
		  font-variant: small-caps;
		}
		.enc_p2 {
		  color:#000000;
		  font-family:Arial; 
		  font-size: 13px; 
		  font-weight: bold;
		  height:20px;
		  font-variant: small-caps;
		  text-align: center; 
		}
		.inact {
		  text-align: center; 
		  font-family:Arial; 
		  font-size: 11px; 
		  font-weight: normal;
		}
		.inact2 {
		  text-align: center; 
		  font-family:Arial; 
		  font-size: 11px; 
		  font-weight: normal;
		 
		}
		.inact3 {
		  text-align: center; 
		  font-family:Arial; 
		  font-size: 11px; 
		  font-weight: bold;
		  color: #FFFFCC;
		  background-color:#3366CC;
		}
		.datospf {
		  text-align: left; 
		  font-family:Arial; 
		  font-size: 11px;
		  font-weight: normal;
		  background-color:#FFFFFF; 
		  font-variant: small-caps;
		  border-style: solid;
		  border-width: 1px;
		  border-color: #96BBF3;
		  text-transform:uppercase;
		}
		-->
		</style>
 </HEAD>

 <BODY>

	<table align="center" border="0" cellpadding="0" cellspacing="1" width="550">
	<tr>
		<td class="inact"><IMG SRC="imagenes/unex15.gif" WIDTH="75" HEIGHT="75" BORDER="0" ALT="">
		</td>
		
		<td class="inact" >Universidad Nacional Experimental Polit&eacute;cnica<BR>"Antonio Jos&eacute; de Sucre"<BR>Vicerrectorado&nbsp;<? print $vicerrectorado?><BR><? print $nombreDependencia  ?><BR> <? print $tProceso ?>&nbsp;Lapso&nbsp;<? print $lapsoProceso ?>
		</td>
		
	</tr>
	<tr>
		<td class="tit14" colspan="2"><BR>
		<?=$tProceso?><BR>
		</td>
		
	</tr>
</table>
<?php

if ($claveOK && ($Cturno->filas == 1)){
$year=substr($fecha,0,4);
$month=substr($fecha,5,2);
$day=substr($fecha,8,2);

echo <<<ENC
		<BR>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="500" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td colspan="3">Datos del Estudiante</td>	
			</tr>
		</table>

		<table align="center" border="1" cellpadding="0" cellspacing="1" width="600" style="border-collapse: collapse;border-color:#3366CC;">
			<tr class="inact3">
				<td width="100">Expediente:</td>
				<td width="200">Apellidos:</td>
				<td width="200">Nombres:</td>
				<td width="200">Especialidad:</td>
			</tr>
			<tr class="inact2">
				<td width="100">$exp</td>
				<td width="200">$ape</td>
				<td width="200">$nom</td>
				<td width="200">$esp</td>
			</tr>
		</table>
		<BR>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="300" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td width="420" colspan="3">Turno de Inscripcion</td>	
			</tr>
		</table>
		
		<table align="center" border="1" cellpadding="0" cellspacing="1" width="300" style="border-collapse: collapse;border-color:#3366CC;">
			<tr class="inact3">
				<td width="100">Dia:</td>
				<td width="100">Fecha:</td>
				<td width="100">Hora (Militar):</td>
			</tr>
			<tr class="inact">
				<td width="100">$dia</td>
				<td width="100">$day/$month/$year</td>
				<td width="100">$hora</td>
			</tr>
		</table>
		<BR>	
ENC;

if ($motrarMat) {
########################
/*Rutina para mostrar las asignaturas disponibles en el lapso actual */

$Cmat = new ODBC_Conn("CENTURA-DACE","c","c");

$exped = $exp;

$pSQL = "SELECT pensum,mencion_esp,c_uni_ca FROM dace002 WHERE exp_e='".$exped."' ";
$Cmat->ExecSQL($pSQL);

$pensumPoz = $Cmat->result[0][0];
$mencion = $Cmat->result[0][1];
$c_carr = $Cmat->result[0][2];

#para no mostrar ciudadania
$CDD = "SELECT c_asigna FROM dace004 WHERE ";
$CDD.= "(status='0' OR status='3' OR status='B') AND ";
$CDD.= "exp_e='".$exped."' AND c_asigna='300677'";
$Cmat->ExecSQL($CDD);
if ($Cmat->filas == '1'){
	$ciud=" AND tblaca008.c_asigna<>'300676' ";
}else $ciud=' ';

#para no mostrar venezuela
$VEN = "SELECT c_asigna FROM dace004 WHERE "; 
$VEN.= "(status='0' OR status='3' OR status='B') AND ";
$VEN.= "exp_e='".$exped."' AND c_asigna='300676'";
$Cmat->ExecSQL($VEN);
if ($Cmat->filas == '1'){
	$venez=" AND tblaca008.c_asigna<>'300677' ";
}else $venez=' ';

$mSQL = "SELECT tblaca009.semestre, tblaca008.c_asigna, asignatura, ";
$mSQL.= "tblaca009.u_creditos ";
$mSQL.= "FROM materias_inscribir, tblaca009 , tblaca008 WHERE ";
$mSQL.= " materias_inscribir.c_asigna=tblaca009.c_asigna AND "; 
$mSQL.= " mencion='".$mencion."' AND pensum='".$pensumPoz."' ";
$mSQL.= " AND exp_e='".$exped."' AND c_uni_ca='".$c_carr."' ";
$mSQL.= " AND tblaca008.c_asigna=tblaca009.c_asigna ";
$mSQL.= " AND tblaca008.c_asigna NOT IN(SELECT c_asigna FROM ";
$mSQL.= " dace004 where (status='0' OR status='3' OR status='B') ";
$mSQL.= " AND exp_e='".$exped."' )";
$mSQL.= " ".$ciud." ";
$mSQL.= " ".$venez." ";
$mSQL.= " AND materias_inscribir.c_asigna <> '300622' ";
$mSQL.= " and tblaca009.c_asigna not in (select c_asigna from dace006 where status in (7,'A') AND lapso<>'".$lapsoProceso."' AND exp_e='".$exped."' ) ";
$mSQL.= "	ORDER BY semestre";
//echo $mSQL;
$Cmat->ExecSQL($mSQL);
$lista_m = $Cmat->result;
$total_m = count($lista_m);

echo <<<ENCA
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="500" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td colspan="3">Asignaturas Ofertadas</td>	
			</tr>
		</table>

	<table align="center" border="1" cellspacing="1" width="600" style="border-collapse: collapse;border-color:#3366CC;">
		<tr class="inact3">
		<td>SEMESTRE</td>
		<td>CODIGO</td>
		<td>ASIGNATURA</td>
		<td>U.C.</td>
		<td>SECCIONES</td>
		</tr>
ENCA;


	for ($i = 0; $i < $total_m; $i++){
		if (substr($lista_m[$i][2],0,8)!="ELECTIVA"){
			echo "<tr class=\"inact\">";
			($lista_m[$i][0] > 10) ? $lista_m[$i][0] = "ELECTIVA" : $lista_m[$i][0];
			
			for ($j = 0; $j < 4; $j++){
				echo "<td>";
				echo $lista_m[$i][$j];	
				echo "</td>";
			}// end for j
			
			$c_asigna = $lista_m[$i][1];
			$sSQL = "SELECT seccion,inscritos,tot_cup FROM tblaca004 WHERE c_asigna='".$c_asigna."' ";
			$sSQL.= "AND lapso='".$lapsoProceso."' AND cod_carrera LIKE '%".$c_carr."%' ORDER BY 1";
			$Cmat->ExecSQL($sSQL);
			$secciones = $Cmat->result;
			echo "<td>";
			$secc = "";
			for ($x=0;$x<count($secciones);$x++) {
				($secciones[$x][1] == $secciones[$x][2]) ? $cupo=" (SIN CUPO)" : $cupo="";
				$secc.= $secciones[$x][0].$cupo.", ";
			}// end for
			echo substr($secc,0,strlen($secc)-2);
			
			if (count($secciones) == 0){
				echo "<span style='font-size:8px;'>NO OFERTADA</span>";
			}

			//echo strlen($secc);
			echo "</td>";			
			
			echo "</tr>";
		}// end if 
	}// end for i

echo "</table>";
########################
}

	function alumno_en_rango($horaTurno, $fechaTurno) {
		$fechaActual = time() - 3600*date('I');
		$tHora = intval(substr($horaTurno ,0,2),10);
		$tMin = intval(substr($horaTurno,2,2),10);
		$tFecha = explode('-',$fechaTurno); //anio-mes-dia
		@$suFecha = mktime($tHora, $tMin, 0, $tFecha[1], $tFecha[2], $tFecha[0],date('I'));
		//echo $suFecha." - ".($fechaActual - 1800);
		return ($suFecha <= ($fechaActual));
	}

	if(alumno_en_rango($turno[0][5],$turno[0][4])){
echo <<<TURNO
		<BR>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="650" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td width="420" colspan="3" style="text-decoration:blink;color:#FF0000;">En este momento tu turno de inscripci&oacute;n est&aacute; activo.</td>	
			</tr>
			<tr class="enc_p2" >
				<td align="center" colspan="2">
					Presiona para <a href="../intensiv_l" target="_blank">ir al Sistema de inscripci&oacute;n</a>
				</td>
			</tr>
		</table>
TURNO;
	}

}else {
	echo <<<ENC2
		<BR>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="650" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td width="420" colspan="3">CEDULA O CLAVE INCORRECTA<BR>TAMBIEN ES POSIBLE QUE NO SE HAYA PREINSCRITO<br>VERIFIQUE E INTENTE DE NUEVO</td>	
			</tr>
			<tr class="enc_p2" >
				<td align="center" colspan="2">
					<BR><a href="javascript:history.back(1)">volver</a>
				</td>
			</tr>
		</table>
ENC2;
	
	}
?>
 </BODY>
</HTML> 