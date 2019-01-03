<?php
class HistorialesCesta{
	
	private $_msgbox;
	private $_usuario;
	
	public function __construct( Msgbox $msgbox, Usuario $usuario ){
		$this->_msgbox = $msgbox;
		$this->_usuario = $usuario;
	}
	
	public function editHistorialesCesta(){
		$this->_msgbox->setMsgbox('No se encuentra habilitada esta opcion',2);
		location("historialCesta.php");
	}
	
	public function deleteHistorialesCesta(){
		new Consulta("DELETE FROM historial_cesta WHERE id_historial_cesta = '".$_GET['id']."'");
		$this->_msgbox->setMsgbox('Se ha eliminado el historial correctamente',2);
		location("historialCesta.php");
	}
	
	public function listHistorialesCesta(){
		
		
            if(!isset($_GET['pag'])){ $_GET['pag'] = 1; } 
            $tampag = 20;
            $reg1 = ($_GET['pag']-1) * $tampag;	  


            if($_GET['q'] != ''){
                    $q = $_GET['q'];
                    $like_n  = " AND CONCAT(c.nombre_cliente, ' ', c.apellidos_cliente) LIKE '%".$q."%'";
                    $like_e  = " OR c.email_cliente LIKE '%".$q."%'   ";			
            } 
            
            $orden = "";
            if($_GET['orden'] && !empty($_GET['orden'])){
                
                $orden = " ".$_GET['orden']. ' DESC';
                
            }else{
				$orden = "fecha_historial_cesta DESC";
			}

            $sql = "SELECT * FROM historial_cesta ORDER BY ".$orden."";
                            

            $queryt= new Consulta($sql);	 

            $num=$queryt->NumeroRegistros();	
            $limit=$sql_pag." LIMIT ".$reg1.",".$tampag."";

            $sql .= $limit ;		
            $query= new Consulta($sql);	
            echo Listado::Simple($query,"historialCesta.php");
		 
		
		if( $num > $tampag ){ echo "<div align='center'>".paginar($_GET['pag'], $num, $tampag, "historialCesta.php?pag=")."</div>"; }	
		
	}
}
?>