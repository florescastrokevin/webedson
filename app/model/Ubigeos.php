<?php

class Ubigeos

{

	private $_msgbox;

	

	private $id_provincia;	

	private $id_distrito;

	private $id_departamento;	

		

	private $name_provincia;	

	private $name_distrito;	

	private $name_departamento;	

	

	

	public function __construct(){}

	

	

	public function getRegiones()

	{

		$query = new Consulta("SELECT * FROM departamento WHERE id_pais=168 ORDER BY 1");

		while($row = $query->VerRegistro())

		{

			$datos[] = array(

				'id_dep'	=> $row['id_departamento'],

				'nombre'	=> $row['nombre_departamento']

			);	

		}		

		return $datos;

	}

	

	public function getPaises(){

		$query = new Consulta("SELECT * FROM pais");

		while($row = $query->VerRegistro()){

			$datos[] = array(

				'id_pais'	=> $row['id_pais'],

				'nombre'	=> $row['nombre_pais']

			);	

		}		

		return $datos;

	}

	

	public function getProvincias()

	{

		$query = new Consulta("SELECT * FROM provincia ");

		while($row = $query->VerRegistro())

		{

			$datos[] = array(

				'id'	=> $row['id_provincia'],

				'nombre'	=> $row['nombre_provincia']

			);	

		}		

		return $datos;

	}

	

	public function getDistritos($id = 0)	

	{

		if ($id == 0){

			$query = new Consulta("SELECT * FROM distritos");

		}else{

			$query = new Consulta("SELECT * FROM distritos WHERE id_provincia = '".$id."'");

		}

		

		while($row = $query->VerRegistro())

		{

                    $datos[] = array(

                            'id'    => $row['id_distrito'],

                            'nombre'=> $row['nombre_distrito'],

                            'tarifa'=> $row['tarifa_envio_distrito']

                    );	

		}		

		return $datos;

	}

        

        public function getDistritosConCobertura()	

	{

		 

                $query = new Consulta("SELECT * FROM distritos WHERE cobertura_envio_distrito = '1' ORDER BY nombre_distrito");

		

		while($row = $query->VerRegistro())

		{

                    $datos[] = array(

                            'id'    => $row['id_distrito'],

                            'nombre'=> $row['nombre_distrito'],

                            'tarifa'=> $row['tarifa_envio_distrito']

                    );	

		}		

		return $datos;

	}

	

	// $id_prov = substr($id_distrito, 0, -2);

	// public function get_name_

	

	

	public function set_ubigeo($id_distrito){

		

		

		$query = new Consulta("SELECT * FROM distritos WHERE id_distrito = '".$id_distrito."' ");

		$row = $query->VerRegistro();			

		$this->id_provincia = $row['id_provincia'];

		$this->id_distrito = $row['id_distrito'];

		

		$query_p = new Consulta ("SELECT * FROM provincia WHERE id_provincia = '".$this->id_provincia."'");

		$row_p = $query_p->VerRegistro();			

		

		$this->id_departamento = $row_p['id_departamento'];

		

		$this->name_provincia = $this->get_name_provincia($this->id_provincia);	

		$this->name_distrito = $this->get_name_distrito($this->id_distrito);

		$this->name_departamento = $this->get_name_departamento($this->id_departamento);		

				

	}

	

	public function __get($attribute){

		return	$this->$attribute;

	}

	

	public function get_name_departamento($id){

		$query = new Consulta("SELECT * FROM departamento WHERE id_departamento = '".$id."' ");

		$row = $query->VerRegistro();	

		return $row['nombre_departamento'];

	}

	

	public function get_name_provincia($id){

		$query = new Consulta("SELECT * FROM provincia WHERE id_provincia = '".$id."' ");

		$row = $query->VerRegistro();	

		return $row['nombre_provincia'];

	}

	

	public function get_name_distrito($id){

		$query = new Consulta("SELECT * FROM distritos WHERE id_distrito = '".$id."' ");

		$row = $query->VerRegistro();	

		return $row['nombre_distrito'];

	}

	static public function getDistritoCoordenada($id_distrito,$coordenada){
		$sql = "SELECT ".$coordenada." FROM distritos INNER JOIN distritos_coordenadas USING(id_distrito) WHERE id_distrito='".$id_distrito."' AND cobertura_envio_distrito = '1' ";
		
		$query = new Consulta($sql);
		$row = $query->VerRegistro();
		return $row[$coordenada];
	}

}

 ?>