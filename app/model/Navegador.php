<?php 
class Navegador{

	private $ruta = array(), $inicio = array(), $actual = array();
	private $_idioma;
	
	public function __construct(Idioma $idioma){
		$this->_idioma = $idioma ;
	}

	function setActual($name,$url){
		$this->actual['name'][$name];
		$this->actual['url'][$url];
	}

	function bucleCatTrail($id_cat = 0, $id_prod = 0, $id_ec = 0){
		$rx = 0;
		for($x = 0; $x < 10; $x++){ 
			if($id_cat > 0 ){

				$sql   = "	SELECT * FROM categorias WHERE  id_categoria = '".$id_cat."'";

				$query = new Consulta($sql);
				$row   = $query->VerRegistro();

				$id_cat = $row['id_parent'];
				$id 	= $row['id_categoria']; 
				$nombre = $row['nombre_categoria']; 				

				$this->ruta[$rx] = array(
							'id'	=> 	$id,
							'url'	=>	'productos.php?cat='.$id,
							'nombre'=>  $nombre);						
			}else{
				break;
			}			
			$rx++;  			
		}
		sort($this->ruta);

		if($id_prod > 0 && $id_ec == 0){
			$producto = new Producto($id_prod, $this->_idioma);
			$id_cat = $producto->__get('_categoria')->__get('_id');			 
			$this->ruta[$rx] = array(
									'id'	=> 	$producto->__get('_id'),		
									'url'	=>	'productos.php?id='.$producto->__get('_id'),
									'nombre'=>  $producto->__get('_nombre') );			
			$rx++;
		}

		if($id_ec > 0){
			$obj_c = new Categoria($id_ec, $this->_idioma); 
			$this->ruta[$rx] = array(
				'id'	=> 	$obj_c->__get('_id'),		
				'url'	=>	'productos.php?id='.$obj_c->__get('_id'),
				'nombre'=>  $obj_c->__get('_nombre') );			
			$rx++; 
		}
	}	

	function display($id_actual=0){?>

		<a href="productos.php?cat=0">Categorias</a><?php 
		if(is_array($this->ruta) && count($this->ruta) > 0){
			$x = 0;
			for($x=0; $x<count($this->ruta); $x++){ ?>
				&nbsp&gt;&nbsp;
				<?php
				if($id_actual == $this->ruta[$x]['id'] && $x == (count($this->ruta) - 1)){ 					
					echo $this->ruta[$x]['nombre'];
				}else{?>
					<a href="<?php echo $this->ruta[$x]['url'] ?>" style="text-decoration:none"> <?php echo $this->ruta[$x]['nombre'];?></a><?php
				}  			
			}
		}
	}		
}

?>