<?php
/**
 *  CLASE CUENTA LLEVADA A  SECCIONES 23
 */
class Cuenta extends Main{
	
	private $_cliente, $_errores = 0;
	
	public function __construct(&$cliente){
		$this->_cliente = $cliente;
	}
	
	//Function Cerrar sesion
	public function logoutUsuario(){
		$this->_cliente->setLogeado(FALSE);
		$this->setData(0);
		unset($_SESSION['donregalo']);
	}
	// Function Asignar Cliente a Cuenta
	public function setCliente($cliente){
		$this->_cliente = $cliente;
	}
	
	// Function Recuperar Cliente
	public function getCliente(){
		return $this->_cliente;
	}	
	
	//  ENVIAR DATOS DE ACCESO DE CUENTA
	
	function mandarContrasenia(){ //VALIDAR USO, NO SE USA, EN SU LUGAR SE ESTA USANDO DESDE AJAX 	
	
		$sql = "SELECT * FROM clientes WHERE email_cliente='".$_POST['email']."'";
		$query=new Consulta($sql);
		if($query->NumeroRegistros()==1){
			$row=$query->VerRegistro();
			$email=$row['email_cliente'];
			$subject="Datos de Cuenta - ".NOMBRE_SITIO;
			$msg="
			Estimado(a) ".$row['nombre_cliente']." ".$row['apellidos_cliente'].". 
			A continuación le recordamos los datos de acceso a ".NOMBRE_SITIO.":
			
			Email: ".$row['email_cliente']." 
			Contraseña: ".desencriptar($row['password_cliente'])."			
			
			
			Atte
			".NOMBRE_SITIO."
			
			"._url_web_."	
						
			";	
			//echo desencriptar($row['password_cliente']);
			@mail($email,$subject,$msg,"from: ".EMAIL_PEDIDOS );	
			//echo "Se enviaron sus datos de acceso correctamente a su e-mail";
			$this->setNotificacion("Sus datos de acceso fueron enviados a la bandeja de su correo electronico.", 2);
										
		}else{
			$this->setNotificacion("El correo no existe en nustra base de datos", 1);
		}
		?>
           
     <div id="registrarse" class="fondo2">
        <h1 class="naranja">Recuperar Contraseña</h1>
        <p>
		<?php 
		if($this->printNotificacion() != ""){ echo  $this->printNotificacion(); }
		?>
        </p>
        <br class="clear">
        <div id="opciones">
        <a class="cancelar" href="javascript:window.history.go(-1)">Regresar</a>           
        </div>   
    </div>           
        <?php		
	}	
	
	// GUARDAR DATOS DE NUEVO CLIENTE
	
	function cuentaAdd(){
		
		if(!isset($_POST['email']) && !($_POST['idFB'])){ return false; }
		if($_POST['idFB']){ 
			$id_facebook= $_POST['idFB'];
			//$sexo  	= $_POST['sexo'];
			$password = '';
		}else{
			$id_facebook= '0';
			//$sexo  	= 'No Definido';
			$password = encriptar($_POST['password']);
		}

		$id_cliente = $this->findByEmail($_POST['email']);
		if($id_cliente == 0){
			
                    $referer = "";
                    $referer = $_SESSION['donregalo_flujo'];
                    $inicio = $_SESSION['donregalo_inicio'];
                    $sql = "INSERT INTO clientes VALUES('','".$id_facebook."','".$_POST['nombre']."','".$_POST['apellidos']."','".$_POST['email']."','".$password."','".$_POST['telefono']."','".$_POST['direccion']."','".$_POST['ciudad']."','".$_POST['pais']."','0','".$referer."','".$inicio."')";

                    $query=new Consulta($sql);
                    $id=$query->nuevoId();		
                    /*
                  	$query_i = new Consulta("INSERT INTO clientes_informacion VALUES('".$id."','".date('Y-m-d H:i:s')."', '1','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','0','".$objeto_user_agent->getBrowserName()."','".$objeto_user_agent->getOs()."','".$objeto_user_agent->getUserAgentString()."')");
					*/
                  	$this->_cliente->__set('_logeado',TRUE);
                    $this->_cliente->__set('_id',$id);
                  	$this->_cliente->__set('_nombre',$_POST['nombre']);
                    $this->_cliente->__set('_apellidos',$_POST['apellidos']);
                    $this->_cliente->__set('_usuario',$_POST['nombre']." ".$_POST['apellidos']);				
                    $this->_cliente->__set('_email',$_POST['email']);
                    $this->_cliente->__set('_telefono',$_POST['telefono']);
                    $this->_cliente->sumaIngreso();	
                    /*
                    $subject = " Registro en ".NOMBRE_SITIO;
                    $msg = "			

                            BIENVENIDO A ".NOMBRE_SITIO."

                            Estimado(a) ".$_POST['nombre']." ".$_POST['apellidos']." su cuenta a sido creada:

                            Datos de tu Cuenta
                            --------------------------------------
                            Usuario: ".$_POST['email']." 
                            Contraseña: ".$_POST['password']."

                            Con estos datos de acceso podras ingresar a tu cuenta en nuestro sitio web "._url_web_."/seccion/cuenta (".NOMBRE_SITIO.")


                            Atte
                            ".NOMBRE_SITIO."

                            Telf. 2221936
                            ventas@donregalo.pe
                            "._url_web_."

                            ";				
                            //@mail($_POST['email'],$subject,$msg,"from: ".EMAIL_CONTACTENOS);	
                            unset($_SESSION['register']);
							//InterfazCuenta::CuentaMantenimiento();
					*/
			
		}else{
			
				// DATOS DE USUARIO 
				$_SESSION['register'][0]=$_POST['nombre'];
				$_SESSION['register'][1]=$_POST['apellidos'];
				$_SESSION['register'][2]=$_POST['dni'];	
				
				$_SESSION['register'][3]=$_POST['email'];
				
				$_SESSION['register'][10]=$_POST['telefono'];
				$_SESSION['register'][11]=$_POST['movil'];
				$_SESSION['register'][12]=$_POST['boletin_cliente'];
				
				
				// ADDRESS
					
				$_SESSION['register'][4]=$_POST['empresa'];
				$_SESSION['register'][5]=$_POST['departamento'];
				$_SESSION['register'][6]=$_POST['provincia'];
				$_SESSION['register'][7]=$_POST['distrito'];	
				$_SESSION['register'][8]=$_POST['cp'];
				$_SESSION['register'][9]=$_POST['direccion'];
				
				
			$this->notificacion="  <img src='"._imgs_."icon_exclaim.gif'> &nbsp; El email que ingreso ya existe, si ya tiene una cuenta por favor <a href='#' onclick='javascript:void(document.f1.email.focus())'>entre</a> a ella. ";	
			
								
		}
			
	}
	
