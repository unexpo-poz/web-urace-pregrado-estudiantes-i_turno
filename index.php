<?php
	include_once ('inc/odbcss_c.php');
	include_once ('inc/config.php');
	include_once ('inc/activaerror.php');
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
		  text-align: left; 
		  font-family:Arial; 
		  font-size: 11px; 
		  font-weight: normal;
		  padding-left: 10px; 
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
	<script languaje="Javascript">
<!--
function validar(f) {
	if ((f.cedula.value == "")||(f.contra.value == "")) {
		alert("Por favor, escriba su Cédula y clave antes de pulsar el botón Entrar");
		return false;
	}
}	
//-->
</script> 
<!-- <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19432248-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
 -->

 </HEAD>

 <BODY>

	<table align="center" border="0" cellpadding="0" cellspacing="1" width="530">
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
	<tr>
		<td class="tit14" colspan="2"><BR>
		<span style="color:#FF0000;">Correspondiente a la fase <?php echo $fase ?> de fecha <?php echo $fechap ?></span><BR>
		</td>
		
	</tr>
	<tr>
		<td class="tit14" colspan="2"><BR>
		<span style="color:#FF0000;"><?php echo $proposito ?></span><BR>
		</td>
	</tr>
</table>

<?php
if ($inscHabilitada){
	echo <<<ENC
	<form name="acceso" method="POST" action="turno.php" onsubmit="return validar(this)">
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="220" style="border-collapse: collapse;border-color:black;">
			<tr class="enc_p2">
				<td width="220" colspan="2">&nbsp;</td>
				
			</tr>
			<tr class="inact">
				<td width="10">C&eacute;dula:&nbsp;</td>
				<td width="60">
					<input name="cedula" maxlength="8" class="datospf" style="width: 130px;" type="text">
				</td>
			</tr>
			<tr class="inact">
				<td width="10"><BR>Clave:&nbsp;</td>
				<td width="60">
					<BR><input name="contra" class="datospf" style="width: 130px;" type="password">
				</td>
			</tr>
			<tr class="enc_p2" >
				<td align="center" colspan="2">
					<BR><INPUT TYPE="submit" value="Consultar">
				</td>
			</tr>
			<tr class="enc_p2" >
				<td align="center" colspan="2">
					Si tu n&uacute;mero de C&eacute;dula es menor a 10 millones, agrega un cero al inicio.
				</td>
			</tr>
			
		</table>
	</form>
	
ENC;

}
else {

echo <<<ENC
	<BR><BR>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="350" style="border-collapse: collapse;border-color:black;">
			<tr class="inact">
				<td>
					En este momento el m&oacute;dulo no est&aacute; disponible.<BR><BR>
					Estamos procesando la informaci&oacute;n para generar el orden de inscripci&oacute;n lo m&aacute;s pronto posible, por favor mantente atento.
				</td>
			</tr>
			<tr class="inact">
				<td>
					<BR><IMG SRC="imagenes/loading.gif" WIDTH="32" HEIGHT="32" BORDER="0" ALT="">
				</td>
			</tr>
		</table>
	
ENC;

}
?>

  
 </BODY>
</HTML>