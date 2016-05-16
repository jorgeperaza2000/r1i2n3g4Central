			<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reportes Internos
                        <small>Comisiones por mes</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Reportes Internos</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Comisiones por mes</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                	<?php
                                	$anos = [2015 => "2015","2016","2017","2018","2019","2020"];
                                	$cboAno = isset($_POST["cboAno"])?$_POST["cboAno"]:date("Y");

                                	$meses = [1 => "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                                	$cboMes = isset($_POST["cboMes"])?$_POST["cboMes"]:date("m");
                                	$cboVendedor = isset($_POST["cboVendedor"])?$_POST["cboVendedor"]:"0";
                                	$cboCliente = isset($_POST["cboCliente"])?$_POST["cboCliente"]:"0";
                                	?>
									<form name="frmFiltroOperaciones" method="post" action="#">
										<input type="hidden" name="txtBuscar" value="1">
										<table data-role="table" id="movie-table" class="ui-responsive table-stroke" data-column-btn-text="Columnas">
											<thead>
												
												<tr>
													<td style="vertical-align: middle !important;">
														<label for="cboAno">Año</label>
														<select name="cboAno" id="cboAno" class="form-control" >
															<?php
															foreach ($anos as $ano) {
															?>
																<option <?=($cboAno == $ano)?"selected":"";?> value="<?=$ano?>"><?=$anos[$ano]?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td style="vertical-align: middle !important;">
														<label for="cboMes">Mes</label>
														<select name="cboMes" id="cboMes" class="form-control" >
															<?php
															foreach ($meses as $nMes => $mes) {
															?>
																<option <?=($cboMes == $nMes)?"selected":"";?> value="<?=$nMes?>"><?=$meses[$nMes]?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td style="vertical-align: middle !important;">
														<label for="cboVendedor">Vendedor</label>
														<select name="cboVendedor" id="cboVendedor" class="form-control" >
															<option <?=($cboVendedor==0)?"selected":"";?> value="0">-- Todos --</option>
															<?php
															if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) { //PUEDE VER LAS OPERACIONES
																$combos = $db->select("usuarios", "*", ["AND" => ["estatus" => 1, "idTipoUsuario" => 5]]);
															} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 5 ) { //PUEDE VER LAS OPERACIONES DE TODOS SUS CLIENTES
																$combos = $db->select("usuarios","*",["AND" => ["estatus" => 1, "id" => $_SESSION["usuario"]["id"]]]);
															} 
															foreach ($combos as $combo) {
															?>
																<option <?=($cboVendedor == $combo["id"])?"selected":"";?> value="<?=$combo["id"]?>"><?=$combo["nombre"]?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td style="vertical-align: middle !important;">
														<label for="cboCliente">Cliente</label>
														<select name="cboCliente" id="cboCliente" class="form-control" >
															<option <?=($cboCliente==0)?"selected":"";?> value="0">-- Todos --</option>
															<?php
															if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) { //PUEDE VER LAS OPERACIONES
																$combos = $db->select("clientes", "*", ["estatus" => 1]);
															} else if ( $_SESSION["usuario"]["idTipoUsuario"] == 5 ) { //PUEDE VER LAS OPERACIONES DE TODOS SUS CLIENTES
																$combos = $db->select("clientes","*",["AND" => ["estatus" => 1, "idVendedor" => $_SESSION["usuario"]["id"]]]);
															} else { //SOLO PUEDE VER SUS OPERACIONES
																$combos = $db->select("clientes","*", ["AND" => ["estatus" => 1, "id" => $_SESSION["usuario"]["idCliente"]]]);
															}
															foreach ($combos as $combo) {
															?>
																<option <?=($cboCliente == $combo["id"])?"selected":"";?> value="<?=$combo["id"]?>"><?=$combo["nombre"]?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td style="vertical-align: middle !important;"></td>
												</tr>
												<tr>
													<td colspan="4">
														<button class="btn btn-primary" id="btnSiguiente" type="submit">Buscar</button>
													</td>
												</tr>
											</thead>
										</table>
									</form>
									<div class="botonera">
										<a target="_blank" href="reportegeneralexcel.php" title="Imprimir"><i class="fa fa-file-excel-o fa-2x"></i></a>
										<a target="_blank" href="reportegeneraldet.php" title="Imprimir"><i class="fa fa-print fa-2x"></i></a>
									</div>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
									            <th>Cliente</th>
									            <th>Vendedor</th>
									            <th align="center">Operaciones</th>
									            <th align="right">Venta Bs</th>
									            <th align="right">Tasa %</th>
									            <th align="right">Facturado</th>
									            <th align="right">Ring %</th>
									            <th align="right">Ring Bs</th>
									            <th align="right">Vend. %</th>
									            <th align="right">Vendedor Bs</th>
									            <th align="right">10%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ( count( $_POST ) == 0 ) {
								            ?>
								            	<tr>
	                                            	<td align="center" colspan="11">Seleccione algunos criterios de busqueda</td>
	                                            </tr>
								            <?php
											} else {
												$condicionAno = null;
												$condicionMes = null;
												$condicionCboCliente = null;
												$condicionCboVendedor = null;

												$condicionAno = " YEAR(a.fecCreacion) = '" . $cboAno . "' ";
												$condicionMes = " AND MONTH(a.fecCreacion) = '" . $cboMes . "' ";
												
												if ( $cboCliente != 0 ) 
												{
													$condicionCboCliente = " AND a.idCliente = " . $cboCliente . " ";
												}
												if ( $cboVendedor != 0 ) 
												{
													$condicionCboVendedor = " AND a.idVendedor = " . $cboVendedor . " ";
												}

												$datas = $db->query("SELECT a.idCliente, b.nombre cliente, c.nombre vendedor, COUNT(a.monto) cantOperaciones, SUM(a.monto) ventaBs, a.tasa, (SUM(a.monto)*a.tasa)/100 facturado, 
																		a.distribucionInterna, (SUM(a.monto)*a.distribucionInterna)/100 ringBs, 
																		a.distribucionVendedor, (SUM(a.monto)*a.distribucionVendedor)/100 VendedorBs, 
																		(((((SUM(a.monto)*a.tasa)/100) - ((SUM(a.monto)*a.distribucionVendedor)/100))*10)/100) cucu FROM operaciones_h a, clientes b, usuarios c 
																	WHERE 
																	a.idCliente = b.id AND a.idVendedor = c.id AND
																	" . $condicionAno . $condicionMes . $condicionCboCliente . $condicionCboVendedor . " 
																	GROUP BY a.idCliente WITH ROLLUP;")->fetchAll();

												if ( count( $datas ) == 0 ) 
												{
												?>
													<tr>
		                                            	<td align="center" colspan="11">No se encontraron coincidencias</td>
		                                            </tr>
												<?php	
												} else {
													foreach ($datas as $data) 
													{
												       	if ( $data["idCliente"] == null ) {
										        ?>
											                <tr>
											                	<td style="background-color: #c2c2c2 !important;" colspan="2" align="right">Total Clientes</td>
											                	<td style="background-color: #c2c2c2 !important;" align="center"><?=$data["cantOperaciones"]?></td>
											                	<td style="background-color: #c2c2c2 !important;" align="right"><?=number_format($data["ventaBs"],2,',','.')?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=$data["tasa"] . " %"?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=number_format($data["facturado"],2,',','.')?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=$data["distribucionInterna"] . " %"?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=number_format($data["ringBs"],2,',','.')?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=$data["distribucionVendedor"] . " %"?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=number_format($data["VendedorBs"],2,',','.')?></td>
											                    <td style="background-color: #c2c2c2 !important;" align="right"><?=number_format($data["cucu"],2,',','.')?></td>
											                </tr>
	                                            <?php
	                                            		} else {
	                                            ?>
	                                            			<tr>
											                	<td><?=$data["cliente"]?></td>
											                	<td><?=$data["vendedor"]?></td>
											                	<td align="center"><?=$data["cantOperaciones"]?></td>
											                	<td align="right"><?=number_format($data["ventaBs"],2,',','.')?></td>
											                    <td align="right"><?=$data["tasa"] . " %"?></td>
											                    <td align="right"><?=number_format($data["facturado"],2,',','.')?></td>
											                    <td align="right"><?=$data["distribucionInterna"] . " %"?></td>
											                    <td align="right"><?=number_format($data["ringBs"],2,',','.')?></td>
											                    <td align="right"><?=$data["distribucionVendedor"] . " %"?></td>
											                    <td align="right"><?=number_format($data["VendedorBs"],2,',','.')?></td>
											                    <td align="right"><?=number_format($data["cucu"],2,',','.')?></td>
											                </tr>
	                                            <?php
	                                            		}
													}
												}
											}
											?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
						</div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

    </body>
</html>

<script>
	$(document).ready(function(){
		$("#txtFecDesde").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
		$("#txtFecHasta").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
	});
</script>