	// Function Asignar Datos al Cliente Logueado
	public function setData($id){
			$clientes = new Clientes();			
			$array_cliente = $clientes -> getClientePorId($id);
			$this->_cliente->__set('_id',$array_cliente[0]['id']);
			$this->_cliente->__set('_usuario',$array_cliente[0]['nombre'].' '.$array_cliente[0]['apellidos']);
			$this->_cliente->__set('_nombre',$array_cliente[0]['nombre']);
			$this->_cliente->__set('_apellidos',$array_cliente[0]['apellidos']);
			$this->_cliente->__set('_telefono',$array_cliente[0]['telefono']);
			$this->_cliente->__set('_email',$array_cliente[0]['email']);
			$this->_cliente->__set('_direccion',$array_cliente[0]['direccion']);	
			$this->_cliente->__set('_ciudad',$array_cliente[0]['ciudad']);
			$this->_cliente->__set('_pais',$array_cliente[0]['pais']);
	}
	
	
 
	// ACTUALIZA LOS DATOS DEL CLIENTE
	
	function cuentaUpdate(){		
			$sql="UPDATE clientes SET 
						nombre_cliente='".$_POST['nombre']."',
						apellidos_cliente='".$_POST['apellidos']."',						
						email_cliente='".$_POST['email']."',
						telefono_cliente='".$_POST['telefono']."',
						direccion_cliente='".$_POST['direccion']."',
						ciudad_cliente='".$_POST['ciudad']."',						
						pais_cliente = '".$_POST['pais']."'
						
				WHERE id_cliente='".$this->_cliente->__get("_id")."' ";
			$query=new Consulta($sql);
			
			$sql_info="UPDATE clientes_informacion 
							SET fecha_ultima_modificacion='".date('Y-m-d')."'
							WHERE id_cliente='".$this->_cliente->__get("_id")."'";
			$query_info=new Consulta($sql_info);
				
			
			//$this->notificacion="<img src='"._imgs_."note.gif'> &nbsp; Se actualizaron sus datos satisfactoriamente. ";			
			
	}
	
	
	
	// ACTUALIZA EL PASSWORD DEL CLIENTE
	
	function passwordUpdate(){		 
		
		$sql = "UPDATE clientes SET 
					password_cliente='".encriptar($_POST['nuevo_password'])."'						
			WHERE id_cliente='".$this->_cliente->__get("_id")."' ";
		$query = new Consulta($sql);
		
		$sql_info = "UPDATE clientes_informacion 
						SET fecha_ultima_modificacion='".date('Y-m-d')."'
						WHERE id_cliente='".$this->_cliente->__get("_id")."' ";
		$query_info = new Consulta($sql_info);			
		
		//$this->notificacion="<img src='"._imgs_."note.gif'> &nbsp; Se actualizó su contraseña satisfactoriamente. ";					
	}
			
	
	// ACCESAR A LA CUENTA DEL CLIENTE 
	
	function cuentaAcceso(){	
		
		$sql = "SELECT * FROM clientes 
			WHERE email_cliente=".comillas_inteligentes($_POST['email'])." AND 
				  password_cliente=".comillas_inteligentes(encriptar($_POST['password']));
	
		$query = new Consulta($sql);
		$row   = $query->VerRegistro();  
		
		if($query->NumeroRegistros() > 0){
			
			$this->setData($row['id_cliente']);
			$this->_cliente->setLogeado(TRUE);
			$this->_cliente->sumaIngreso();	
			$this->setNotificacion("");
			//echo 1;
			
		}else{			
			$this->setNotificacion("El usuario  o la clave son incorrectos.", 1);
			//echo 0;
		}
	} 

