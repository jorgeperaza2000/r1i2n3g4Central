			<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reportes Internos
                        <small>Comisiones totales</small>
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
                                    <h3 class="box-title">Comisiones totales</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                	<?php
                                	$meses = [1 => "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

                                	$txtFecDesde = isset($_POST["txtFecDesde"])?$_POST["txtFecDesde"]:"";
                                	$txtFecHasta = isset($_POST["txtFecHasta"])?$_POST["txtFecHasta"]:"";
                                	?>
									<form name="frmFiltroOperaciones" method="post" action="#">
										<input type="hidden" name="txtBuscar" value="1">
										<table data-role="table" id="movie-table" class="ui-responsive table-stroke" data-column-btn-text="Columnas">
											<thead>
												
												<tr>
													<td style="vertical-align: middle !important;">
														<label for="txtFecDesde">Fecha Desde</label>
														<input class="form-control" type="text" name="txtFecDesde" id="txtFecDesde" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$txtFecDesde;?>">
													</td>
													<td style="vertical-align: middle !important;">
														<label for="txtFecHasta">Fecha Hasta</label>
														<input class="form-control" type="text" name="txtFecHasta" id="txtFecHasta" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$txtFecHasta;?>">
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
									            <th align="center">Operaciones</th>
									            <th align="right">Venta Bs</th>
									            <th align="right">Facturado</th>
									            <th align="right">Ring Bs</th>
									            <th align="right">Vendedor Bs</th>
									            <th align="right">10%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ( count( $_POST ) == 0 ) {
								            ?>
								            	<tr>
	                                            	<td align="center" colspan="12">Seleccione algunos criterios de busqueda</td>
	                                            </tr>
								            <?php
											} else {

												$condicionFechaDesde = null;
												$condicionFechaHasta = null;

												if ( $txtFecDesde != "" ) 
												{
													$condicionFechaDesde = " AND a.fecCreacion >= '" . date("Y-m-d", strtotime($txtFecDesde)) . "' ";
												}
												if ( $txtFecHasta != "" ) 
												{
													$condicionFechaHasta = " AND a.fecCreacion <= '" . date("Y-m-d", strtotime($txtFecHasta)) . "' ";
												}
												
												$datas = $db->query("SELECT 
																			    SUM(a.monto) ventaBs,
																			    COUNT(a.monto) cantOperaciones,
																			    (SUM(a.monto) * a.tasa) / 100 facturado,
																			    (SUM(a.monto) * a.distribucionInterna) / 100 ringBs,
																			    (SUM(a.monto) * a.distribucionVendedor) / 100 VendedorBs,
																			    (((((SUM(a.monto) * a.tasa) / 100) - ((SUM(a.monto) * a.distribucionVendedor) / 100)) * 10) / 100) cucu
																			FROM
																			    operaciones_h a
																			WHERE
																			    1 = 1
																		" . $condicionFechaDesde . $condicionFechaHasta)->fetchAll();

												if ( count( $datas ) == 0 ) 
												{
												?>
													<tr>
		                                            	<td align="center" colspan="12">No se encontraron coincidencias</td>
		                                            </tr>
												<?php	
												} else {

													foreach ($datas as $data) 
													{
										        ?>
										                <tr>
									                		<td align="center"><?=$data["cantOperaciones"]?></td>
									                		<td align="right"><?=number_format($data["ventaBs"],2,',','.')?></td>
										                    <td align="right"><?=number_format($data["facturado"],2,',','.')?></td>
										                    <td align="right"><?=number_format($data["ringBs"],2,',','.')?></td>
										                    <td align="right"><?=number_format($data["VendedorBs"],2,',','.')?></td>
										                    <td align="right"><?=number_format($data["cucu"],2,',','.')?></td>
										                </tr>
	                                            <?php
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
