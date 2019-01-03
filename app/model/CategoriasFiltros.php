<?php
class CategoriasFiltros{
	private $_idioma, $_msgbox;
	
	public function __construct(Msgbox $msg = NULL){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;
	}

    static public function getCategoriasFiltros()
    {
    	$sql = "SELECT * FROM categorias_filtros ";
            
        $query=new Consulta($sql);
        $retorno;
        while($row = $query->VerRegistro()){            
            $retorno[] = array(
                'id'                    => $row['id_categoria_filtro'],
                'id_categoria'         =>    $row['id_categoria'],
                'id_filtro'             =>    $row['id_filtro'],
                'url'                   =>    $row['url_categoria_filtro'],
                'nombre'                => $row['nombre_categoria_filtro']       
            );
        }
        return $retorno;    
    }
    static public function UpdateCategoriasFiltros()
    {
        $id_cat = CategoriasFiltros::getCategoriaByName($_POST['categoria']);
        $id_fil = CategoriasFiltros::getFiltroByName($_POST['filtro']);
        $sql = new Consulta("UPDATE categorias_filtros SET nombre_categoria_filtro = '".$_POST['nombre']."', url_categoria_filtro = '".$_POST['url']."', id_categoria = ".$id_cat.", id_filtro = ".$id_fil." WHERE id_categoria_filtro = ".$_POST['id']." ");
    }
    static public function getCategoriaByName($name){
        $query = new Consulta("SELECT id_categoria FROM categorias WHERE nombre_categoria LIKE '".$name."' LIMIT 1  ");
        if ($row = $query->VerRegistro()) {
            return $row['id_categoria'];
        }
    }
    static public function getFiltroByName($name){
        $query = new Consulta("SELECT id_filtro FROM filtros WHERE nombre_filtro LIKE '".$name."' LIMIT 1  ");
        if ($row = $query->VerRegistro()) {
            return $row['id_filtro'];
        }
    }
    static public function getCategoriasPadre($tipo='')
    {
        $query = new Consulta("SELECT * FROM categorias WHERE id_parent = 0 ");
        $retorno;
        while($row = $query->VerRegistro()){            
            $retorno[] = array(
                'value'                    => $row['id_categoria'],
                'text'          => $row['nombre_categoria']      
            );
        }
        if ($tipo=='default') {
            return $retorno;
        }else{
           echo json_encode($retorno);
        }
    }
    static public function getFiltrosHijo($tipo='')
    {
        $query = new Consulta("SELECT * FROM filtros WHERE id_parent <> 0 ");
        $retorno;
        while($row = $query->VerRegistro()){            
            $retorno[] = array(
                'value'                    => $row['id_filtro'],
                'text'          => $row['nombre_filtro']      
            );
        }
        if ($tipo=='default') {
            return $retorno;
        }else{
            echo json_encode($retorno);
        }
    }
    static public function addCategoriaFiltro(){
        $query = new Consulta("INSERT INTO categorias_filtros (nombre_categoria_filtro, url_categoria_filtro , id_categoria, id_filtro) VALUES('".$_POST['nombre']."','".$_POST['url']."',".$_POST['categoria'].",".$_POST['filtro'].") ");
    }
    static public function deleteRow(){
        if ($_POST['id']) {
            $query = new Consulta("DELETE FROM categorias_filtros WHERE id_categoria_filtro = ".$_POST['id']." ");
        }
    }
}
?>