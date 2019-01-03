<?php
class Busquedas{
	
		
	private $_msgbox;
    public function __construct($msg='')
    {
		$this->_msgbox = $msg;
    }

	public function actualizarBusquedas(){ 				

		//eliminamos lo anterior
		$sql_delete_top   = "DELETE FROM busquedas_top ";
		$query_delete_top = new Consulta($sql_delete_top);			

		//seleccionamos lo mas buscado
		$sql = "SELECT id_busqueda, texto_busqueda, count(texto_busqueda) as suma 
				FROM busquedas 
				WHERE texto_busqueda !='' 
				GROUP BY texto_busqueda 
				ORDER BY suma DESC LIMIT 0,500";
		$query = new Consulta($sql);
		
		//actualizamos los mas buscados	 
		$total 		=  $this->TotalBusquedas(); 
		
		$retorno;
		while( $row = $query->VerRegistro() ){

			$percent 	= ( $row['suma'] * 80 ) / $total;
			$percent 	= ceil( 80 + ($percent * 11) );
									
			$sql_top 	= "INSERT INTO busquedas_top VALUES('','".$row['texto_busqueda']."','".$row['suma']."',1)";
			$query_top	= new Consulta($sql_top);	 
		}	

		$this->_msgbox->setMsgbox('Busquedas actualizadas correctamente.',2);
        location("busquedas.php");
		
		 

	}

	public function TotalBusquedas(){

		$sql = "SELECT SUM( suma )
				FROM (				
				SELECT COUNT( texto_busqueda ) AS suma
				FROM busquedas b
				WHERE texto_busqueda !='' 
				GROUP BY b.texto_busqueda
				ORDER BY suma DESC
				LIMIT 0, 500
				) AS total";

		$query = new Consulta($sql);

		$row = $query->VerRegistro();		

		return $row["0"];

	}

	

	public function listBusquedas(){	
		//original
		$query = new Consulta("SELECT * FROM busquedas_top");
		//modificado
		//$query = new Consulta("SELECT * FROM busquedas_top WHERE texto_busqueda_top LIKE desayunos%");
		echo Listado::simple($query,'','',FALSE);
	}
 

	static public function getTopBusqueda($num="") {
        $limite = "";
        if($num != "") $limite = 'LIMIT 0,'.$num;
        
		$sql="SELECT * FROM busquedas_top WHERE cantidad_busqueda_top > 1 AND estado_busqueda_top = 1 ORDER BY cantidad_busqueda_top DESC ".$limite;
		
        $query = new Consulta($sql);
		$datos = array();
        while ($row = $query->VerRegistro()) {
            $datos[] = array(
                'id' => $row['id_busqueda_top'],
                'texto_busqueda_top' => sql_htm($row['texto_busqueda_top']),
                'cantidad_busqueda_top' => $row['cantidad_busqueda_top']
            );
        }
        if(is_array($datos)&&count($datos)>0)
        aasort($datos, 1);
        return $datos;
    }

        

	static public function addBusqueda($consulta){
		$query_insert = new Consulta("INSERT INTO busquedas VALUES('', '".str_replace("+"," ",$consulta)."', '".date("Y-m-d H:i:s")."')");
	}

}

?>