	// INICIO CON FACEBOOK
	public function registrarClienteFacebook() {   

		$id_facebook= $_POST['idFB'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$password = '';
		$referer = "";
        $referer = $_SESSION['donregalo_flujo'];
        $inicio = $_SESSION['donregalo_inicio'];
		
        $sql = "INSERT INTO clientes VALUES('','".$id_facebook."','".$nombre."','".$apellidos."','".$_POST['email']."','".$password."','".$_POST['telefono']."','".$_POST['direccion']."','".$_POST['ciudad']."','".$_POST['pais']."','0','".$referer."','".$inicio."')";

        $query=new Consulta($sql);
        $id=$query->nuevoId();		
                    
                    $subject = " Registro en ".NOMBRE_SITIO;
                    $subject = " Registro en ".NOMBRE_SITIO;
                    $msg = "          
                            BIENVENIDO A ".NOMBRE_SITIO."

                            Estimado(a) ".$nombre." ".$apellidos." su cuenta a sido creada:
                            
                            --------------------------------------                            

                            Con estos datos de acceso podras ingresar a tu cuenta en nuestro sitio web "._url_web_."

                            Atte
                            ".NOMBRE_SITIO."

                            Telf. ".TELEFONOS."
                            ".EMAIL_CONTACTENOS."
                            "._url_web_."

                            ";              

                            //@mail($_POST['email'],$subject,$msg,"from: ".EMAIL_CONTACTENOS);	
                            unset($_SESSION['register']);
							//InterfazCuenta::CuentaMantenimiento();                                                                                                      
        $this->cuentaAccesoFacebook($id_facebook);   
               
    }

    public function cuentaClienteFacebook($id_cliente) {  
       
        $sql = "SELECT * FROM clientes WHERE email_cliente='".$_POST['email']."' AND id_facebook_cliente='".$_POST['idFB']."' ";
        $query = new Consulta($sql);

        if ($query->NumeroRegistros() > 0) {
        	$row = $query->VerRegistro();
        	$this->cuentaAccesoFacebook($row["id_facebook_cliente"]);
        }else{
        	//echo 0;
        }

    }

    public function cuentaAccesoFacebook($id_facebook) {

        $sql = "SELECT * FROM clientes WHERE id_facebook_cliente='" . $id_facebook . "'";
        $query = new Consulta($sql);

        if ($query->NumeroRegistros() > 0) {

            $row = $query->VerRegistro();

            $this->_cliente->__set("_id", $row["id_cliente"]);
            $this->_cliente->__set("_logeado", TRUE);            
            $this->_cliente->__set("_nombre", $row["nombre_cliente"]);
            $this->_cliente->__set("_apellidos", $row["apellidos_cliente"]);
            $this->_cliente->__set('_usuario',$row["nombre_cliente"]." ".$row["apellidos_cliente"]);
            $this->_cliente->__set('_telefono',$row['telefono_cliente']);
            $this->_cliente->__set("_email", $row["email_cliente"]);     
            //echo 1;
        }
       
    }

	// FIN CON FACEBOOK



	
	
	// CERRAR SESSION DE CLIENTE
	
	public function cerrarSession(){				
		
		$this->_cliente->__set("_logeado",FALSE);
		$this->_cliente->__set("_id",'');
		$this->_cliente->__set("_usuario",'Visitante');
		$this->_cliente->__set("_email",'');
		$this->_cliente->__get("_carrito")->reset(TRUE);	
	}   

	function mailings(){ ?>
			<div class="titulo_cuerpo">Suscribete al Boletin</div>
			<div class="notificacion">Por favor, dejenos su email y en breve le estaremos suscribiendo al boletin.  </div> 
			<div id="contenido"> 							
			<form name="frmemail" action="" method="post">
				<label>E-mail:</label> <input type="text" name="email" size="40" class="inp"> <br /> 
				<div class="botones"><input type="button" name="enviar" value="ENVIAR" onclick="return validar_send_mailings('suscribe')" class="btn_detalle" />	 </div>					
			</form>						
		</div><?php
	}
	
	function suscribe(){
		$sqlSus = "INSERT INTO mailings(id_mailings , email_mailings) values ('' , '".$_POST['email']."' )";
		$rsSus = new Consulta($sqlSus);
		
	}

	//INICIO METODOS NECESARIOS PARA EL LOGEO DE FACEBOOK

	public function findByEmail($email){
		$id_cliente = 0;
		$sql = "SELECT * FROM clientes WHERE email_cliente='".$email."'";
		$query = new Consulta($sql);
		if($query->NumeroRegistros() > 0){
			$row = $query->VerRegistro();
			$id_cliente = $row["id_cliente"];
		}
		return $id_cliente;
	}
	
}
?>