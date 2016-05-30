<?php

include_once 'mensajes_sistema.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$urlWebServiceServer = "http://app.pagaconring.com/r1i2n3g4Central/webservices/server/";
$urlWebServiceClient = "http://app.pagaconring.com/r1i2n3g4Central/webservices/client/";
//Secciones
define('cPrincipal', 'iewkkjhsd');
define('cCambioClave', 'yhiuweh');
define('cNuevaVenta', 'sdgfads');
define('cOperaciones', 'ahdssdfdjwue');
define('cClientes', 'iuwsdfa');
define('cAddClientes', 'oijsdna');
define('cEditClientes', 'qwihjsa');
define('cMailBox', 'roiwensdn');

define('cReporteGeneral', 'weruisdfjh');
define('cReporteIntComisionesMes', 'iiousdghd');
define('cReporteIntComisionesRango', 'uiqwihsdfbs');
define('cReporteIntComisionesVendedor', 'uqywubdsjbsd');
define('cReporteIntComisionesTotales', 'qwgdyughbs');

define('cEstadoCuenta', 'qwiopeyuusdhs');
define('cVerFactura', 'qiwrhghgbabc');
define('cReportarPago', 'bbnabsdfjkb');

define('cUsuarios', 'khsadkjh');
define('cAddUsuarios', 'wqetyjds');
define('cEditUsuarios', 'iuerbxj');

define('cBancos', 'hgfjasas');
define('cAddBancos', 'eyuiyas');
define('cEditBancos', '8ry7hasj');

define('cVirtualPoints', 'ytjashjh');
define('cAddVirtualPoints', 'nbvbjhdg');
define('cEditVirtualPoints', 'iuhyewhkjds');

function setNotificacion( $contenido = null, $tipo = "success") 
{

	$_SESSION["notificacion"]["contenido"] = $contenido;

	$_SESSION["notificacion"]["tipo"] = $tipo;

}

function showNotificacion() 
{

	if ( isset($_SESSION["notificacion"] ) )
	{
	
		if (  $_SESSION["notificacion"]["tipo"] == "success" ) 
		{
	
			echo '<div class="notifications alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		        	<h4><i class="icon fa fa-check"></i> Perfecto!</h4>
		        	- ' . $_SESSION["notificacion"]["contenido"] . '
		      	</div>';
	
		} else if (  $_SESSION["notificacion"]["tipo"] == "error" ) 
		{
	
			echo '<div class="notifications alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		        	<h4><i class="icon fa fa-ban"></i> Upps, algo salio mal.</h4>
		        	- ' . $_SESSION["notificacion"]["contenido"] . '
		      	</div>';
	
		} else if (  $_SESSION["notificacion"]["tipo"] == "info" ) 
		{
	
			echo '<div class="notifications alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		        	<h3><i class="icon fa fa-info"></i> Informacion.</h3>
		        	- ' . $_SESSION["notificacion"]["contenido"] . '
		      	</div>';
	
		}

	}
	unset( $_SESSION["notificacion"] );
}

function estatus( $val ) 
{
	if ( $val == 0 ) 
	{
		return "Inactivo";
	} elseif ( $val == 1 ) 
	{
		return "Activo";
	} elseif ( $val == 2 ) 
	{
		return "Bloqueado";
	}
}
function muestraToggle( $val ) 
{
	if ( $val == 0 ) 
	{
		return  "fa fa-toggle-off";
	} elseif ( $val == 1 ) 
	{
		return "fa fa-toggle-on";
	} elseif ( $val == 2 ) 
	{
		return "fa fa-lock";
	}
} 

function buscaNombre($db, $tabla, $codigo, $campo = "nombre" ) 
{
	$data = $db->select($tabla, $campo, ["id" => $codigo]);
	return $data[0];
}

function pr($str) 
{
	return print_r($str);
}

function operaciones_h_PorTipoUsuario(
										$guardar, 
										$db,
										$condicionCodOperacion = null, //Identificador
										$condicionDocIdentidad = null, //Cedula
										$condicionFechaDesde = null, //Fecha creacion desde 
										$condicionFechaHasta = null, //Fecha creacion hasta
										$condicionCliente = null, //Id cliente
										$condicionEstatus = null //Estatus de la operacion
									 ) 
{

	if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones_h WHERE 1 = 1 ";
	
	} else if ( ( $_SESSION["usuario"]["idTipoUsuario"] == 2 ) || ( $_SESSION["usuario"]["idTipoUsuario"] == 4 ) ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones_h WHERE idCliente = " . $_SESSION["usuario"]["idCliente"];
	
	} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 3 ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones_h WHERE idUsuario = " . $_SESSION["usuario"]["id"];
	
	} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 5 ) 
	{
	
		$queryPpal = "SELECT * FROM operaciones_h WHERE idCliente = " . $_SESSION["usuario"]["idCliente"] ." OR idVendedor = " . $_SESSION["usuario"]["id"];
	
	}
	$queryPpal .= $condicionCodOperacion . $condicionDocIdentidad . $condicionFechaDesde . $condicionFechaHasta . $condicionCliente . $condicionEstatus . " ORDER BY id DESC";
	//print_r($queryPpal);
	if ( $guardar ) 
	{
		$_SESSION["query"] = $queryPpal;
	}
	$datos = $db->query($queryPpal);
	return $datos; 

}

function operaciones_PorTipoUsuario(
										$db,
										$condicionCodOperacion = null, //Identificador
										$condicionDocIdentidad = null, //Cedula
										$condicionFechaDesde = null, //Fecha creacion desde 
										$condicionFechaHasta = null, //Fecha creacion hasta
										$condicionCliente = null, //Id cliente
										$condicionEstatus = null //Estatus de la operacion
									 ) 
{
	if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones WHERE 1 = 1 ";
	
	} else if ( ( $_SESSION["usuario"]["idTipoUsuario"] == 2 ) || ( $_SESSION["usuario"]["idTipoUsuario"] == 4 ) ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones WHERE idCliente = " . $_SESSION["usuario"]["idCliente"];
	
	} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 3 ) 
	{
		
		$queryPpal = "SELECT * FROM operaciones WHERE idUsuario = " . $_SESSION["usuario"]["id"];
	
	} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 5 ) 
	{
	
		$queryPpal = "SELECT * FROM operaciones WHERE idCliente = " . $_SESSION["usuario"]["idCliente"] ." OR idVendedor = " . $_SESSION["usuario"]["id"];
	
	}
	$queryPpal .= $condicionCodOperacion . $condicionDocIdentidad . $condicionFechaDesde . $condicionFechaHasta . $condicionCliente . $condicionEstatus . " ORDER BY id DESC";
	//print_r($queryPpal);
	$datos = $db->query($queryPpal);
	return $datos; 

}
