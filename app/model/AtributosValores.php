<?php 
class AtributosValores{
		
	private $_msgbox;
	private $_usuario;
		
	public function __construct(Msgbox $msg, Usuario $user)
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;		
	}
		
	public function newAtributosValores(){
		$query = new Consulta("SELECT id_atributo_valor,valor_atributo_valor as nuevo_valor_del_atributo FROM atributos_valores");
		Form::getForm($query, "new", "atributos_valores.php");
	} 	
		
	
	public function addAtributosValores($id1) {
		 $query = new Consulta("INSERT INTO atributos_valores VALUES('','".$id1."','" . $_POST['nuevo_valor_del_atributo']."')");
		 $this->_msgbox->setMsgbox('Se grabo correctamente el Valor para este Atributo.',2);	
         location("atributos_valores.php");
		// $this->listAtributosValores($id1);
    }	
		
	public function editAtributosValores(){
		$query = new Consulta("SELECT id_atributo_valor,valor_atributo_valor as nuevo_valor_del_atributo 
		                      FROM atributos_valores WHERE id_atributo_valor = '".$_GET['id']."'");
		Form::getForm($query, "edit", "atributos_valores.php");
	} 
	
    public function updateAtributosValores($id1) {
			$query = new Consulta("UPDATE atributos_valores SET id_atributo='" . $id1 . "',
			                                                    valor_atributo_valor='" . $_POST['nuevo_valor_del_atributo']."'
                                     	                    WHERE id_atributo_valor = '" . $_GET['id'] . "'");
		$this->_msgbox->setMsgbox('Se actualizo correctamente el Valor para este Atributo.',2);			
        location("atributos_valores.php");
	 }
	
	
	public function deleteAtributosValores($id1){	
		
		$atributo_valor = new AtributoValor($_GET['id']);
		$id_atributo = $atributo_valor->__get("_id_atributo");
		$query = new Consulta("DELETE FROM productos_atributos WHERE id_atributo = '".$id_atributo."'");
		$query = new Consulta("DELETE FROM atributos_valores WHERE id_atributo_valor = '" . $_GET['id'] . "'");
		
		$this->_msgbox->setMsgbox('Se elimino correctamente el Valor de este Atributo.',2);					
		location("atributos_valores.php");
	}
	
	public function listAtributosValores($id1){
      
		$query = new Consulta("SELECT  id_atributo_valor,valor_atributo_valor FROM atributos_valores av WHERE id_atributo='".$id1."'");  
		?>
         <div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Atributos</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul">
			 <?php
			 $y = 1;
				while($rowa = $query->VerRegistro()){
					?>
					 <li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $rowa['id_atributo_valor']."|attrv"; ?>">
						<div class="data"> <img src="../<?php echo _modulos_ ?>atributos/vineta.png" class="handle">   <?php echo $rowa['valor_atributo_valor'] ?></div>
						<div class="options"> 
							
							<a title="Editar" class="tooltip" href="atributos_valores.php?id=<?php echo $rowa['id_atributo_valor'] ?>&action=edit">
							<img src="<?php echo _admin_ ?>edit.png"></a> &nbsp;
							<a title="Eliminar" class="tooltip" onClick="mantenimiento('atributos_valores.php','<?php echo $rowa['id_atributo_valor'] ?>','delete')"  href="#"> <img src="<?php echo _admin_ ?>delete.png"></a>&nbsp;
                        
                            </div>
						 </li>
				<?php
					$y++;
					}	
		
	} 
	
	
	
	public function getAtributosValores(){
		$sql   = " SELECT * FROM atributos_valores";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$datos[] = array(
				'id' 		=> $row['id_atributo_valor'],
				'nombre' 	=> $row['valor_atributo_valor']
			);
		}
		return $datos;	
	} 
	
	
}
?>