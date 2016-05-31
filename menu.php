<?php
/*

EL MENU MUESTRA LAS OPCIONES DISPONIBLES DEPENDIENDO DEL TIPO DE USUARIO QUE INGRESE.

$permisosDisponibles[ID-PERMISO-USUARIO][OPCIONES-DISPONIBLES] ARRAY QUE CONTIENE LAS OPCIONES DISPONIBLES DE CADA TIPO DE USUARIO QUE INGRESE

*/
$idTipoUsuario = $_SESSION["usuario"]["idTipoUsuario"];
$permisosDisponibles =  [
                            "0" => "Ventas en proceso",
                            "1" => "Nueva venta",
                            "2" => "Historico de ventas",
                            "3" => "Clientes", 
                            "4" => "Usuarios", 
                            "5" => "Bancos",
                            "6" => "Puntos virtuales", 
                            "7" => "Reportes",
                            "8" => "Reportes internos",
                            "9" => "Estados de cuenta",  
                        ];
$permimosPorTipo = [
                        "1" => [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",],
                        "2" => [ "0", "1", "2", "4", "7", "9", ],
                        "3" => [ "0", "1", "2", "7", ],
                        "4" => [ "0", "2", "8", ],
                        "5" => [ "0", "1", "2", "7", "9", ],
                   ];              

function activaMenu( $seccion, $valor ) {
	if ( $seccion == $valor ) {
		return "active";
	}
}

function mostrarOpcion ( $opcion, $valor ) {
    
    if  ( in_array( $opcion, $valor ) ) {
        return true;        
    } else {
        return false;
    }

}
?>
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        
    </div>

    <ul class="sidebar-menu">
        <?php
        //OPCION 0
        if ( mostrarOpcion(0, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>

        <li class="<?=activaMenu($_SESSION["seccion"], 0)?>">
            <a href="home.php">
                <i class="fa fa-line-chart"></i> <span>Ventas en Proceso</span>
            </a>
        </li>
        <?php
        }
        //OPCION 1
        if ( mostrarOpcion(1, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="<?=activaMenu($_SESSION["seccion"], 1)?>">
            <a href="home.php?s=<?=cNuevaVenta;?>">
                <i class="fa fa-credit-card"></i> <span>Nueva Venta</span>
            </a>
        </li>
        <?php
        }
        //OPCION 2
        if ( mostrarOpcion(2, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="<?=activaMenu($_SESSION["seccion"], 6)?>">
            <a href="home.php?s=<?=cOperaciones?>">
                <i class="fa fa-line-chart"></i> <span>Historico de Ventas</span>
            </a>
        </li>
        <?php
        }  
        //OPCION 3
        if ( mostrarOpcion(3, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 2)?>">
            <a href="#">
                <i class="fa fa-suitcase"></i>
                <span>Clientes</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="home.php?s=<?=cClientes;?>"><i class="fa fa-angle-double-right"></i> Buscar</a></li>
                <li><a href="home.php?s=<?=cAddClientes;?>"><i class="fa fa-angle-double-right"></i> Crear</a></li>
            </ul>
        </li>
        <?php
        }  
        //OPCION 4
        if ( mostrarOpcion(4, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 3)?>">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?=$urlWebServiceClient;?>clienteUsuarios.php"><i class="fa fa-angle-double-right"></i> Buscar</a></li>
                <li><a href="home.php?s=<?=cAddUsuarios;?>"><i class="fa fa-angle-double-right"></i> Crear</a></li>
            </ul>
        </li>
        <?php
        }  
        //OPCION 5
        if ( mostrarOpcion(5, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 4)?>">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Bancos</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="home.php?s=<?=cBancos;?>"><i class="fa fa-angle-double-right"></i> Buscar</a></li>
                <li><a href="home.php?s=<?=cAddBancos;?>"><i class="fa fa-angle-double-right"></i> Crear</a></li>
            </ul>
        </li>
        <?php
        }  
        //OPCION 6
        if ( mostrarOpcion(6, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 5)?>">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Puntos Virtuales</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="home.php?s=<?=cVirtualPoints;?>"><i class="fa fa-angle-double-right"></i> Buscar</a></li>
                <li><a href="home.php?s=<?=cAddVirtualPoints;?>"><i class="fa fa-angle-double-right"></i> Crear</a></li>
            </ul>
        </li>
        <?php
        }  
        //OPCION 7
        if ( mostrarOpcion(7, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 7)?>">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="home.php?s=<?=cReporteGeneral;?>"><i class="fa fa-angle-double-right"></i> General</a></li>
                <li><a href="home.php?s=<?=cReporteIntComisionesVendedor;?>"><i class="fa fa-angle-double-right"></i> Comisiones Vendedores</a></li>
            </ul>
        </li>
        <?php
        }  
        //OPCION 8
        if ( mostrarOpcion(8, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
        <li class="treeview <?=activaMenu($_SESSION["seccion"], 7)?>">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Reportes Internos</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="home.php?s=<?=cReporteIntComisionesMes;?>"><i class="fa fa-angle-double-right"></i> Comisiones Mes</a></li>
                <li><a href="home.php?s=<?=cReporteIntComisionesRango;?>"><i class="fa fa-angle-double-right"></i> Comisiones Rango</a></li>
                <li><a href="home.php?s=<?=cReporteIntComisionesVendedor;?>"><i class="fa fa-angle-double-right"></i> Comisiones Vendedores</a></li>
                <li><a href="home.php?s=<?=cReporteIntComisionesTotales;?>"><i class="fa fa-angle-double-right"></i> Comisiones Totales</a></li>
            </ul>
        </li>
        <?php
        }
        //OPCION 9
        if ( mostrarOpcion(9, $permimosPorTipo[$idTipoUsuario]) ) {
        ?>
            <li class="treeview <?=activaMenu($_SESSION["seccion"], 10)?>">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Estado de Cuenta</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="home.php?s=<?=cEstadoCuenta;?>"><i class="fa fa-angle-double-right"></i> Ver</a></li>
                </ul>
            </li>
        <?php
        }
        ?>
        
        <!--<li class="treeview">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>UI Elements</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-edit"></i> <span>Forms</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-table"></i> <span>Tables</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
            </ul>
        </li>
        <li>
            <a href="pages/calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="badge pull-right bg-red">3</small>
            </a>
        </li>
        <li>
            <a href="pages/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="badge pull-right bg-yellow">12</small>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
            </ul>
        </li>
        <li>
            <a href="home.php?s=<?=cMailBox?>">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
	        </a>
        </li>-->
    </ul>
</section>