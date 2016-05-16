            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Agregar Clientes
                        <small>Clientes</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Agregar Clientes</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6" style="float:none !important; margin: auto;">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Datos del Cliente</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form" action="includes/functions.php?op=nuevoCliente" id="frmEditarCliente" method="post" enctype="multipart/form-data" >
                                    <div class="box-body">
                                        
                                        <div class="form-group">
                                        	<label for="txtNombre">Nombre del Cliente</label>
	                                        <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre">
	                                    </div>                                     
                                        <div class="form-group">
	                                        <label for="txtRif">RIF</label>
	                                        <input type="text" name="txtRif" id="txtRif" class="form-control" placeholder="RIF">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtRif">Contrato</label>
	                                        <input type="file" name="txtContrato" id="txtContrato">
	                                        <p class="help-block">Por favor seleccione el contrato del cliente</p>
	                                    </div>
	                                    <?php
	                                    $datas = $db->select("localidades",["id", "nombre"], ["tabla" => "estado", "ORDER" => "nombre ASC"]);
	                                    ?>
	                                    <label for="cmbEstado">Estado</label>
	                                    <select name="cmbEstado" id="cmbEstado" class="form-control">
	                                    	<option value="0">-- SELECCIONE --</option>
	                                        <?php
	                                        foreach ( $datas as $data ) {
	                                        ?>
	                                        	<option value="<?=$data["id"]?>"><?=$data["nombre"]?></option>
	                                        <?php
											}
	                                        ?>
	                                    </select>
	                                    <label for="cmbMunicipio">Municipio</label>
	                                    <select name="cmbMunicipio" id="cmbMunicipio" class="form-control">
	                                        <option value="0">-- SELECCIONE --</option>
	                                        
	                                    </select>
                                        <div class="form-group">
											<label for="txtDireccion">Dirección</label>
	                                        <textarea class="form-control" name="txtDireccion" id="txtDireccion" rows="3" placeholder="Dirección..."></textarea>
	                                    </div>
                                        <div class="form-group">
	                                        <label for="txtTelefono">Teléfono</label>
	                                        <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Teléfono">
	                                    </div>
                                        <div class="form-group">
	                                        <label for="txtPersonaContacto">Persona Contacto</label>
	                                        <input type="text" name="txtPersonaContacto" id="txtPersonaContacto" class="form-control" placeholder="Persona Contacto">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtDuracionOperaciones">Duración de Operaciones</label>
	                                        <input type="text" name="txtDuracionOperaciones" id="txtDuracionOperaciones" class="form-control" placeholder="Duración en Horas de las Operaciones">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtNumeroUsuarios">Numero de Usuarios</label>
	                                        <input type="text" name="txtNumeroUsuarios" id="txtNumeroUsuarios" class="form-control" placeholder="Maximo de usuarios permitidos">
	                                    </div>
	                                    <?php
	                                    $datas = $db->select("usuarios",["id", "nombre"], ["AND" => ["estatus" => "1", "idTipoUsuario" => 5], "ORDER" => "nombre ASC"]);
	                                    ?>
	                                    <label for="cmbVendedor">Vendedor</label>
	                                    <select name="cmbVendedor" id="cmbVendedor" class="form-control">
	                                        <option value="0">-- SELECCIONE --</option>
	                                        <?php
	         			                    foreach ( $datas as $data ) {
	                                        ?>
	                                        	<option value="<?=$data["id"]?>"><?=$data["nombre"]?></option>
	                                        <?php
											}
	                                        ?>
	                                    </select>
	                                    <?php
	                                    $datas = $db->select("tipo_cobranza",["id", "nombre"], ["estatus" => "1", "ORDER" => "nombre ASC"]);
	                                    ?>
	                                    <label for="cmbTipoCobranza">Tipo de Cobranza</label>
	                                    <select name="cmbTipoCobranza" id="cmbTipoCobranza" class="form-control">
	                                        <option value="0">-- SELECCIONE --</option>
	                                        <?php
	         			                    foreach ( $datas as $data ) {
	                                        ?>
	                                        	<option value="<?=$data["id"]?>"><?=$data["nombre"]?></option>
	                                        <?php
											}
	                                        ?>
	                                    </select>
	                                    <div class="form-group">
	                                        <label for="txtTasa">Tasa %</label>
	                                        <input type="text" name="txtTasa" value="" id="txtTasa" class="form-control" placeholder="Tasa segun Tipo de Cobranza">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtDistribucionOriantech">Distribucion %</label>
	                                        <input type="text" name="txtDistribucionInterna" value="" id="txtDistribucionInterna" class="form-control" placeholder="Distribucion Interna">
	                                        <input type="text" name="txtDistribucionVendedor" value="" id="txtDistribucionVendedor" class="form-control" placeholder="Distribucion Vendedor">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtIntervalo">Intervalo de cobro (Meses)</label>
	                                        <input type="text" name="txtIntervalo" value="" id="txtIntervalo" class="form-control" placeholder="Intervalo de cobro expresado en Meses.">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtFecActivacion">Fecha Activacion (Ciclo de Facturación)</label>
	                                        <input type="text" name="txtFecActivacion" id="txtFecActivacion" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="Fecha en que el cliente entra en producción.">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="txtMontoAfiliacion">Monto de Afiliación</label>
	                                        <input type="text" name="txtMontoAfiliacion" id="txtMontoAfiliacion" class="form-control" placeholder="Monto de afiliacion del servicio">
	                                    </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" id="btnSiguiente" class="btn btn-primary">Agregar</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	$("#txtFecActivacion").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

	$("#txtTasa")
		.focusout(function(){
		
			//EJEMPLO: t=tasa, do=distrubucion orianech, dv=distribucion vendedor d=distrubucion para mayores a 1

			var $tasaDistribucionInterna  = 0.8; //Tasa de distrubucion en base a 1
			var $tasaDistribucionVendedor   = 0.2; //Tasa de distrubucion en base a 1
			var $tasaDistribucion           = 0.5; //Tasa generica para valores mayores que 1 

			var $distInterna;
			var $distVendedor;

			if ( $("#txtTasa").val() <= 1 ) 
			{
				$distInterna  = $("#txtTasa").val() * $tasaDistribucionInterna;
				$distVendedor   = $("#txtTasa").val() * $tasaDistribucionVendedor;

				$("#txtDistribucionInterna").val($distInterna.toFixed(2));
				$("#txtDistribucionVendedor").val($distVendedor.toFixed(2));
			} else if ( $("#txtTasa").val() > 1 ) 
			{

				$distInterna  = $tasaDistribucionInterna;
				$distVendedor   = $tasaDistribucionVendedor;

				$distInterna  = $distInterna + ( $("#txtTasa").val() - 1 ) * $tasaDistribucion;
				$distVendedor   = $distVendedor + ( $("#txtTasa").val() - 1 ) * $tasaDistribucion;				

				$("#txtDistribucionInterna").val($distInterna.toFixed(2));
				$("#txtDistribucionVendedor").val($distVendedor.toFixed(2));
			}
		})
		.focusin(function(){
			$("#txtDistribucionInterna").val('');
			$("#txtDistribucionVendedor").val('');
		});

		$("#frmEditarCliente").on("submit", function(){
			var tasa = parseFloat($("#txtDistribucionInterna").val()) + parseFloat($("#txtDistribucionVendedor").val());

			if ( tasa != $("#txtTasa").val() ) 
			{
				
				alert ("La distribucion no concuerda con la tasa, por favor verifique");
				$("#txtDistribucionInterna").focus();
				return false;

			} else 
			{

				$("#frmEditarCliente").submit();

			}
		});
});
</script>