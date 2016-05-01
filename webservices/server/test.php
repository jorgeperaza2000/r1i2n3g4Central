<?php

require_once "../../includes/db.php";

$codOperacion = $_POST["txtCodigoOperacion"];
$nombre = strtoupper($_POST["txtNombre"]);
$email = $_POST["txtEmailCliente"];
$numControl = strtoupper($_POST["txtNumeroFactura"]);
$monto = number_format($_POST["txtMontoFactura"], 2, ".", "");
$idVirtualPoint = $_POST["rdoVirtualPoint"];
$duracionOperaciones = $_SESSION["usuario"]["duracionOperaciones"];
$idUsuario = $_SESSION["usuario"]["id"];
$idCliente = $_SESSION["usuario"]["idCliente"];
$hash = "*E6CC90B878B948C35E92B003C792C46C58C4AF40";

            $datos = $db->insert("operaciones_h", [
                                        "codOperacion" => $codOperacion,
                                        "nombre" => strtoupper($nombre),
                                        "email" => $email,
                                        "numControl" => strtoupper($numControl),
                                        "monto" => $monto,
                                        "idVirtualPoint" => $idVirtualPoint,
                                        "duracionOperaciones" => $duracionOperaciones,
                                        "idUsuario" => $idUsuario,
                                        "idCliente" => $idCliente,
                                        "#fecCreacion" => "NOW()",
                                        "estatus" => "1"
                                        ]);
print_r($datos);
