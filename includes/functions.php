<?php
session_start();
include "db.php";

switch ( $_GET["op"] ) {
		
	case "login":
		
		$data = $db->query("SELECT 
								u.*,
								c.nombre cliente,
								c.duracionOperaciones
							FROM 
								usuarios u, clientes c 
							WHERE 
								u.idCliente = c.id AND 
							    u.usuario = '" . $_POST["txtUserName"] . "' AND 
							    u.clave = '" . $_POST["txtPassword"] . "' 
							LIMIT 1")->fetchAll();
		if ( $data ) {
				
			if ( $data[0]["estatus"] == 0 ) { //El Usuario se encuentra inactivo
				header("location: ../index.php?e=2");
				die(); 
			}
			$_SESSION["usuario"]["id"] = $data[0]["id"];
			$_SESSION["usuario"]["nombre"] = $data[0]["nombre"];
			$_SESSION["usuario"]["usuario"] = $data[0]["usuario"];
			$_SESSION["usuario"]["idTipoUsuario"] = $data[0]["idTipoUsuario"];
			$_SESSION["usuario"]["idCliente"] = $data[0]["idCliente"];
			$_SESSION["usuario"]["cliente"] = $data[0]["cliente"];
			$_SESSION["usuario"]["duracionOperaciones"] = $data[0]["duracionOperaciones"];
			if ( $data[0]["cambioClave"] == 1) {
				header("location: ../home.php?s=" . cPrincipal);
			} else {
				header("location: ../home.php?s=" . cCambioClave);
			}

		} else {
				
			header("location: ../index.php?e=1");
			
		}
		/*foreach ( $datas as $data ) {
			echo $data["nombre"] . " - " . $data["id"] . "<br/>";
		}*/
	break;

	case "olvido":

		include_once "recaptchalib.php";
		include_once "lib/swift_required.php";

		$secret = "6LcZGSETAAAAAGPIJoP6bnnIO0hrtPzx3L42P4C1";
 
		// respuesta vacía
		$response = null;
		 
		// comprueba la clave secreta
		$reCaptcha = new ReCaptcha($secret);

		if ( $_POST["g-recaptcha-response"] ) {
			$response = $reCaptcha->verifyResponse(
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["g-recaptcha-response"]
		    );
		}

		if ($response != null && $response->success) { //SE ENVIA EL CORREO ELECTRONICO

			$transport = Swift_SmtpTransport::newInstance('host194.hostmonster.com', 465, 'ssl')
			                     ->setUsername('ivrpg@oriantech.com')
			                         ->setPassword('ivrpg.2021');

			$smartCode = rand(100000, 999999);
			$dato = $db->update("usuarios", ["codigo" => $smartCode], ["email" => $_POST["txtEmail"]]);

			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);

			$cadenaEmail = "Ha perdido su contraseña de pagaconring.com, lo sentimos.<br><br>Pero no se preocupe! mediante el siguiente codigo podra restablecerla";
			$email = base64_encode($_POST["txtEmail"]);
			//$cadenaEmail .= "<br><br>http://app.pagaconring.com/r1i2n3g4Central/pass_reset.php?email=" . $email;
			$cadenaEmail .= "<br><br><h1 style:'font-size=18px;'>$smartCode</h1>";
			//Create a message
			$message = Swift_Message::newInstance('[pagaconring.com] Por favor restablezca su clave')
			                   ->setFrom(array('ivrpg@oriantech.com' => 'PagaConRing.com'))
			                   ->setTo(strtolower($_POST["txtEmail"]))
			                   ->setContentType("text/html")
			                   ->setBody($cadenaEmail);

			//Send the message
			$result = $mailer->send($message);
			header("location: ../pass_reset.php");
        	
     	} else {
     		header("location: ../olvido.php");
     	}
	break;
	
	case "pass_reset":

		if ( $_POST["txtClave"] == $_POST["txtReClave"] ) {

			$dato = $db->update("usuarios", ["#clave" => "PASSWORD('" . $_POST["txtClave"] . "')"], ["codigo" => $_POST["txtCodigo"]]);
			setNotificacion( "Su clave fue actualizada con exito.", "success");
			header("location: ../index.php");

		} else {

			setNotificacion( "Sus contraseñas no coinciden.", "error");
			header("location: ../pass_reset.php");

		}

	break;

	case "nuevaVenta":
		/*$last_operacion_id = $db->insert("operaciones_h", [
										"codOperacion" => $_POST["txtCodigoOperacion"],
										"nombre" => strtoupper($_POST["txtNombre"]),
										"email" => $_POST["txtEmailCliente"],
										"numControl" => strtoupper($_POST["txtNumeroFactura"]),
										"monto" => number_format($_POST["txtMontoFactura"], 2, ".", ""),
										"idVirtualPoint" => $_POST["rdoVirtualPoint"],
										"duracionOperaciones" => $_SESSION["usuario"]["duracionOperaciones"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"idCliente" => $_SESSION["usuario"]["idCliente"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1",
										]);
		header("location: ../home.php?s" . cPrincipal);*/
	break;
	case "nuevoCliente":
		$txtFecActivacion = ( $_POST["txtFecActivacion"] == "" )?null:date("Y-m-d", strtotime($_POST["txtFecActivacion"]));
		
		$last_operacion_id = $db->insert("clientes", [
										"nombre" => $_POST["txtNombre"],
										"rif" => $_POST["txtRif"],
										"idEstado" => $_POST["cmbEstado"],
										"idMunicipio" => $_POST["cmbMunicipio"],
										"direccion" => $_POST["txtDireccion"],
										"telefono" => $_POST["txtTelefono"],
										"personaContacto" => $_POST["txtPersonaContacto"],
										"idVendedor" => $_POST["cmbVendedor"],
										"idTipoCobranza" => $_POST["cmbTipoCobranza"],
										"tasa" => $_POST["txtTasa"],
										"distribucionInterna" => $_POST["txtDistribucionInterna"],
										"distribucionVendedor" => $_POST["txtDistribucionVendedor"],
										"intervalo" => $_POST["txtIntervalo"],
										"montoAfiliacion" => $_POST["txtMontoAfiliacion"],
										"duracionOperaciones" => $_POST["txtDuracionOperaciones"],
										"numeroUsuarios" => $_POST["txtNumeroUsuarios"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"fecActivacion" => $txtFecActivacion,
										"estatus" => "1",
										]);
		if ( $_FILES['txtContrato']['name'] != "" ) 
		{
			$dir_subida = '../img/clientFiles/';
			$dir_db = 'img/clientFiles/';
			$fichero_subido = $dir_subida . $last_operacion_id . "." . end( explode('.', $_FILES['txtContrato']['name']) );
			$fichero_subido_db = $dir_db . $last_operacion_id . "." . end( explode('.', $_FILES['txtContrato']['name']) );

			if ( file_exists( $fichero_subido ) ) 
			{
				unlink($fichero_subido);
			}
			move_uploaded_file($_FILES['txtContrato']['tmp_name'], $fichero_subido);

			$last_operacion_id = $db->update("clientes", [
											"imagen" => $fichero_subido_db,
											],
											["id" => $last_operacion_id ]);
		}

		header("location: ../home.php?s=" . cClientes);
	break;
	case "editCliente":
		$txtFecActivacion = ( $_POST["txtFecActivacion"] == "" )?null:date("Y-m-d", strtotime($_POST["txtFecActivacion"]));
		
		if ( $_FILES['txtContrato']['name'] != "" ) 
		{
			$dir_subida = '../img/clientFiles/';
			$dir_db = 'img/clientFiles/';
			$fichero_subido = $dir_subida . $_GET["id"] . "." . end( explode('.', $_FILES['txtContrato']['name']) );
			$fichero_subido_db = $dir_db . $_GET["id"] . "." . end( explode('.', $_FILES['txtContrato']['name']) );

			if ( file_exists( $fichero_subido ) ) 
			{
				unlink($fichero_subido);
			} 
			move_uploaded_file($_FILES['txtContrato']['tmp_name'], $fichero_subido);
			$last_operacion_id = $db->update("clientes", [
											"imagen" => $fichero_subido_db,
											],
											["id" => $_GET["id"] ]);
		}
		$last_operacion_id = $db->update("clientes", [
										"nombre" => $_POST["txtNombre"],
										"rif" => $_POST["txtRif"],
										"idEstado" => $_POST["cmbEstado"],
										"idMunicipio" => $_POST["cmbMunicipio"],
										"direccion" => $_POST["txtDireccion"],
										"telefono" => $_POST["txtTelefono"],
										"personaContacto" => $_POST["txtPersonaContacto"],
										"duracionOperaciones" => $_POST["txtDuracionOperaciones"],
										"numeroUsuarios" => $_POST["txtNumeroUsuarios"],
										"idVendedor" => $_POST["cmbVendedor"],
										"idTipoCobranza" => $_POST["cmbTipoCobranza"],
										"tasa" => $_POST["txtTasa"],
										"distribucionInterna" => $_POST["txtDistribucionInterna"],
										"distribucionVendedor" => $_POST["txtDistribucionVendedor"],
										"montoAfiliacion" => $_POST["txtMontoAfiliacion"],
										"intervalo" => $_POST["txtIntervalo"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"fecActivacion" => $txtFecActivacion,
										"estatus" => "1",
										],
										["id" => $_GET["id"] ]);
		header("location: ../home.php?s=" . cClientes);
	break;
	case "delCliente":
		$last_operacion_id = $db->delete("clientes", [ "id" =>  $_GET["id"] ]);
		header("location: ../home.php?s=" . cClientes);
	break;
	case "nuevoUsuario":
		/*$last_operacion_id = $db->insert("usuarios", [
										"nombre" => $_POST["txtNombre"],
										"usuario" => $_POST["txtUsuario"],
										"clave" => $_POST["txtClave"],
										"extension" => $_POST["txtExtension"],
										"idTipoUsuario" => $_POST["cmbTipoUsuario"],
										"idCliente" => $_POST["cmbCliente"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1",
										"cambioClave" => "1",
										]);
		header("location: ../home.php?s=" . cUsuarios);*/
	break;
	case "editUsuario":
		/*$last_operacion_id = $db->update("usuarios", [
										"nombre" => $_POST["txtNombre"],
										"usuario" => $_POST["txtUsuario"],
										"clave" => $_POST["txtClave"],
										"extension" => $_POST["txtExtension"],
										"idTipoUsuario" => $_POST["cmbTipoUsuario"],
										"idCliente" => $_POST["cmbCliente"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1",
										"cambioClave" => "1",
										],
										["id" => $_GET["id"] ]);
		header("location: ../home.php?s=" . cUsuarios);*/
	break;
	case "delUsuario":
		/*$last_operacion_id = $db->delete("usuarios", [ "id" =>  $_GET["id"] ]);
		header("location: ../home.php?s=" . cUsuarios);*/
	break;
	case "nuevoBanco":
		$last_operacion_id = $db->insert("bancos", [
										"nombre" => $_POST["txtNombre"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1",
										]);
		header("location: ../home.php?s=" . cBancos);
	break;
	case "editBanco":
		$last_operacion_id = $db->update("bancos", [
										"nombre" => $_POST["txtNombre"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1",
										],
										["id" => $_GET["id"] ]);
		header("location: ../home.php?s=" . cBancos);
	break;
	case "delBanco":
		$last_operacion_id = $db->delete("bancos", [ "id" =>  $_GET["id"] ]);
		header("location: ../home.php?s=" . cBancos);
	break;
	case "nuevoVirtualPoint":
		$URL = "https://e-payment.megasoft.com.ve/payment/action/procesar-compra?cod_afiliacion=" . $_POST["txtCodAfiliacion"] . "&transcode=" . $_POST["txtTranscode"];
		$last_operacion_id = $db->insert("virtual_points", [
										"descripcion" => $_POST["txtDescripcion"],
										"idCliente" => $_POST["cmbCliente"],
										"codAfiliacion" => $_POST["txtCodAfiliacion"],
										"transcode" => $_POST["txtTranscode"],
										"url" => $URL,
										"idBanco" => $_POST["cmbBanco"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1"
										]);
		header("location: ../home.php?s=" . cVirtualPoints);
	break;
	case "editVirtualPoint":
		$URL = "https://e-payment.megasoft.com.ve/payment/action/procesar-compra?cod_afiliacion=" . $_POST["txtCodAfiliacion"] . "&transcode=" . $_POST["txtTranscode"];
		$last_operacion_id = $db->update("virtual_points", [
										"descripcion" => $_POST["txtDescripcion"],
										"idCliente" => $_POST["cmbCliente"],
										"codAfiliacion" => $_POST["txtCodAfiliacion"],
										"transcode" => $_POST["txtTranscode"],
										"url" => $URL,
										"idBanco" => $_POST["cmbBanco"],
										"idUsuario" => $_SESSION["usuario"]["id"],
										"#fecCreacion" => "NOW()",
										"estatus" => "1"
										],
										["id" => $_GET["id"] ]);
		header("location: ../home.php?s=" . cVirtualPoints);
	break;
	case "delete":
		$a = split("_", $_GET["tabla"]);
		$b = ucfirst($a[0]) . ucfirst($a[1]);
		$redirigir = c . $b;
		$last_operacion_id = $db->delete($_GET["tabla"], [ "id" =>  $_GET["id"] ]);
		header("location: ../home.php?s=" . constant($redirigir));
	break;
	
	
	
	case "estatus":
		$estatus = ( $_GET["e"] == 1 )?0:1;
		$a = split("_", $_GET["tabla"]);
		$b = ucfirst($a[0]) . ucfirst($a[1]);
		$redirigir = c . $b;
		$last_operacion_id = $db->update($_GET["tabla"], ["estatus" => $estatus], [ "id" =>  $_GET["id"] ]);
		header("location: ../home.php?s=" . constant($redirigir));
	break;
	
	case "cargaComboCiudad":
		$salida = "";
		$idEstado = $_POST["idEstado"];
		$datas = $db->select("localidades",["id", "nombre"], ["AND" => ["tabla" => "municipio", "localidad_id" => $idEstado], "ORDER" => "nombre ASC"]);
		foreach ( $datas as $data ) {
        	$salida .= '<option value="' . $data["id"] . '">' . $data["nombre"] . '</option>';
		}
		echo $salida;
	break;

	case "cargaComboClientesPorTipo":
		$salida = "";
		$idTipoUsuario = $_POST["idTipoUsuario"];
		if ( $idTipoUsuario == 1 ) {
			$datas = $db->select("clientes",["id", "nombre"], ["estatus" => 1]);
		}else if ( $idTipoUsuario == 5 ) {
			$datas = $db->select("clientes",["id", "nombre"], ["AND" => ["estatus" => 1, "id" => 1]]);
		} else {
			$datas = $db->select("clientes",["id", "nombre"], ["AND" => ["estatus" => 1, "id" => $_SESSION["usuario"]["idCliente"]]]);
		}
		print_r($datas);
		foreach ( $datas as $data ) {
        	$salida .= '<option value="' . $data["id"] . '">' . $data["nombre"] . '</option>';
		}
		echo $salida;
	break;
	
	case "enviaOperacionesH":
		$datos = $db->query("call st_operaciones_historial(" . base64_decode($_GET["id"]) . ")");
		header("location: ../home.php?s=" . cPrincipal);
	break;
	
	case "duplicaOperacion":
		$datos = $db->query("call st_operaciones_duplica(" . base64_decode($_GET["id"]) . ")");
		header("location: ../home.php?s=" . cPrincipal);
	break;
}
