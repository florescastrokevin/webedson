<?php
include("inc.aplication_top.php"); 

$fecha = date("Y-m-d");
$fecha_inicio = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$fecha_inicio = date ( 'm-d' , $fecha_inicio );
$fecha_final = strtotime ( '+6 day' , strtotime ( $fecha ) ) ;
$fecha_final = date ( 'm-d' , $fecha_final );

$query_distritos = new Consulta("SELECT * FROM distritos WHERE id_provincia IN(1401,1411) ORDER BY nombre_distrito");
while($row_distrito = $query_distritos->VerRegistro()){
    $distrito[$row_distrito["id_distrito"]]=$row_distrito["nombre_distrito"];
}

$query_pago = new Consulta("SELECT * FROM metodo_pago ORDER BY nombre_metodo_pago");
while($row_pago = $query_pago->VerRegistro()){
    $metodo_pago[$row_pago["id_metodo_pago"]]=$row_pago["nombre_metodo_pago"];
}

$query_ocasion = new Consulta("SELECT * FROM ocasiones ORDER BY nombre_ocasion");
while($row_ocasion = $query_ocasion->VerRegistro()){
    $ocasion[$row_ocasion["id_ocasion"]]=$row_ocasion["nombre_ocasion"];
}

//echo "Fecha: ".$fecha_inicio."---".$fecha_final;
$axos = array("2012","2013","2014","2015","2016");

foreach ($axos as $key => $axo) {
    $fecha_i = $axo."-".$fecha_inicio;
    $fecha_f = $axo."-".$fecha_final;
    $sql = "SELECT *, DATE_FORMAT(fecha_full_destinatario,'%d-%m-%Y %h:%i:%s') as fecha_envio FROM pedidos p, pedidos_destinatarios pd, clientes c WHERE p.id_pedido = pd.id_pedido AND p.id_cliente = c.id_cliente AND
             fecha_full_destinatario BETWEEN '".$fecha_i."' AND '".$fecha_f."' GROUP BY p.id_pedido ORDER BY fecha_full_destinatario ASC ";
    $query = new Consulta($sql);
    
    if($query->NumeroRegistros() > 0){
        while ($row = $query->VerRegistro() ){
        
            $nombre = $row["nombre_cliente"].' '.$row["apellidos_cliente"];
            $data[] = array(
                "id_pedido"     => $row["id_pedido"],
                "estado_pedido" => $row["estado_pedido"],
                "fecha_pedido"  => $row["fecha_pedido"],
                "fecha_envio"   => $row["fecha_envio"],
                "distrito"      => $distrito[$row["id_distrito"]],
                "id_cliente"    => $row["id_cliente"],
                "nombre_cliente"=> $nombre,
                "email_cliente"    => $row["email_cliente"],
                "metodo_pago"   => $metodo_pago[$row["id_metodo_pago"]],
                "dedicatoria"   => $row["dedicatoria_destinatario"]
            );
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <link type="text/css" rel="stylesheet" href="<?php echo _tpl_panel_css_ ?>bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo _tpl_panel_js_ ?>bootstrap.min.js"></script>

</head>
    <body>
        <table  class="table table-hover table-striped"  style="font-size:0.7rem;font-family:sans-serif " >
            <thead>
                <tr>
                    <th style="width:20px">#</th>
                    <th style="width:40px">Pedido</th>
                    <th style="width:80px">Fecha Envio</th>
                    <th style="width:60px">Estado</th>
                    <th style="width:120px">Distrito</th>
                    <th style="width:100px">Metodo de Pago</th>
                    <th style="width:100px">Cliente</th>
                    <th style="width:100px">Email Cliente</th>
                    <th style="width:400px">Comentario</th>
                    <th style="width:30px">Opción</th>
                </tr>
            </thead>
            <tbody><?php
            $total_pedidos = count($data);
            for($i=0; $i<$total_pedidos; $i++){ ?>
                <tr>
                    <td><?php echo $i+1; ?> </td>
                    <td><a target="_blank" href="pedidos.php?id=<?php echo $data[$i]["id_pedido"] ?>&action=edit"><?php echo $data[$i]["id_pedido"] ?></a></td>
                    <td><?php echo $data[$i]["fecha_envio"] ?></td>
                    <td><?php echo $data[$i]["estado_pedido"] ?></td>
                    <td><?php echo $data[$i]["distrito"] ?></td>
                    <td><?php echo $data[$i]["metodo_pago"] ?></td>
                    <td><a target="_blank" href="reporte_clientes.php?action=edit&id=<?php echo $data[$i]["id_cliente"]; ?>"><?php echo $data[$i]["nombre_cliente"]; ?></a></td>
                    <td><?php echo $data[$i]["email_cliente"] ?></td>
                    <td><?php echo $data[$i]["dedicatoria"] ?></td>
                    <td><button class="opciones btn" data-toggle="modal" data-target="#myModal">Asignar</button></td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
         
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Asignar Valores</h4>
              </div>
              <div class="modal-body">
                  <form name="form-opciones">
                      <div class="form-group">
                          <label>Ocasión:</label>
                          <select name="ocasion" id="ocasion" class="form-control">
                              <option value="0">Asignar Ocasión</option><?php
                              foreach($ocasion as $key=>$value){?>
                              <option value="<?php echo $key ?>"><?php echo $value ?></option><?php
                              } ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Fecha Especial:</label><input name="fecha_especial" id="fecha_especial" class="form-control">
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </div>
        
    </body>
</html>