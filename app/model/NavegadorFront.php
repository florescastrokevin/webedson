<?php 
class NavegadorFront{

	var $ruta = array();
	var $inicio = array();
	var $actual = array();
	private $_idioma;
	
	public function __construct(Idioma $idioma){
		$this->_idioma = $idioma ;
	}

	function setActual($name,$url){
		$this->actual['name'][$name];
		$this->actual['url'][$url];
	}
	
	function bucleCatTrail($id_cat = 0, $id_prod = 0){
		$rx = 0;
		if($id_prod > 0){
			$producto = new Producto($id_prod, $this->_idioma);
			$id_cat = $producto->__get("_categoria")->__get("_id");			
		}
			
		for($x = 0; $x < 10; $x++){ 
			if($id_cat > 0 ){
				$sql   = "	SELECT * FROM categorias WHERE  id_categoria = '".$id_cat."'";
							
				$query = new Consulta($sql);
				$row   = $query->VerRegistro();

				$id_cat = $row['id_parent'];
				$id	    = $row['id_categoria']; 
				$nombre = $row['nombre_categoria']; 				

				$this->ruta[$rx] = array(
                                    'id'	=> 	$id,
                                    'url'	=> str_replace(" ","-",$nombre),
                                    'nombre'=>  $nombre
                                );						
			}else{
				break;
			}			
			$rx++;  			

		}
		sort($this->ruta);
		if($id_prod > 0){
			
			$producto = new Producto($id_prod, $this->_idioma);
			$id_cat   = $producto->__get("_categoria")->__get("_id");			 
			$this->ruta[$rx] = array(
									'id'	=> 	$producto->__get("_id"),		
									'url'	=>	str_replace(" ","-", $producto->__get("_nombre")),
									'nombre'=>  $producto->__get("_nombre")
								);			
			$rx++;
		}
	}	

	function display($id_actual=0){
		?>
		<!-- Page Title-->
		<div class="page-title">
			<div class="container">
			  <?php $ultimo_array = end($this->ruta) ?>
			  <!-- <div class="column">
			    <h1><?php //echo end($ultimo_array) ?></h1>
			  </div> -->
			  <div class="column">
			    <ul class="breadcrumbs">
				<?php
				if($_GET['q'] == ""){
					if(is_array($this->ruta) && count($this->ruta) > 0){
		                $x = 0; 
		                for($x=0; $x<count($this->ruta); $x++){ 
		                    if($id_actual == $this->ruta[$x]['id'] && $x == (count($this->ruta) - 1)){ 					
		                            ?><li><?php echo "".($this->ruta[$x]['nombre']).""; ?></li><?php 
		                    }else{?>
		                    		<li>
			                    		<a href="<?php echo $this->ruta[$x]['url'] ?>"> 
			                            	<?php echo ($this->ruta[$x]['nombre']);?>
			                            </a> 
					      			</li>
					      			<li class="separator">&nbsp;</li>
						<?php }  			
		                }
					}else{
		                echo 'Productos<br class="clear"><br class="clear">'; 
					}
				}else{
					//echo "<h1>".$_GET['q']." </h1>";
				}
		            
		        ?>
        		</ul>
    		  </div>
		  	</div>
		</div>
        <?php
	}

	function dislplayCategoria(){
		return $this->ruta[0]['id'];
	}		
}
?>