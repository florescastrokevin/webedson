<?php
// Proyecto: Sistema Develoweb
// Version: 1.0
// Programador: Walter Meneses
// Framework: Develoweb Version: 2.0
// Clase: Session

/** relaciones */
require_once _model_.'Rol.php';
require_once _model_.'Usuario.php';

class Sesion 
{   

    private $_usuario;
    private $_token; 
	private $_idioma;
	
    public function __construct(Idioma $idioma)
    {
        session_start();      
		if(!$_SESSION['usuario'] || empty($_SESSION['usuario'])){			
			$_SESSION['usuario'] = new Usuario();
		}
		
		$this->_usuario = $_SESSION['usuario'] ;
		$this->_idioma = $idioma ;		
    }
	 
	public function validaAcceso($usuario, $password){
		
		$usuario  = trim( str_replace( "'","",str_replace("#","",$usuario) ) );		
		$password = trim( str_replace( "'","",str_replace("#","",$password) ) );  
		
		$sql = " SELECT * FROM usuarios WHERE login_usuario='".$usuario."' AND password_usuario='".$password."' ";
		$query = new Consulta($sql); 		
		
		if($query->NumeroRegistros() > 0){					
			$row= $query->VerRegistro();		
			$this->_usuario = new Usuario($row['id_usuario']);			
			$_SESSION['usuario'] = $this->_usuario;	
			$this->_usuario->setLogeado(TRUE);													
		}else{
			$this->errores += 1;
			return false;
		}				
		return true;	
	}	
	
	function enviarContrasena(){
		$query = new Consulta("SELECT * FROM usuarios WHERE email_usuario = '".$_POST['login']."'");
		if($query->NumeroRegistros() == 1){
			$row=$query->VerRegistro();
						
						$email 	 = $row['email_usuario'];
$subject = "Datos de Cuenta - Industria Medina";
$msg="
Estimado(a) ".$row['nombre_usuario']." ".$row['apellidos_usuario'].". 
A continuación le recordamos los datos de acceso a Industria Medina:

Usuario: ".$row['login_usuario']." 
Contraseña: ".$row['password_usuario']."			


Atte
Industria Medina

http://www.industriamedina.com";

	
			@mail($email,$subject,$msg,"From: soporte@joyeria.com");	
			return true;
							
		}else{				
			return false;
		}			
	}

	public function isLoged(){
		if(is_object($this->_usuario)){
			return true;
		}else{
			return false;
		} 
	}
	
	public function conFiltro(){
		
		if($this->_usuario->getRol()->getNombre() == "Administrador" || $this->_usuario->getRol()->getNombre() == "Jefe de Proyectos"){
			return false;
		}else{
			return true;
		} 
	}
	
	public function logout(){
		
		unset($_SESSION['usuario']); 
		//session_destroy();
      	
		$this->_usuario = new Usuario();
		$this->_usuario->setLogin("Visitante");
		$this->_usuario->setLogeado(FALSE);	
		$_SESSION['usuario'] = $usuario;
		header("Location: login.php"); 					
	}	
	
		function acceso(){ ?>		
		<form name="login" action="index.php" method="post">
			<table align="center" width="300" id="inicio" cellpadding="1" cellspacing="1">
				<tr>
					<td colspan="2" class="title"> ACCESO AL AREA DE ADMINISTRACI&Oacute;N</td>
				</tr>	
				<tr>
					<td colspan="2" ><BR></td>
				</tr>			
				<tr>
					<td width="40%" align="right">Usuario : </td>
					<td class="total"><input type="text" name="login" class="text"></td>
				</tr>
				<tr>
					<td align="right">Password : </td>
					<td class="total"><input type="password" name="password" class="text"></td>
				</tr>
				<tr>
					<td align="right"><BR><input type="reset" name="limpiar" value="LIMPIAR" class="button"></td>
					<td align="center"><BR><input type="submit" name="enviar" value="ACEPTAR" class="button"></td>
				</tr>
				<tr>
					<td colspan="2" ><BR></td>
				</tr>
			</table>
		</form>
	
	<?php		
	}
	
