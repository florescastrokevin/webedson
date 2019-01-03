<?php
class BusquedasBlog{
	
		
	private $_msgbox;
    public function __construct($msg='')
    {
		$this->_msgbox = $msg;
    }

	public function actualizarBusquedasBlog(){ 				

		//eliminamos lo anterior
		$sql_delete_top   = "DELETE FROM busquedas_blog_top";
		$query_delete_top = new Consulta($sql_delete_top);			

		//seleccionamos lo mas buscado
		$sql = "SELECT id_busqueda_blog, texto_busqueda_blog, count(texto_busqueda_blog) as suma 
				FROM busquedas_blog 
				WHERE texto_busqueda_blog !='' 
				GROUP BY texto_busqueda_blog 
				ORDER BY suma DESC LIMIT 0,500";
		$query = new Consulta($sql);
		
		//actualizamos los mas buscados	 
		$total 		=  $this->TotalBusquedasBlog(); 
		
		$retorno;
		while( $row = $query->VerRegistro() ){

			$percent 	= ( $row['suma'] * 80 ) / $total;
			$percent 	= ceil( 80 + ($percent * 11) );
									
			$sql_top 	= "INSERT INTO busquedas_blog_top VALUES('','".$row['texto_busqueda_blog']."','".$row['suma']."',1)";
			$query_top	= new Consulta($sql_top);	 
		}	

		$this->_msgbox->setMsgbox('Busquedas Blog actualizadas correctamente.',2);
        location("busquedasblog.php");
		
		 

	}

	public function TotalBusquedasBlog(){

		$sql = "SELECT SUM( suma )
				FROM (				
				SELECT COUNT( texto_busqueda_blog ) AS suma
				FROM busquedas_blog b
				WHERE texto_busqueda_blog !='' 
				GROUP BY b.texto_busqueda_blog
				ORDER BY suma DESC
				LIMIT 0, 500
				) AS total";

		$query = new Consulta($sql);

		$row = $query->VerRegistro();		

		return $row["0"];

	}

	

	public function listBusquedasBlog(){	
		$query = new Consulta("SELECT * FROM busquedas_blog_top");
		echo Listado::simple($query,'','',FALSE);
	}
 

	public function getTopBusquedaBlog($num="") {
        $limite = "";
        if($num != "") $limite = 'LIMIT 0,'.$num;
        
		$sql="SELECT * FROM busquedas_blog_top WHERE cantidad_busqueda_blog_top > 1 AND estado_busqueda_blog_top = 1 ORDER BY cantidad_busqueda_blog_top DESC ".$limite;
		
        $query = new Consulta($sql);
		$datos = array();
        while ($row = $query->VerRegistro()) {
            $datos[] = array(
                'id' => $row['id_busqueda_blog_top'],
                'texto_busqueda_blog_top' => sql_htm($row['texto_busqueda_blog_top']),
                'cantidad_busqueda_blog_top' => $row['cantidad_busqueda_blog_top']
            );
        }
        if(is_array($datos)&&count($datos)>0)
        aasort($datos, 1);
        return $datos;
    }

        

	static public function addBusquedaBlog($consulta){
		$query_insert = new Consulta("INSERT INTO busquedas_blog VALUES('', ".str_replace("+"," ",$consulta).", '".date("Y-m-d H:i:s")."')");
	}

}

?>