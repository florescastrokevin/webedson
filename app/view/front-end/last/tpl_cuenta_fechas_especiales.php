<?php  
$ubigeo = new Ubigeos($msg);    
$pais = $ubigeo->getPaises();
$cliente = $cuenta->getCliente();
$fechas_especiales = Cliente::getFechasEspecialesClientes($cliente->__get('_id'));
$ocasiones = @Ocasiones::getOcasiones();
$destinatarios = Destinatarios::getTiposDestinatarios();
?>
    <div class="offcanvas-wrapper">
      <!-- INICIA PAGINA -->
      
      <!-- Page Content-->
      <div class="container padding-bottom-3x padding-top-2x mb-2">
        <div class="row">
          <div class="col-lg-4">
            <?php include(_tpl_includes_ . 'inc.menu_cuenta.php');?>
          </div>
          <div class="col-lg-8">
            <div class="contenedor-titulo-menu-usuario">
              <span class="titulo-menu-usuario">Fechas Especiales</span>
              <!-- <span class="eliminar-menu-usuario"><a>Eliminar &nbsp;<i class="fas fa-times"></i></a></span> -->
              <span class="agregar-menu-usuario" onclick="addFechaEspecial(<?php echo $cliente->__get('_id') ?>)"><a>Agregar</a></span>
            </div>
            <table class="table table-hover table-responsive">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Destinatario</th>
                  <th>Tipo</th>
                  <th>Ocasión</th> 
                  <th>Teléfono</th>
                  <th>Fecha Especial</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="container-body-fechas-especiales">               
                <?php 
                $i=1;
                if (is_array($fechas_especiales) && count($fechas_especiales)>0) {
                foreach ($fechas_especiales as $key => $fecha_especial) { ?>
                <tr>
                  <td ><?php echo $i ?></td>
                  <td ><?php echo $fecha_especial['nombre_destinatario'].' '.$fecha_especial['apellidos_destinatarios'] ?></td> 
                  <td ><?php echo $fecha_especial['nombre_tipo_destinatario'] ?></td> 
                  <td ><?php echo $fecha_especial['nombre_ocasion'] ?></td> 
                  <td ><?php echo $fecha_especial['telefono_destinatario'] ?></td> 
                  <td >
                    <?php if ($fecha_especial['fecha_especial']!='') {
                      echo fecha_short($fecha_especial['fecha_especial']);
                    }else{ ?>
                      <button type="button" class="btn btn-outline-warning btn-sm btn-less-height-margin" onclick="completaFechaEspecial(<?php echo $fecha_especial['id_destinatario'] ?>,'<?php echo $fecha_especial['nombre_destinatario'].' '.$fecha_especial['apellidos_destinatarios'] ?>')">Asignar</button>
                    <?php } ?>
                  </td>
                  <td class="text-center columna-opciones">
                  <?php if ($fecha_especial['fecha_especial']!=''): ?>
                    <a onclick="verDetalleFechaEspecial(<?php echo $fecha_especial['id_fecha_especial']?>)" class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Detalle"><i class="icon-search"></i></a>
                    <a class="text-danger" onclick="deleteFecha(<?php echo $fecha_especial['id_fecha_especial']?>)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="icon-cross"></i></a>
                  <?php endif ?>
                  </td>
                </tr> 
                <?php $i++; } } ?>  
              </tbody>
            </table>
          </div>
        </div>
      </div>


    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    

    <!-- INICIO BLOQUE MODAL AGREGAR FECHA ESPECIAL -->
    <div class="modal fade" id="newFecha" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ASIGNAR FECHA ESPECIAL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="nombre_destinatario text-center"></h4>  
            <form method="post" class="form" id="nuevo-fespecial" accept-charset="utf-8">
              <input type="hidden" name="nuevo-id-cliente" id="nuevo-id-cliente" class="form-control" value="<?php echo $cliente->__get('_id') ?>">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="nuevo-nombre-fespecial" id="nuevo-nombre-fespecial" class="form-control form-control-rounded form-control-sm" value="">
                    <div class="form-control-feedback"></div>
                  </div>   
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Apellido:</label>
                    <input type="text" name="nuevo-apellido-fespecial" id="nuevo-apellido-fespecial" class="form-control form-control-rounded form-control-sm" value="">
                    <div class="form-control-feedback"></div>
                  </div>   
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Direccion:</label>
                    <textarea name="nuevo-direccion-fespecial" id="nuevo-direccion-fespecial" rows="1" class="form-control form-control-rounded form-control-sm"></textarea>
                    <div class="form-control-feedback"></div>
                  </div>   
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Referencia:</label>
                    <textarea name="nuevo-referencia-fespecial" id="nuevo-referencia-fespecial" rows="1" class="form-control form-control-rounded form-control-sm"></textarea>
                    <div class="form-control-feedback"></div>
                  </div>   
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Telefono:</label>
                    <input type="tel" name="nuevo-telefono-fespecial" id="nuevo-telefono-fespecial" class="form-control form-control-rounded form-control-sm">
                    <div class="form-control-feedback"></div>
                  </div>      
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Destinatario:</label>
                    <select name="nuevo-destinatario-fespecial" id="nuevo-destinatario-fespecial" class="form-control form-control-rounded form-control-sm">
                        <option value="">Elegir un tipo de destinatario</option>
                        <?php foreach ($destinatarios as $destinatario){?>
                            <option value="<?php echo $destinatario['id'];?>"><?php echo ucwords($destinatario['nombre']) ?></option>   
                        <?php } ?> 
                    </select>
                    <div class="form-control-feedback"></div>
                  </div>      
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Ocasión:</label>
                    <select name="nuevo-ocasion-fespecial" id="nuevo-ocasion-fespecial" class="form-control form-control-rounded form-control-sm">
                        <option value="">Elegir una ocasión</option>
                        <?php foreach ($ocasiones as $ocasion){?>
                            <option value="<?php echo $ocasion['id'];?>"><?php echo ucwords($ocasion['nombre']) ?></option>   
                        <?php } ?>
                    </select>
                    <div class="form-control-feedback"></div>
                  </div>      
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Fecha:</label>
                    <input type="date" name="nuevo-fecha-fespecial" id="nuevo-fecha-fespecial" class="form-control form-control-rounded form-control-sm fecha-especial" value="<?php echo date('d/m/Y') ?>" />
                    <div class="form-control-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="text-center">
                  <button type="button" onclick="addClienteFechaEspecial()" class="btn btn-success">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- FIN BLOQUE MODAL AGREGAR FECHA ESPECIAL -->

    <!-- INICIO BLOQUE MODAL COMPLETAR FECHA ESPECIAL -->
    <div class="modal fade" id="completaFechaEspecial" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ASIGNAR FECHA ESPECIAL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="nombre_destinatario text-center"></h4>
            <form action="" class="form" accept-charset="utf-8" id="form-add-fecha-especial">
                  <input type="hidden" name="asignar-id-destinatario" id="asignar-id-destinatario" class="form-control" value="">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Tipo de Destinatario:</label>
                          <select name="asignar-destinatario" id="asignar-destinatario" class="form-control">
                              <option value="">Elegir un tipo de destinatario</option>
                              <?php foreach ($destinatarios as $destinatario){?>
                                  <option value="<?php echo $destinatario['id'];?>"><?php echo ucwords($destinatario['nombre']) ?></option>   
                              <?php } ?> 
                          </select>
                          <div class="form-control-feedback"></div>
                        </div>      
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Ocación:</label>
                          <select name="asignar-ocasion" id="asignar-ocasion" class="form-control">
                              <option value="">Elegir una ocasión</option>
                              <?php foreach ($ocasiones as $ocasion){?>
                                  <option value="<?php echo $ocasion['id'];?>"><?php echo ucwords($ocasion['nombre']) ?></option>   
                              <?php } ?>
                          </select>
                          <div class="form-control-feedback"></div>
                        </div>      
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Fecha:</label>
                          <input type="date" class="form-control fecha-especial" name="asignar-fecha" id="asignar-fecha" value="<?php echo date('d/m/Y') ?>" />
                          <div class="form-control-feedback"></div>
                        </div>
                      </div>
                  </div>

                  <div class="text-center">
                      <button type="button" class="btn btn-success" onclick="finalizaCompletaFechaEspecial()">Guardar</button>
                  </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- FIN BLOQUE MODAL COMPLETAR FECHA ESPECIAL -->

    <!-- INICIO BLOQUE MODAL MOSTRAR DETALLE FECHA ESPECIAL -->
    <div class="modal fade" id="viewFecha" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">DETALLE DE FECHA ESPECIAL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
          </div>
        </div>
      </div>
    </div>
    <!-- FIN BLOQUE MODAL MOSTRAR DETALLE FECHA ESPECIAL -->

    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>


    