	function inicio($msgbox){
            $usuarios   = new Usuarios();
            $categorias = new Categorias($msgbox);
            $productos	= new Productos($this->_idioma, $msgbox, $this->_usuario);
            $pedidos = new Pedidos();?>
		<h1>Bienvenido a <?php echo NOMBRE_SITIO; ?></h1>
            
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?php 
                        $ultimos_pedidos = $pedidos->getProximosAEntregarPedidos() ;
                        $total_ultimos_pedidos = count($ultimos_pedidos);
                        ?>
                        <fieldset>
                            <legend>Proximas Entregas</legend>
                            
                            <table cellpadding="0" cellspacing="0" class="listado">
                                <thead>
                                    <tr class="head">
                                        <th class="titulo">Pedido</th>
                                        <th class="titulo">Fecha</th>
                                        <th class="titulo">Estado</th>
                                        <th class="titulo">Distrito</th>
                                    </tr>
                                </thead>
                                <tbody><?php
                                for($i = 0; $i < $total_ultimos_pedidos; $i++){ ?>
                                    <tr class="row">
                                        <td><a href="pedidos.php?id=<?php echo $ultimos_pedidos[$i]["id"] ?>&action=edit"><?php echo $ultimos_pedidos[$i]["id"] ?></a></td>
                                        <td><?php echo $ultimos_pedidos[$i]["fecha"] ?></td>
                                        <td><?php echo $ultimos_pedidos[$i]["estado"] ?></td>
                                        <td><?php echo $ultimos_pedidos[$i]["distrito"] ?></td>
                                    </tr>
                                    <?php
                                } ?>
                                    
                                </tbody>
                            </table>
                        </fieldset>    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <?php 
                        $cantidad_pedidos = $pedidos->getCantidadPedidos();
                        //print_r($cantidad_pedidos);
                        $total_cantidad_pedidos = count($cantidad_pedidos);
                        ?>
                        <fieldset>
                            <legend>Ventas</legend>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script>
                        google.charts.load('current', {packages: ['corechart', 'line']});
                        google.charts.setOnLoadCallback(drawBasic);

                        function drawBasic() {

                              var data = new google.visualization.DataTable();
                              data.addColumn('date', 'M');
                              data.addColumn('number', '');
                              data.addRows([ <?php 
                              
                              for($m = 0; $m < 12; $m++){ 
                                  $cantidad = $cantidad_pedidos[$m]["cantidad"] > 0 ? $cantidad_pedidos[$m]["cantidad"] : 01; ?>
                                  [new Date(2015,<?php echo $m?>),<?php echo $cantidad ?>]<?php 
                                  if($m < 12){ echo ",";}
                              } ?>
                              ]);

                              var options = {
                                 legend: 'none',
                                 title:'Cantidad de Ventas Mensuales - <?php echo date('Y') ?>',
                                hAxis: {
                                  title: 'Meses',
                                  format: 'MMM',
                                  gridlines: {count: 12}
                                },
                                vAxis: {
                                   title: 'Cantidad'
                                }
                              };

                              var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                              chart.draw(data, options);
                            }
                        </script>
                        <div id="chart_div"></div>
<!--                        <div class="row">
                            <div class="col-sx-12 col-sm-12 col-md-12">
                                <h4>Evolución de Ventas</h4>
                            </div>
                        </div>-->
                        </fieldset>
                        
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2 ">
                        <fieldset>
                            <legend>Accesos</legend>
                        <ul id="welcome">
                            <?php if($this->_usuario->getRol()->getNombre() == "Administrador"){?>
                            <li><a href="pedidos.php"><img src="<?php echo _tpl_panel_imgs_ ?>icon-reportes.jpg" /><span>Pedidos</span></a></li>
                            <li><a href="pedidos.php?action=new"><img src="<?php echo _tpl_panel_imgs_ ?>icon-pedidos.jpg" /><span>Nuevo Pedido</span></a></li>
                            <li><a href="productos.php?cat=0"><img src="<?php echo _tpl_panel_imgs_ ?>icon-solucionarios.jpg" /><span>Productos</span></a></li>
<!--                              <li><a href="clientes.php"><img src="<?php echo _admin_ ?>icon-clientes.jpg" /><span>Clientes</span></a></li>
                          <li><a href="banners.php"><img src="<?php echo _admin_ ?>icon-autores.jpg" /><span>Banners</span></a></li>
                            <li><a href="reporte_pedido.php"><img src="<?php echo _admin_ ?>icon-reportes.jpg" /><span>Reportes</span></a></li>
                            <li><a href="usuarios.php"><img src="<?php echo _admin_ ?>icon-cuentas-accesos.jpg" /><span>Cuentas y Accesos</span></a></li>-->
                         <?php }else{ ?>   
                            <li><a href="solucionarios.php?cat=0"><img src="<?php echo _tpl_panel_imgs_ ?>icon-solucionarios.jpg" /><span>Solucionarios</span></a></li>
                            <li><a href="autores.php"><img src="<?php echo _tpl_panel_imgs_ ?>icon-autores.jpg" /><span>Autores</span></a></li>
                            <li><a href="tutorias.php"><img src="<?php echo _tpl_panel_imgs_ ?>icon-solucionarios.jpg" /><span>Tutorias</span></a></li>

                         <?php } ?>
                        </ul>
                        </fieldset>
                    </div>
                </div>
                
                
		<?php
		
	}
	
	
	
	
    public function getUsuario()
    {
        return $this->_usuario;
    }
	
    public function getToken()
    {
        return $this->_token;
    }
	
    private function _generarToken($text)
    {
        return md5(rand().$text);
    }
	
    public static function getStatus() 
    {
        $session = new Session();
        
        if(!empty($_SESSION['usuario']) && !empty($_SESSION['token'])) {
              
            $token = $this->_persistencia->getToken($_SESSION['usuario']);

            if($_SESSION['token'] == $token){                
                $this->_usuario = new Usuario($_SESSION['usuario']);
                $this->_token   = $this->_generarToken($usuario);            
                //$_persistencia->update($this);
            }else {
                exit;
            }
        }
    }	

}
?>