<?php
class Consulta{
	
	var $Consulta_ID = 0;
	var $Errno = 0;
	var $Error = "";
	
	var $link	= 	0;
	var $mysql_data_type_hash = array(
		0	=>'decimal',
		1	=>'tinyint',
		2	=>'smallint',
		3	=>'int',
		4	=>'float',
		5	=>'double',
		7	=>'timestamp',
		8	=>'bigint',
		9	=>'mediumint',
		10	=>'date',
		11	=>'time',
		12	=>'datetime',
		13	=>'year',
		16	=>'bit',
		252	=>'blob',
		253	=>'string',
		254	=>'char',
		246	=>'decimal'
	);

	function Consulta($sql = "", $switch=TRUE){
		
		$this->link = Conexion::getInstance();
		//	AutoCommit Habilitado por defecto
		$this->autoCommit($switch);
		
		if ($sql == "") {
			$this->Error = "No ha especificado una consulta SQL";
			$this->Errno =  mysqli_errno($this->link);
			return false;
		}
		$this->Consulta_ID = mysqli_query($this->link, $sql) or die("<div id='error'>".mysqli_error($this->link)."<br><br> ".$sql."<div>");
		
		if(!$this->Consulta_ID){
			$this->Errno = mysqli_errno($this->link);
			$this->Error = mysqli_error($this->link);					
		}
		return $this->Consulta_ID;	
	} 
	function NumeroCampos(){
		return mysqli_num_fields($this->Consulta_ID);
	}
	
	function nuevoId(){
		return mysqli_insert_id($this->link);
	}
	
	function Nombretabla(){
		$info_campo = mysqli_fetch_field_direct($this->Consulta_ID, 1);
		return $info_campo->name;
	}
	
	function flagscampo($numcampo){
		$info_campo = mysqli_fetch_field_direct($this->Consulta_ID, $numcampo);
		return $info_campo->flags;
	}
	
	function NumeroRegistros(){
		return mysqli_num_rows($this->Consulta_ID);
	}
	
	
	function nombrecampo($numcampo){
		$info_campo = mysqli_fetch_field_direct($this->Consulta_ID, $numcampo);
		return $info_campo->name;
	}
	
	function tipocampo($numcampo){
		$info_campo = mysqli_fetch_field_direct($this->Consulta_ID, $numcampo);
		return $this->mysql_data_type_hash[$info_campo->type];
	}
	
	function tamaniocampo($numcampo){
		if(!is_int($numcampo)){$numcampo=1;}
		$info_campo = mysqli_fetch_field_direct($this->Consulta_ID, $numcampo);
		return $info_campo->length/3;
	}
	
	function VerRegistro(){
		return mysqli_fetch_array($this->Consulta_ID);
	}
	
	function verRegistros(){
		return mysqli_fetch_row($this->Consulta_ID);
	}
	
	function resultadoSimple($row){
		$this->Consulta_ID->data_seek($row); 
		$datarow = $this->Consulta_ID->fetch_array(); 
		return $datarow[0];
	}
	function registrosAfectado(){
		return mysqli_affected_rows($this->link);
	}
	//	Commit&Rollback
	function autoCommit($switch=TRUE){
		mysqli_autocommit($this->link, $switch);
	}
	function Commit(){
		mysqli_commit($this->link);
	}
	function Rollback(){
		mysqli_rollback($this->link);
	}
	
}
?>