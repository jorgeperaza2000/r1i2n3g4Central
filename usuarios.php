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
                        Usuarios
                        <small>Visor de Usuarios</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Usuarios</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Usuarios Activos e Inactivos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <?php
                                    showNotificacion();

                                    $cmbTipoUsuario = isset($_POST["cmbTipoUsuario"])?$_POST["cmbTipoUsuario"]:"0";
                                    if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) {
                                        $datas = $db->select("tipo_usuario",["id", "nombre", "descripcion"], ["estatus" => 1]);
                                    } else {
                                        $datas = $db->select("tipo_usuario",["id", "nombre", "descripcion"], ["AND" => ["estatus" => 1, "mostrar" => 1]]);
                                    }
                                    ?>
                                    
                                    <form name="frmFiltroOperaciones" method="post" action="<?=$urlWebServiceClient;?>clienteUsuarios.php">
                                        <table data-role="table" id="movie-table" class="ui-responsive table-stroke" data-column-btn-text="Columnas">
                                            <thead>
                                                
                                                <tr>
                                                    <td style="vertical-align: middle !important;">
                                                        <label for="cmbTipoUsuario">Tipo de usuario:</label>
                                                    </td>
                                                    <td>
                                                        <select name="cmbTipoUsuario" id="cmbTipoUsuario" class="form-control">
                                                            <option value="0">-- SELECCIONE --</option>
                                                            <?php
                                                            foreach ( $datas as $data ) {
                                                            ?>
                                                                <option <?=($cmbTipoUsuario==$data["id"])?"selected":""?> value="<?=$data["id"]?>"><?=$data["nombre"]?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="vertical-align: middle !important;">
                                                        <label for="txtNombre">Usuario:</label>
                                                    </td>
                                                    <td style="vertical-align: middle !important;"></td>
                                                    <td>
                                                        <input type="text" name="txtNombre" value="" class="form-control">
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
                                                <th>Nombre</th>
                                                <th>Usuario</th>
                                                <th>Cliente</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //print_r($_SESSION["datos"]);
                                            if ( $_SESSION["usuario"]["idTipoUsuario"] == 1 ) {
                                                $datas = $_SESSION["datos"];
                                            } else {
                                                $datas = $_SESSION["datos"];
                                            }
                                            
											foreach ($datas as $data) {
                                            ?>
                                            <tr>
                                            	<td><b><?=$data->id?></b></td>
                                                <td><?=$data->nombre?></td>
                                                <td><?=$data->usuario?></td>
                                                <td><?=buscaNombre($db, "clientes", $data->idCliente)?></td>
                                                <td><?=buscaNombre($db, "tipo_usuario", $data->idTipoUsuario)?></td>
                                                <td><?=estatus($data->estatus)?></td>
                                                <td>
                                                	<a href="<?=$urlWebServiceClient?>clienteUsuarios.php?idUsuario=<?=$data->id?>&accion=6"><i class="fa fa-pencil-square-o"></i></a>
                                                	<a href="<?=$urlWebServiceClient?>clienteUsuarios.php?idUsuario=<?=$data->id?>&accion=4"><i class="<?=muestraToggle($data->estatus)?>"></i></a>
                                                	<a href="<?=$urlWebServiceClient?>clienteUsuarios.php?idUsuario=<?=$data->id?>&accion=3"><i class="fa fa-remove"></i></a>
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