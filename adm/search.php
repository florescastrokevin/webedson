<?php include("inc.aplication_top.php");

$q = strtolower($_GET["term"]);
if (!$q) return;
switch($_GET['tipo'])
{
	case 'insumos'	: $sql = new Consulta("SELECT id_insumo, nombre_insumo FROM insumos");break;
	case 'proveedores'	: $sql = new Consulta("SELECT id_proveedor, nombre_proveedor FROM proveedores"); break;
	case 'tipo_insumo': $sql = new Consulta("SELECT id_tipo_insumo, nombre_tipo_insumo FROM tipos_insumos"); break;
	case 'contacto'	: $sql = new Consulta("SELECT id_contacto, CONCAT(nombre_contacto,' ',apellidos_contacto) FROM contactos"); break;
	case 'asistente': $sql = new Consulta("SELECT id_usuario, CONCAT(nombre_usuario,' ',apellidos_usuario) FROM usuarios"); break;// WHERE id_rol=7
	case 'usuario'	: $sql = new Consulta("SELECT id_usuario, CONCAT(nombre_usuario,' ',apellidos_usuario) FROM usuarios"); break;
	case 'proyecto'	: $sql = new Consulta("SELECT id_proyecto, nombre_proyecto FROM proyectos"); break;
	case 'cotizacion'	: $sql = new Consulta("SELECT id_cotizacion, numero_cotizacion FROM cotizaciones"); break;
}
	
while($row = $sql->VerRegistro())
{
	$items[$row[1]] = $row[0]."-".$row[1];
}
/*******************************************************************/
function array_to_json( $array ){
    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}

$result = array();
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	}
	if (count($result) > 11)
		break;
}
echo array_to_json($result);
?>