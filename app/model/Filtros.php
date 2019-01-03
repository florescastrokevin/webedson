<?php
class Filtros{
	private $_idioma, $_msgbox;
	
	public function __construct(Msgbox $msg = NULL){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;
	}

    static public function getFiltrosForTree($id = "", $id_parent){

            $retorno = array();
			
            $where = $id_parent != 999999 ? " WHERE id_parent = '".$id_parent."' " : "";
			$where .= $id != "" ? " AND id_filtro = '".$id."' " : "";

            $sql = "SELECT * FROM filtros ".$where." ";
			
            $query=new Consulta($sql);
            $retorno;
            while($row = $query->VerRegistro()){			
                $retorno[] = array(
                    'id'          =>	$row['id_filtro'],
                    'nombre'	  =>	$row['nombre_filtro'],
                    'url'	  	  =>	$row['nombre_filtro'],
                    'id1'	  	  =>	$row['id_parent']				
                );
            }
            return $retorno;		
	}

    static public function treeFiltros()
    {
    	$lista_filtros = Filtros::getFiltrosForTree('',0);
    	foreach ($lista_filtros as $filtro) {
    		$obj_filtro = new Filtro($filtro['id']);
    		$lista_subfiltros = Filtros::getFiltrosForTree('',$obj_filtro->__get('_id'));
    		?>
    		<ul>
                <li data-jstree='{"opened":true <?php echo (!$lista_subfiltros)?',"icon" : "fas fa-folder fa-lg"':'' ?>}'  identifica="<?php echo $obj_filtro->__get('_id') ?>">
                    <?php echo $obj_filtro->__get('_nombre') ?>

                    <?php if ($lista_subfiltros): ?>	
                    <ul>
					    <?php foreach ($lista_subfiltros as $subfil): ?>
					    <?php $obj_sub_fil = new Filtro($subfil['id']) ?>
					    	<li data-jstree='{ "icon" : "fas fa-arrow-right fa-lg text-info" }' identifica="<?php echo $obj_sub_fil->__get('_id') ?>">
					    		<?php echo $obj_sub_fil->__get('_nombre') ?>
					    	</li>
					    <?php endforeach ?>
					</ul>
                    <?php endif ?>
                </li>
            </ul>
    		<?php
    	}
    }

    static public function editFiltroData()
    {
    	if ($_POST['id']) {
	    	$obj_filtro = new Filtro($_POST['id']);
	    	?>
	    	<?php if ($obj_filtro->__get('_parent')==0): ?>
    		<button class="btn btn-xs btn-success m-b-10" onclick="modalNewFiltro(<?php echo $obj_filtro->__get('_id') ?>)">Nuevo Sub-Filtro &nbsp;&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
	    	<?php endif ?>
	    	<form id="edit-categoria" method="post">
	    		<input type="hidden" value="<?php echo $obj_filtro->__get('_id') ?>" name="update_id"> 
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Nombre</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_nombre" class="form-control" placeholder="" value="<?php echo $obj_filtro->__get('_nombre') ?>" />
	                </div>
	            </div>
	            <div class="form-group row m-b-15">
	                <label class="col-form-label col-md-3">Url</label>
	                <div class="col-md-9">
	                    <input type="text" name="update_url" class="form-control" placeholder="" value="<?php echo $obj_filtro->__get('_url') ?>" />
	                </div>
	            </div>
	            <!-- <div class="form-group row m-b-10">
	                <label class="col-md-3 col-form-label">Activo</label>
	                <div class="col-md-9 p-t-3">
	                    <div class="switcher switcher-success">
	                        <input type="checkbox" name="update_activo" id="update_activo" <?php echo ($obj_filtro->__get('_estado')==1)? 'checked=""':'' ?> value="1">
	                        <label for="update_activo"></label>
	                    </div>
	                </div>
	            </div> -->
	            <a class="btn btn-green text-white" onclick="updateFiltro()">Actualizar</a>
	        </form>
        <?php }
    }
    static public function updateFiltroTree()
    {
    	$sql="UPDATE filtros SET 
    	nombre_filtro = '".$_POST['nombre']."', 
    	url_filtro = '".$_POST['url']."' WHERE id_filtro = ".$_POST['id']."  ";
    	$query=new Consulta($sql);
    }
    static public function saveFiltroTree()
    {
    	$sql="INSERT INTO filtros (nombre_filtro, url_filtro, id_parent) VALUES('".$_POST['nombre']."', '".$_POST['url']."', ".$_POST['parent'].") ";
    	$query=new Consulta($sql);
    }
}
?>