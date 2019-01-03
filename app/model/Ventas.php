<?php
class Ventas{
    public function __construct($msg=''){
            $this->_msgbox = $msg;
    }

    public function VolumenVentas(){		

        $mesActual = date('Y-m-d H:i:s ',mktime(0, 0, 0, date("m"),1,date("Y")));
        $fecha_incio = (isset($_POST['fecha_desde'])) ? fecha_hora_html_sql($_POST['fecha_desde']) : '2013-09-01 00:00:00';
        $fecha_fin = (isset($_POST['fecha_hasta'])) ? fecha_hora_html_sql($_POST['fecha_hasta'],TRUE) : date("Y-m-d H:i:s"); 
        $cobertura = new Ubigeos();
        $distritos = $cobertura->getDistritosConCobertura();
        $total_distritos = count($distritos);    
        ?> 
        <div id="content-area">
            <h2>Volumen de Ventas</h2>
            <div class="col-xs-12 col-sm-4 col-md-2" style="background-color:#e0f1f9" >
                <h3>Filtros</h3>
                <form action="" onsubmit="return validate_filtro_ventas(this)" method="post" name="productos" class="form-group" >
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group"><label>Distrito: </label> 
                            <select type="text" class="form-control" name="fecha_hasta" id="fechaf" value="<?php echo $fecha_fin?>">
                                <option value="0">Seleccionar</option><?php 
                                for($i = 0; $i < $total_distritos; $i++){ ?>
                                <option value="<?php echo $distritos[$i]["id"] ?>"><?php echo $distritos[$i]["nombre"] ?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group"><label>Fecha desde: </label> <input type="text" class="form-control" size="19" name="fecha_desde" id="fechai" value="<?php echo $fecha_incio?>"></div>
                    </div>    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group"><label>Fecha hasta: </label> <input type="text" class="form-control" size="19" name="fecha_hasta" id="fechaf" value="<?php echo $fecha_fin?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group"><input id="submitv" type="submit" value="Filtrar" class="btn btn-primary" ></div>
                    </div>
                </form> 
            </div>
            <div class="col-xs-12 col-sm-6 col-md-10" style="background-color:#fff">
                <?php
                $ventas_x_distrito = $this->getVentasXDistrito();
                $total_ventas_x_distrito = count($ventas_x_distrito);
                ?>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                  google.charts.load('current', {'packages':['corechart']});
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Ventas', 'Ventas x Distrito'] <?php
                        for($d=0; $d < $total_ventas_x_distrito; $d++){ ?>,['<?php echo $ventas_x_distrito[$d]["nombre"] ?>',<?php echo $ventas_x_distrito[$d]["total"] ?>] <?php  } ?> 
                    ]);

                    var options = {
                      title: 'Ventas x Distrito'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                  }
                </script>

            <div id="piechart" style="width:500px; height:300px;"></div>
 
                
                <table cellspacing="0" cellpading="0" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left" class='titulo'>Cliente</th>
                        <th align="left" class='titulo'>Cantidad</th>
                        <th align="left" class='titulo'>Monto</th>
                   </tr>
                </thead> <?php   
                $x = 1;
                $z = 0;
                $montoTotal = 0;
                $sql = "SELECT p.id_pedido , 
                            c.id_cliente,
                            CONCAT(c.id_cliente,': ',c.nombre_cliente,' ',c.apellidos_cliente) AS Cliente,
                            p.fecha_pedido
                        FROM pedidos p, clientes c
                        WHERE p.id_cliente = c.id_cliente
                            AND (p.estado_pedido = '%Pagado%' OR p.estado_pedido = 'Entregado')
                            AND p.fecha_pedido BETWEEN DATE '".$fecha_incio."' AND DATE '".$fecha_fin."'
                        GROUP BY p.id_pedido ORDER BY p.id_cliente , p.fecha_pedido DESC LIMIT 0,100";
                //echo $sql;
                $queryP = new Consulta($sql); 	
            if($queryP->numeroRegistros()>0){
                while($row = $queryP->VerRegistro()){
                    $tmps[$row['Cliente']] += Pedidos::PedidosMonto($row['id_pedido']);
                    asort($tmps);
                    $tmps = array_reverse($tmps);			
                }
                $y = 1; ?>
                <tbody class="body"> <?php
                    foreach( $tmps as $cliente=>$monto  ){
                        $id_cliente = (int)$cliente;
                        $cantidad = Cliente::CantidadPedidos($id_cliente);
                        $montoTotal+=$monto;   ?>
                    <tr class="row <?php echo ($x % 2 == 0) ? 'odl' : ''; ?> <?php echo $marcar_fila; ?>">
                        <td class='celda'><?php echo $cliente?></td>
                        <td><?php echo $cantidad ?></td>
                        <td>$<?php echo $monto?></td>
                    </tr>
                    <?php
                        if($x==0){$x++;}else{$x=0;}
                        $z++;   
                    }
            } ?>
                </tbody>
            </table>	
            <h1>Monto total : $<?php echo number_format($montoTotal,2);?></h1>    
            </div> 
        </div>    <?php
	}
	
	public function getVentas(){
		
	}
        
        public function dashboardVentas(){ ?>
            
            
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <fieldset> 
                        <legend> Cantidad Ventas </legend>
                    </fieldset>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <fieldset> 
                        <legend> Monto Ventas </legend>
                    </fieldset>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <fieldset> 
                        <legend> Evolución Ventas </legend>
                    </fieldset>
                </div>
                
                
                </div>
            
            
                
                
                <?php
        }
        
    public function getVentasXDistrito(){
        $sql = "SELECT nombre_distrito, count(pd.id_distrito) as total 
            FROM pedidos p, pedidos_destinatarios pd, distritos d
            WHERE p.id_pedido = pd.id_pedido AND pd.id_distrito = d.id_distrito AND d.cobertura_envio_distrito = 1 AND (p.estado_pedido like '%Pagado%' OR p.estado_pedido = 'Entregado') GROUP BY pd.id_distrito
            ORDER BY total DESC;";
        $query = new Consulta($sql); 
        while($row = $query->VerRegistro()){
            $ventas[] = array(
                'nombre'        => $row["nombre_distrito"],
                'total'    => $row["total"]
                );
            }
            return $ventas;
    }    
}