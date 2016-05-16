			<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reportes
                        <small>General</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Reportes</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Reporte General</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                	<?php
                                	$txtFecDesde = isset($_POST["txtFecDesde"])?$_POST["txtFecDesde"]:"";
                                	$txtFecHasta = isset($_POST["txtFecHasta"])?$_POST["txtFecHasta"]:"";
                                	$cboEstatus = isset($_POST["cboEstatus"])?$_POST["cboEstatus"]:"0";
                                	$cboCliente = isset($_POST["cboCliente"])?$_POST["cboCliente"]:"0";
                                	?>
									<form name="frmFiltroOperaciones" method="post" action="#">
										<input type="hidden" name="txtBuscar" value="1">
										<table data-role="table" id="movie-table" class="ui-responsive table-stroke" data-column-btn-text="Columnas">
											<thead>
												<tr>
													<td style="vertical-align: middle !important;"><label for="txtFecDesde">Fecha Desde</label><input class="form-control" type="text" name="txtFecDesde" id="txtFecDesde" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$txtFecDesde;?>"></td>
													<td style="vertical-align: middle !important;"></td>
													<td style="vertical-align: middle !important;"><label for="txtFecHasta">Fecha Hasta</label><input class="form-control" type="text" name="txtFecHasta" id="txtFecHasta" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$txtFecHasta;?>"></td>
													<td style="vertical-align: middle !important;"></td>
												</tr>
												<tr>
													<td style="vertical-align: middle !important;">
														<label for="cboEstatus">Estatus</label>
														<select name="cboEstatus" id="cboEstatus" class="form-control" >
															<option <?=($cboEstatus==0)?"selected":"";?> value="0">-- Todas --</option>
															<option <?=($cboEstatus==4)?"selected":"";?> value="4">No Autorizada</option>
															<option <?=($cboEstatus==5)?"selected":"";?> value="5">Autorizada</option>
														</select>
													</td>
													<td style="vertical-align: middle !important;"></td>
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
                                                <th>Id</th>
									            <th>Cliente</th>
									            <th>Codigo</th>
									            <th>Factura</th>
									            <th>Fecha</th>
									            <th>Tarjetahabiente</th>
									            <th>Num. Tarjeta</th>
									            <th>Fecha Oper.</th>
									            <th>Estatus</th>
									            <th>Autorización</th>
									            <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalAprobado = 0;
                                            if ( count( $_POST ) == 0 ) {
								            ?>
								            	<tr>
	                                            	<td align="center" colspan="11">Seleccione algunos criterios de busqueda</td>
	                                            </tr>
								            <?php
											} else {
												$condicFechaDesde = null;
												$condicFechaHasta = null;
												$condicionCboEstatus = null;
												$condicionCboCliente = null;

												if ( $cboEstatus != 0 ) 
												{
													$condicionCboEstatus = " AND estatus = " . $cboEstatus . " ";
												} else 
												{
													$condicionCboEstatus = " AND estatus NOT IN (1,2,3) ";
												}
												if ( $cboCliente != 0 ) 
												{
													$condicionCboCliente = " AND idCliente = " . $cboCliente . " ";
												}
												$fechaDesde = ($_POST["txtFecDesde"] != "")?date("Y-m-d", strtotime($_POST["txtFecDesde"])):"";
												$fechaHasta = ($_POST["txtFecHasta"] != "")?date("Y-m-d", strtotime($_POST["txtFecHasta"])):"";

												if ( $fechaDesde != "" ) 
												{
													$condicFechaDesde = " AND DATE_FORMAT(fecCreacion,'%Y-%m-%d') >= '" . $fechaDesde . "' ";
												}
												if ( $fechaHasta != "" ) 
												{
													$condicFechaHasta = " AND DATE_FORMAT(fecCreacion,'%Y-%m-%d') <= '" . $fechaHasta . "' ";
												}

												$datas = operaciones_h_PorTipoUsuario(true, $db, null, null, $condicFechaDesde, $condicFechaHasta, $condicionCboCliente, $condicionCboEstatus);

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
														
														if ( $data["estatus"] === 'Autorizada' ) 
														{
															$totalAprobado = $totalAprobado + $data["monto"];
														}
										        ?>
										                <tr>
										                	<td><?=$data["id"]?></td>
										                	<td><?=$data["idCliente"]?></td>
										                	<td><b><?=$data["codOperacion"]?></b></td>
										                    <td><?=$data["numControl"]?></td>
										                    <td><?=date("d-m-Y h:i:s", strtotime($data["fecCreacion"]))?></td>
										                    <td><?=$data["nombre"]?><p><?=$data["docIdentidad"]?></p></td>
										                    <td><?=$data["numTarjeta"]?></td>
										                    <td><?=date("d-m-Y h:i:s", strtotime($data["fecOperacion"]))?></td>
										                    <td><?=$data["estatus"]?></td>
										                    <td><?=$data["numAutorizacion"]?></td>
										                    <td align="right"><?=$data["monto"]?></td>
										                </tr>
	                                            <?php
													}
												}
											}
											?>
												<tr>
	                                            	<td colspan="10" align="right">Total Autorizadas:</td>
	                                            	<td align="right"><?=number_format($totalAprobado,2,',','.')?></td>
	                                            </tr>
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
