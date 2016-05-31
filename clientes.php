<script type="text/javascript">
    $(function() {
        $('#example1').dataTable({
        	"oLanguage": {
	           "sSearch": "Filtrar:",
	           "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
	           "oPaginate": {
	              "sPrevious": "Anterior",
	              "sNext": "Siguiente"
	           }	        
	        },
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": false,
            "bInfo": true,
            "bAutoWidth": true
        });
    });
</script>
			<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Clientes
                        <small>Visor de Clientes</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Clientes</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Clientes Activos e Inactivos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <?php
                                    $cboVendedor = isset($_POST["cboVendedor"])?$_POST["cboVendedor"]:"0";
                                    $cboEstatus = isset($_POST["cboEstatus"])?$_POST["cboEstatus"]:"1";
                                    $txtNombre = isset($_POST["txtNombre"])?$_POST["txtNombre"]:"";
                                    ?>
                                    
                                    <form name="frmFiltroOperaciones" method="post" action="home.php?s=<?=cClientes?>">
                                        <table data-role="table" id="movie-table" class="ui-responsive table-stroke" data-column-btn-text="Columnas">
                                            <thead>
                                                
                                                <tr>
                                                    <td style="vertical-align: middle !important;">
                                                        <label for="cboVendedor">Vendedor</label>
                                                    </td>
                                                    <td style="vertical-align: middle !important;">
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
                                                        <label for="cboEstatus">Estatus</label>
                                                    </td>
                                                    <td style="vertical-align: middle !important;">
                                                        <select name="cboEstatus" id="cboEstatus" class="form-control" >
                                                            <option <?=($cboEstatus=="%")?"selected":"";?> value="%">-- Todos --</option>
                                                            <option <?=($cboEstatus=="1")?"selected":"";?> value="1">Activos</option>
                                                            <option <?=($cboEstatus=="0")?"selected":"";?> value="0">Inactivos</option>
                                                        </select>
                                                    </td>
                                                    <td style="vertical-align: middle !important;">
                                                        <label for="txtNombre">Cliente:</label>
                                                    </td>
                                                    <td style="vertical-align: middle !important;"></td>
                                                    <td>
                                                        <input type="text" name="txtNombre" value="<?=$txtNombre;?>" class="form-control">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" id="btnSiguiente" type="submit">Buscar</button>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </form>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Cliente</th>
                                                <th>RIF</th>
                                                <th>Estado</th>
                                                <th>Teléfono</th>
                                                <th>Persona Contacto</th>
                                                <th>Tipo Cobranza</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $condicVendedor = "";
                                            $condicEstatus = "";
                                            $condicCliente = "";
                                            if ( $cboVendedor != "0" ) {
                                                $condicVendedor = " AND idVendedor = " . $cboVendedor;
                                            }
                                            if ( $cboEstatus != "%" ) {
                                                $condicEstatus = " AND estatus = " . $cboEstatus;
                                            }
                                            if ( $txtNombre != "" ) {
                                                $condicCliente = " AND nombre LIKE '%" . $txtNombre . "%'";
                                            }

                                            $datas = $db->query("SELECT * FROM clientes 
                                                                WHERE 
                                                                1 = 1 " . 
                                                                $condicVendedor . $condicEstatus . $condicCliente . " ORDER BY id DESC"
                                                                )->fetchAll();
											foreach ($datas as $data) {
                                            ?>
                                            <tr>
                                            	<td><b><?=$data["id"]?></b></td>
                                                <td><?=$data["nombre"]?></td>
                                                <td><?=$data["rif"]?></td>
                                                <td><?=buscaNombre($db, "localidades", $data["idEstado"])?></td>
                                                <td><?=$data["telefono"]?></td>
                                                <td><?=$data["personaContacto"]?></td>
                                                <td><?=buscaNombre($db, "tipo_cobranza", $data["idTipoCobranza"])?></td>
                                                <td><?=estatus($data["estatus"])?></td>
                                                <td align="right">
                                                    <?php
                                                    if ( $data["imagen"] != "" ){
                                                    ?>
                                                        <a href="<?=$data["imagen"]?>" target="_blank"><i class="fa fa-file-image-o"></i></a>
                                                    <?php    
                                                    }
                                                    ?>
                                                	<a href="home.php?s=<?=cEditClientes?>&id=<?=$data["id"]?>"><i class="fa fa-pencil-square-o"></i></a>
                                                	<a href="includes/functions.php?op=estatus&id=<?=$data["id"]?>&e=<?=$data["estatus"]?>&tabla=clientes"><i class="<?=muestraToggle($data["estatus"])?>"></i></a>
                                                	<a href="includes/functions.php?op=delete&id=<?=$data["id"]?>&tabla=clientes"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                            <?php
											}
											?>
                                        </tbody>
                                    </table>
                                    <div style="text-align:center; width: 100%; margin-top: 10px;"><button id="btnRefrescar" class="btn btn-primary btn-lg">Refrescar</button></div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
						</div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

    </body>
</html>