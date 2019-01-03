<?php
class ICuenta {
    
    private $_cliente; 
    
    public function __construct($cliente = NULL) {
        $this->_cliente = $cliente; 
    }
     
    public function dashboard_cuenta(){ ?>
        <div id="steps"> <?php
            $tipo2 = $this->_cliente->__get('_tipo_foto');
            $foto_perfil = "";
            if ($tipo2 == 'F') {
                $foto_perfil = "https://graph.facebook.com/" . $this->_cliente->__get('_idFacebook') . "/picture";
            } else if ($tipo2 == 'C') {  //90 90     
                //$foto_perfil = _url_files_users_ . $this->_cliente->__get('_foto'); 
                $foto_perfil = _url_files_users_ . 'icon.jpg';
            } ?>
            </br>
            <!-- inicio 2da seccion -->
            <h2>
                <span class="member_image thumb_32" style="background-image: url('<?php echo $foto_perfil; ?>')"></span>
                Hola <?php echo $this->_cliente->__get('_nombre') ?>
            </h2> </br>
            <div class="card home_card clearfix">

                    <a href="cuenta.php?cuenta=misdatos" class="plastic_row">
                        <span class="glyphicon glyphicon-chevron-right chevron"></span>
                        <span class="glyphicon glyphicon-user clear_blue_bg icono_glyphicon"></span>
                        <h3>Mi Perfil</h3>
                        <span class="description">Edita tu perfil, actualiza tu nombre y foto, y gestiona otras configuraciones de tu cuenta.</span>
                    </a>
                    <a href="cuenta.php?cuenta=misAventuras" class="plastic_row">
                        <span class="glyphicon glyphicon-chevron-right chevron"></span>
                        <span class="glyphicon glyphicon-picture yolk_orange_bg icono_glyphicon"></span>
                        <h3>Mis Historias</h3>
                        <span class="description">Comparte tus historias de aventura, con fotos y videos.</span>
                    </a>
                    <!--
                    <a href="cuenta.php?cuenta=favoritos" class="plastic_row">
                            <span class="glyphicon glyphicon-chevron-right chevron"></span>
                            <span class="glyphicon glyphicon-heart-empty candy_red_bg icono_glyphicon"></span>
                            <h3>Favoritos</h3>
                            <span class="description">Revisa tus favoritos, todo lo que te has marcado como favorito.</span>
                    </a>
                    -->

            </div>
            <!-- fin 2da seccion -->
            <?php if($this->_cliente->__get("_tipo_usuario")=='1'){ ?>
            <h2>Mi Agencia</h2> </br>      
            <div class="card home_card clearfix">
                <a href="cuenta.php?actividades=all" class="plastic_row">
                    <span class="glyphicon glyphicon-chevron-right chevron"></span>
                    <span class="glyphicon glyphicon-calendar green_bg icono_glyphicon"></span>
                    <!--<h3>Eventos</h3>-->
                    <h3>Mis Actividades</h3>
                    <span class="description">Publica tus eventos, salidas y paquetes de aventura en nuestra plataforma.</span>
                </a>
                <a href="cuenta.php?cuenta=agencia&action=edit&id=<?php echo $this->_cliente->__get("_agencia")->__get("_id_agencia") ?>" class="plastic_row">
                    <span class="glyphicon glyphicon-chevron-right chevron"></span>
                    <span class="glyphicon glyphicon-ok-circle violet_bg icono_glyphicon"></span>
                    <h3>Mi Agencia</h3>
                    <span class="description">Gestiona la información de tu agencia de aventura.</span>
                </a>
            </div>
            <?php } else { ?>
            <h4>¿Tienes una <b>agencia</b> y/o organizas actividades de deportes de aventura? </h4>
                <div class="card home_card clearfix">
                    <a href="cuenta.php?cuenta=agencia&action=new" class="plastic_row" style="padding: 0px;">
                    <img src="<?php echo _imgs_ ?>afilia.jpg" style="height: 84px;width: 100%;"/>
                    </a>
                </div>
            <?php } ?>
        </div>  <?php
    }
    
    public function misdatos_cuenta(){
         
        //$cache = $obj_secciones->getConfigCache();
        
        $sql_cliente = " SELECT * FROM clientes WHERE id_cliente = '" . $this->_cliente->__get("_id") . "' ";
        $queryCliente = new Consulta($sql_cliente);
        $row = $queryCliente->VerRegistro();

        //$idCache = "list_sports";
        //$listSports = $cache->get($idCache);

        if ($listSports == null) {
            $sql = " SELECT id_deporte, nombre_deporte FROM deportes WHERE estado_deporte = 1; ";
            $query = new Consulta($sql);
            $listSports = array();
            $cnt = 0;
            while ($data = $query->VerRegistro()) {
                $listSports[$cnt]['id_deporte'] = $data['id_deporte'];
                $listSports[$cnt]['nombre_deporte'] = $data['nombre_deporte'];
                $cnt++;
            }
            //$cache->set($idCache, $listSports, MainModel::CACHE_TIME);
        }

        $listSports = Cuenta::_checkOutDeporteFavorito($listSports, $row['deporte_favorito']);

        include_once(_includes_ . 'cuenta/mis-datos-cuenta.php');
    }
 
    public function bienvenido_cuenta(){ ?>
        <div id="steps">
            <section id="panel_step">
                <section class="bienvenido_left">
                    <h2>Bienvenido a: </h2>
                    <img src="aplication/webroot/imgs/logo-sticker-mediano.jpg" class="img-responsive"/>
                </section>
                <section class="bienvenido_right">

                    <h2> Hola <?php echo $this->_cliente->__get("_nombre") ?>, empieza a participar:</h2>
                    <article class="bienvenido_texto_cuerpo">Maneja tu perfil de aventurero.</article>
                    <article><a class="bienvenido_btn btn" title="Mis Datos" href="cuenta.php?cuenta=misdatos"> Mis Datos</a></article></br>
                    <article class="bienvenido_texto_cuerpo">Comparte tus experiencias, fotos o videos con otros aventureros.</article>
                    <article><a class="bienvenido_btn btn" title="Comparte tu Aventura" href="cuenta.php?cuenta=compartir">Compartir Historia</a></article></br>
                    <article class="bienvenido_texto_cuerpo">Si tienes una agencia u organización que organiza eventos.</article>
                    <article><a class="bienvenido_btn btn" title="Solicitar Publicar Eventos" href="cuenta.php?cuenta=agencia&action=new">Solicita Publicar Eventos</a></article></br>
                </section>
            </section>
        </div>
        <?php
    }
       
    public function nuevaAventura() {
        /*
          echo '<pre>';
          print_r($_SESSION['files_act']);
          echo '</pre>';
         */
        //$aventura = new Aventura($_GET["idAventura"]);
        if (count($aventura) == 1) {
            //location('http://www.deaventura.pe/cuenta.php?cuenta=misAventuras');
        } ?>
        
        <div id="steps"  class="contanedor-creacion-salida">
            <div id="titu_step"><span class="glyphicon glyphicon-picture"></span> Comparte tu historia aventurera <a class="btn btn_nuevo" href="cuenta.php?cuenta=misAventuras" title="Nueva aventura">Regresar</a></div>
            <div id="panel_step" class="creacion-salida-grupal" style="border:none">

                <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8" name="form_update" id="form_update" onsubmit="return validaCompartirAventura(this, 'addAventura')">
                    <input name="id_aventura" id="id_aventura" type="hidden" value="">    
                <section>
                    <div class="creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>1. Detalles</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group"><label>Ponle un nombre a esta historia:</label><input name="titulo" id="titulo" class="form-control" type="text" value=""/></div>
                                <div class="form-group"><label>¿Donde fue? <i>( Lugar, Provincia y Departamento )</i>:</label><input name="lugar" id="lugar" class="form-control" type="text" value=""></div>
                                <div class="form-group">
                                    <label>Describe tu experiencia aventurera:</label>
                                    <textarea type="text" name="descripcions" id="descripcions"  class="form-control" rows="5" style="height:178px;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group"><label>Que actividad practicaste:</label>
                                    <select name="cbo_deportes" id="cbo_deportes" class="form-control">
                                        <option value="0">Elegir Deporte ...</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>Elegir Modalidad:</label>
                                    <select name="cbo_modalidad" id="cbo_modalidad" class="form-control">
                                        <option value="0">Elegir modalidad ...</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>Con que Agencia <i>(opcional)</i>:</label>
                                    <select name="cbo_agencias" id="cbo_agencias" class="form-control">
                                        <option value="0">Elegir Agencia</option>
                                    </select>
                                </div> 
                                <div class="form-group youtube">
                                    <label><img style="padding-right: 7px;vertical-align: text-top;" src="aplication/webroot/imgs/icon_youtube.jpg" width="17"/>Si tienes un video de youtube:</label>
                                    <input id="video_txt" type="text" class="form-control" placeholder="Ejm: http://www.youtube.com/watch?v=H542nLTTbu0">
                                    <input id="btn_svideo" class="btn btn_subir_archivo" type="button" value="+ Añadir video..">
                                </div>
                            </div>
                        </div>
                    </div>    
                </section> 
                    <p style="padding:12px;" class="bg-info">
                        Busca y/o mueve el pin rojo al lugar donde realizaste tu aventura y presiona el botón Finalizar.<br/> 
                                    Puedes acercarte o alejarte usando los controles de la izquierda.
                    </p>
                    <div class="aventura_descInfo creacion-bloque-formulario row">
                       <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>2. Ubicación</h2>
                        </div>
                        <!-- PANEL -->
                         
                            
                                
                        <div class=" row panel_info_aventura">
                            <div style="padding-left:15px; padding-right:15px">
                                <div class="row">
                                    <input type="text" name="origen" id="address" class="form-control" />
                                </div>
                                <div class="row">
                                    <div id="mi_ubic" style="width:100%;height:393px;margin-top:15px"></div>
                                    <input type="hidden" id="lat_pos" name="lat_pos" value="">
                                    <input type="hidden" id="lng_pos" name="lng_pos" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        <p style="padding:12px;" class="bg-info">Sugerencia: Una aventura debe tener al menos una foto, Puedes subir tus fotos de 10 en 10.</p>
                            
                    <div class="aventura_descInfo creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>3. Imagenes</h2>
                        </div>
                        <div class="rowElem fileupload-container" style="margin: 0 auto;">
                            <noscript><input type="hidden" name="redirect" value="www.deaventura.pe"></noscript>
                            <div class="container" style="width:100%">
                                
                                <div class="rowElem">
<!--                                    <label>SUBIR TUS FOTOS:</label>-->
                                    <div class="btn row fileupload-buttonbar btn_subir_archivo">
                                        <div class="span7">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                            <span class="fileinput-button">
                                                <i class="icon-plus icon-white"></i>
                                                <span> Escoger Fotos</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                                            <button type="submit" class="btn btn-primary start">
                                                <i class="icon-upload icon-white"></i>
                                                <span>Start upload</span>
                                            </button>
                                        </div>
                                    </div>
                                    <span style="color:red; font-size:11px;margin-left: 20px;"></span>                                    
                                </div>
                                
                                <!-- The loading indicator is shown during file processing -->
                                <br>
                                <div class="fileupload-loading"></div>
                                <!-- The table listing the files available for upload/download -->
                                <div class="tableTop"><div class="td1">Foto o Video</div><div class="td3">¿Eliminar?</div></div>
                                <table id="table_imgs" role="presentation" class="table table-striped">
                                    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                                </table> 
                                <br>
                            </div>
                            <!-- The template to display files available for upload -->
                            <script id="template-upload" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-upload fade">
                                <td>
                                <span class="preview"></span>
                                </td>
                                <td>
                                <p class="name">{%=file.name%}</p>
                                {% if (file.error) { %}
                                <div><span class="label label-important">Error</span> {%=file.error%}</div>
                                {% } %}
                                </td>
                                <td width="240">
                                <p class="size">{%=o.formatFileSize(file.size)%}</p>
                                {% if (!o.files.error) { %}
                                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                                {% } %}
                                </td>
                                <td width="100">
                                {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                                <button class="btn btn-primary start">
                                <i class="icon-upload icon-white"></i>
                                <span>Start</span>
                                </button>
                                {% } %}
                                {% if (!i) { %}
                                <button class="btn btn-warning cancel">
                                <i class="icon-ban-circle icon-white"></i>
                                <span></span>
                                </button>
                                {% } %}
                                </td>
                                </tr>
                                {% } %}
                            </script>
                            <!-- The template to display files available for download -->
                            <script id="template-download" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-download fade">
                                <td>
                                <span class="preview">
                                {% if (file.thumbnail_url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                                {% } %}
                                </span>
                                </td>
                                <td>
                                <p class="name">
                                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}"> {%=file.name%}</a>
                                </p>
                                {% if (file.error) { %}
                                <div><span class="label label-important">Error</span> {%=file.error%}</div>
                                {% } %}
                                </td>
                                <td>
                                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                </td>
                                <td>
                                <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                <i class="icon-trash icon-white"></i>
                                <span>Delete</span>
                                </button>
                                <input type="checkbox" name="delete" value="1" class="toggle">
                                </td>
                                </tr>
                                {% } %}
                            </script>
                        </div>
                        <div style="display:table;width: 94%;">    
                            <div style="float: right;">
                                <input class="btn btn_subir_archivo" id="subir_archivos" type="button" value="Subir Fotos">
                            </div>
                        </div>
                        
                        <div class="panel_info_aventura" id="listado_archivos">
                            <ul id="list_item">
                                
                            </ul>
                            <div class="clear"></div>
                             
                        </div>
                        <div class="panel_info_aventura2"></div>
                        
                        <div class="clear"></div>
                        <br/><br/>
                        <div align="center" class="pnl_btn">
                            <a href="<?php echo _url_; ?>cuenta.php?cuenta=misAventuras">
                                <input class="cancel_blanck" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0% 0%;color: #2ab27b;font-size: 0.9em;width: 6.5em;" type="bottom" value="x Cancelar">
                            </a>
                            <input class="btn btn_guardar" type="submit" value="Guardar >" style="display:none">
                        </div>
                </div>
                </form>
        
                <div class="clear"></div>
            </div>

        </div>
        <?php
        if (isset($_SESSION['files_act'])) {
            $temp_files = $_SESSION['files_act'];
            foreach ($temp_files as $value) {
                $nombre_ant = _host_avfiles_users_ . $value;
                if (file_exists($nombre_ant))
                    unlink($nombre_ant);

                $thumb = _host_avfiles_users_ . 'thumbnail/' . $value;
                if (file_exists($thumb))
                    unlink($thumb);
            }
            unset($_SESSION['files_act']);
        }
    }

    public function editAventura() {
        /*
          echo '<pre>';
          print_r($_SESSION['files_act']);
          echo '</pre>';
         */
        $aventura = new Aventura($_GET["idAventura"]);
        if (count($aventura) == 1) {
            //location('http://www.deaventura.pe/cuenta.php?cuenta=misAventuras');
        }
        /*
          echo '<pre>';
          print_r($aventura);
          echo '</pre>';
         */
        $array_files = $aventura->__get('_archivos');
        $modalidad = new Modalidad($aventura->__get("_id_modalidad"));
        $aventuras = new Aventuras();
        $url_aventura = _url_ . $aventuras->url_Aventura($modalidad->__get("_deporte")->__get("_nombre_deporte"), $aventura->__get("_id_aventura"), $aventura->__get('_titulo_aventura')); ?>
        
        <div id="steps"  class="contanedor-creacion-salida">
            <div id="titu_step"><span class="glyphicon glyphicon-picture"></span> Editar Aventura <a class="btn btn_nuevo" href="cuenta.php?cuenta=misAventuras" title="Nueva aventura">Regresar</a></div>
            <div id="panel_step" class="creacion-salida-grupal" style="border:none">
                
                    <section>
                        <div class="aventura_panel modify creacion-bloque-formulario row">
                            <div class="pnl1"><img src="aplication/utilities/timthumb.php?src=<?php echo _url_avfiles_users_ . $array_files[0]['nombre_aventuras_archivos'] ?>&h=120&w=120&zc=1"/></div>
                            <div class="pnl2">
                                <h1><?php echo $aventura->__get('_titulo_aventura') ?><span><?php echo fecha_long($aventura->__get('_fecha_creacion_aventura')) ?></span></h1>
                                <ul class="info_social">
                                    <li class="photo"><?php echo $aventura->__get('_cant_images') ?></li>
                                    <li class="coment"><?php echo $aventura->__get('_cant_coments_aventura') ?></li>
                                    <li class="like"><?php echo $aventura->__get('_cant_likes_aventura') ?></li>
                                </ul><br/>
                                <a href="<?php echo $url_aventura ?>"><?php echo $url_aventura ?><img src="aplication/webroot/imgs/icon_mas.jpg" width="16" height="17"></a>
                            </div>
                             					
                        </div>
                    </section>
                <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8" name="form_update" id="form_update" onsubmit="return validate_updateAv(this, 'updateAventura')">
                    <input name="id_aventura" id="id_aventura" type="hidden" value="<?php echo $aventura->__get("_id_aventura") ?>">    
                <section>
                    <div class="creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>1. Detalles</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group"><label>Ponle un nombre a tu historia:</label><input name="titulo" id="titulo" class="form-control" type="text" value="<?php echo $aventura->__get('_titulo_aventura') ?>"/></div>
                                <div class="form-group"><label>¿Donde fue? <i>( Lugar, Provincia y Departamento )</i></label><input name="lugar" id="lugar" class="form-control" type="text" value="<?php echo $aventura->__get('_lugar_aventura') ?>"></div>
                                <div class="form-group">
                                    <label>Describe tu experiencia:</label>
                                    <textarea type="text" name="descripcions" id="descripcions"  class="form-control" rows="5" style="height:178px;"><?php echo $aventura->__get('_descripcion_aventura') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group"><label>¿Que actividad realizaste?:</label>
                                    <select name="cbo_deportes" id="cbo_deportes" class="form-control">
                                        <option value="0">Elegir Deporte ...</option>
                                    </select>
                                    <script type="text/javascript">
                                    $.post("ajax.php", {deportes: '1'}, function(data) {
                                    if (data != "") {
                                            $("#cbo_deportes").html(data);
                                            $("#cbo_deportes").val(<?php echo $aventura->__get('_deporte')->__get('_id_deporte') ?>);
                                        }
                                    })
                                    </script>
                                </div>
                                <div class="form-group"><label>Elegir Modalidad:</label>
                                    <select name="cbo_modalidad" id="cbo_modalidad" class="form-control">
                                        <option value="0">Elegir modalidad ...</option>
                                    </select>
                                    <script type="text/javascript">
                                        $.post("ajax.php", {idCbo:<?php echo $aventura->__get('_deporte')->__get('_id_deporte') ?>}, function(data) {
                                            if (data != "") {
                                                $("#cbo_modalidad").append(data);
                                                $("#cbo_modalidad").val(<?php echo $aventura->__get('_id_modalidad') ?>);
                                            }
                                        })
                                    </script>
                                </div>
                                <div class="form-group"><label>Elegir Agencia (opcional):</label>
                                    <select name="cbo_agencias" id="cbo_agencias" class="form-control">
                                        <option value="<?php echo $aventura->__get('_agencia')->__get('_id_agencia') ?>"><?php echo $aventura->__get('_agencia')->__get('_nombre_agencia') ?></option>
                                        
                                    </select>
                                    <script type="text/javascript">
                                        $.post("ajax.php", {agencias:1}, function(data) {
                                            if (data != "") {
                                                $("#cbo_agencias").append(data);
                                                $("#cbo_agencias").val(<?php echo $aventura->__get('_agencia')->__get('_id_agencia') ?>);
                                            }
                                        });
                                    </script>
                                </div> 
                                <div class="form-group youtube">
                                    <label><img style="padding-right: 7px;vertical-align: text-top;" src="aplication/webroot/imgs/icon_youtube.jpg" width="17"/>Si tienes un video de youtube:</label>
                                    <input id="video_txt" type="text" size="30" placeholder="Ejm: http://www.youtube.com/watch?v=H542nLTTbu0">
                                    <input id="btn_svideo" class="btn btn_subir_archivo" type="button" value="+ Añadir video..">
                                </div>
                            </div>
                        </div>
                    </div>    
                </section> 
                    <p style="padding:12px;" class="bg-info">
                        Busca y/o mueve el pin rojo al lugar donde realizaste tu aventura y presiona el botón Finalizar.<br/> 
                                    Puedes acercarte o alejarte usando los controles de la izquierda.
                    </p>
                    <div class="aventura_descInfo creacion-bloque-formulario row">
                       <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>2. Ubicación</h2>
                        </div>
                        <!-- PANEL -->
                         
                            
                                
                        <div class=" row panel_info_aventura">
                            <div style="padding-left:15px; padding-right:15px">
                                <div class="row">
                                    <input type="text" name="origen" id="address" class="form-control" />
                                </div>
                                <div class="row">
                                    <div id="mi_ubic" style="width:100%;height:393px;margin-top:15px"></div>
                                    <input type="hidden" id="lat_pos" name="lat_pos" value="<?php echo $aventura->__get('_lat_aventura') ?>">
                                    <input type="hidden" id="lng_pos" name="lng_pos" value="<?php echo $aventura->__get('_lng_aventura') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        <p style="padding:12px;" class="bg-info">Sugerencia: Una aventura debe tener al menos una foto si quiere mantenerlo activa.</p>
                            
                    <div class="aventura_descInfo creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>3. Imagenes</h2>
                        </div>

                        <div class="panel_info_aventura" id="listado_archivos">
                            <ul id="list_item"> <?php
                                $arr = $aventura->__get('_archivos');
                                foreach ($arr as $valor) { ?>
                                    <li id="arch<?php echo $valor['id_aventuras_archivo'] ?>">
                                        <div class="panel_comparte">
                                            <div class="delete"><input class="id_delete" type="hidden" value="<?php echo $valor['id_aventuras_archivo'] ?>"/></div>
                                            <div class="left_com"></div>
                                            <div class="img_block">
                                                <input name="id_files[]" type="hidden" value="<?php echo $valor['id_aventuras_archivo'] ?>"/>
                                                <input name="src_files[]" type="hidden" value="<?php echo $valor['nombre_aventuras_archivos'] ?>"/>
                                                <input name="tipo_files[]" type="hidden" value="<?php echo $valor['tipo_aventuras_archivo'] ?>"/>
                                                <?php if ($valor['tipo_aventuras_archivo'] == 'F') { ?>
                                                    <div class="img_comparte">
                                                        <img src="aplication/utilities/timthumb.php?src=<?php echo _url_avfiles_users_ . $valor['nombre_aventuras_archivos'] ?>&h=119&w=171&zc=1"/>
                                                    <?php } else if ($valor['tipo_aventuras_archivo'] == 'V') { ?>
                                                        <div class="img_comparte"><a href="http://www.youtube.com/watch?v=<?php echo $valor['nombre_aventuras_archivos'] ?>" target="_blank"><img src="<?php echo _imgs_ ?>icon_video_ver.jpg"></a></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="descrp_comparte">
                                                <div class="rowElem"><textarea name="name="titulo_files[]""><?php echo $valor['titulo_aventuras_archivo'] ?></textarea></div>
                                            </div>
                                    </li> <?php
                                } ?>
                            </ul>
                            <div class="clear"></div>
                            <br/>
                        </div>
                        <div class="panel_info_aventura2"></div>
                        <br/>
                        <!-- PANEL -->

                        <div class="rowElem fileupload-container" style="margin: 0 auto;">
                            <noscript><input type="hidden" name="redirect" value="www.deaventura.pe"></noscript>
                            <div class="container" style="width:100%">
                                
                                <div class="rowElem">
                                    <div class="btn row fileupload-buttonbar btn_subir_archivo">
                                        <div class="span7">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                            <span class="fileinput-button">
                                                <i class="icon-plus icon-white"></i>
                                                <span>Añadir Más Fotos</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                                            <button type="submit" class="btn btn-primary start">
                                                <i class="icon-upload icon-white"></i>
                                                <span>Start upload</span>
                                            </button>
                                        </div>
                                    </div>
                                    <span style="color:red; font-size:11px;margin-left: 20px;">(Puede subir sus fotos de 10 en 10)</span>                                    
                                </div>
                                
                                <!-- The loading indicator is shown during file processing -->
                                <br>
                                <div class="fileupload-loading"></div>
                                <!-- The table listing the files available for upload/download -->
                                <div class="tableTop"><div class="td1">Foto o Video</div><div class="td3">¿Eliminar?</div></div>
                                <table id="table_imgs" role="presentation" class="table table-striped">
                                    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                                </table> 
                                <br>
                            </div>
                            <!-- The template to display files available for upload -->
                            <script id="template-upload" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-upload fade">
                                <td>
                                <span class="preview"></span>
                                </td>
                                <td>
                                <p class="name">{%=file.name%}</p>
                                {% if (file.error) { %}
                                <div><span class="label label-important">Error</span> {%=file.error%}</div>
                                {% } %}
                                </td>
                                <td width="240">
                                <p class="size">{%=o.formatFileSize(file.size)%}</p>
                                {% if (!o.files.error) { %}
                                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                                {% } %}
                                </td>
                                <td width="100">
                                {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                                <button class="btn btn-primary start">
                                <i class="icon-upload icon-white"></i>
                                <span>Start</span>
                                </button>
                                {% } %}
                                {% if (!i) { %}
                                <button class="btn btn-warning cancel">
                                <i class="icon-ban-circle icon-white"></i>
                                <span></span>
                                </button>
                                {% } %}
                                </td>
                                </tr>
                                {% } %}
                            </script>
                            <!-- The template to display files available for download -->
                            <script id="template-download" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-download fade">
                                <td>
                                <span class="preview">
                                {% if (file.thumbnail_url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                                {% } %}
                                </span>
                                </td>
                                <td>
                                <p class="name">
                                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}"> {%=file.name%}</a>
                                </p>
                                {% if (file.error) { %}
                                <div><span class="label label-important">Error</span> {%=file.error%}</div>
                                {% } %}
                                </td>
                                <td>
                                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                </td>
                                <td>
                                <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                <i class="icon-trash icon-white"></i>
                                <span>Delete</span>
                                </button>
                                <input type="checkbox" name="delete" value="1" class="toggle">
                                </td>
                                </tr>
                                {% } %}
                            </script>
                        </div>
                        <div style="display:table;width: 90%;">    
                            <div style="float: right;">
                                 <input class="btn btn_subir_archivo" id="subir_archivos" type="button" value="Subir archivos">
                            </div>
                        </div>

                        <div class="clear"></div>
                        <br/><br/>
                        <div align="center">
                            <!--<input class="btn_style2" type="button" value="x Cancelar" onclick="javascript: window.location = 'cuenta.php?cuenta=misAventuras'">-->
							<input class="btn btn_cancelar_archivo" type="button" value="x Cancelar" onclick="javascript: window.location = 'cuenta.php?cuenta=misAventuras'">
                            <!--<input class="btn btn_subir_archivo" id="subir_archivos" type="button" value="Subir archivos">-->
                            <input class="btn btn_guardar" type="submit" value="Guardar Cambios >">
                        </div>
                </div>
                </form>
        
                <div class="clear"></div>
            </div>

        </div>
        <?php
        if (isset($_SESSION['files_act'])) {
            $temp_files = $_SESSION['files_act'];
            foreach ($temp_files as $value) {
                $nombre_ant = _host_avfiles_users_ . $value;
                if (file_exists($nombre_ant))
                    unlink($nombre_ant);

                $thumb = _host_avfiles_users_ . 'thumbnail/' . $value;
                if (file_exists($thumb))
                    unlink($thumb);
            }
            unset($_SESSION['files_act']);
        }
    }
    
    public function editReserva(){ 
        $obj_reserva = new Reserva($_GET["idReserva"]);
        //$obj_actividad = new Actividad($obj_reserva->__get("_actividad")->);
        ?>
        
        <div id="steps"  class="contanedor-creacion-salida">
            <div id="titu_step"><span class="glyphicon glyphicon-picture"></span> Detalle Reserva <a class="btn btn_nuevo" href="cuenta.php?cuenta=misAventuras" title="Nueva aventura">Regresar</a></div>
            <div id="panel_step" class="creacion-salida-grupal" style="border:none">
                
                    <section>
                        <div class="aventura_panel modify creacion-bloque-formulario row">
                            <div class="pnl1"><img src="aplication/utilities/timthumb.php?src=<?php echo _url_._url_evento_img_ . $obj_reserva->__get("_actividad")->__get("_imagen") ?>&h=250&w=250&zc=1"/></div>
                            <div class="pnl2">
                                <h2><?php echo $obj_reserva->__get("_actividad")->__get('_nombre') ?></h2>
                                <h3><?php echo $obj_reserva->__get("_actividad")->__get('_lugar') ?></h3>
                                <h3><?php echo fecha_long($obj_reserva->__get('_fecha')) ?></h3>
                                <a target="_blank" href="<?php echo $obj_reserva->__get("_actividad")->__get('_url') ?>"><?php echo $obj_reserva->__get("_actividad")->__get('_url') ?><img src="aplication/webroot/imgs/icon_mas.jpg" width="16" height="17"></a>
                            </div>				
                        </div>
                    </section>
                <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8" name="form_update" id="form_update" onsubmit="return validate_updateAv(this, 'updateAventura')">
                    <input name="id_reserva" id="id_reserva" type="hidden" value="<?php echo $obj_reserva->__get("_id_reserva") ?>">    
                <section>
                    <div class="creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>Reserva # <?php echo $obj_reserva->__get('_id_venta') ?></h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h4><strong>Datos de Reserva</strong></h4>
                                <div class="form-group">Nro Reserva:<?php echo $obj_reserva->__get('_id_venta') ?></div>
                                <div class="form-group">Fecha de Reserva:<?php echo $obj_reserva->__get('_lugar_aventura') ?></div>
                                 
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h4><strong>Inscritos / Tarifa</strong></h4> <?php 
                                $inscritos = $obj_reserva->__get("_detalle");
                                $total_inscritos = count($inscritos);
                                if(is_array($inscritos) && $total_inscritos > 0){
                                    for($x =0; $x < $total_inscritos; $x++){ ?>
                                        <div class="form-group"><?php echo $inscritos[$x]["cantidad"].": ".$inscritos[$x]["nombre"]."(".$obj_reserva->__get("_actividad")->__get("_tipo_cambio")->__get("_valor_tipo_cambio").$inscritos[$x]["precio"].")" ?> </div><?php
                                    }  
                                } ?>
                                
                            </div>
                        </div>
                    </div>    
                </section> 
                <section>
                    <div class="creacion-bloque-formulario row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2>Forma de Pago</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">Monto:<?php echo $obj_reserva->__get('_monto') ?></div>
                                <div class="form-group">Pago:<?php echo $obj_reserva->__get("_actividad")->__get("_agencia")->__get('_datos_bancarios_agencia') ?></div>
                                 
                            </div>
                             
                        </div>
                    </div>    
                </section>      
                    
                    
                </form> 
            </div>

        </div>
        <?php 
    }

    public function confirmacionAventura($id_aventura) {

//        if ($_POST["action"] != "step4") {
//            location("cuenta.php?cuenta=compartir");
//        } else {
//            unset($_POST["action"]);
//        }
        $obj_aventura = new Aventura($id_aventura);
        $aventura = new Aventuras();
        $url_nuevo = _url_ . $aventura->url_Aventura($obj_aventura->__get("_deporte")->__get("_nombre_deporte"), $obj_aventura->__get("_id_aventura"), $obj_aventura->__get("_titulo_aventura"));
        ?>
        <div id="steps">
            <div id="panel_step">
                <div id="titu_step">Historia de Aventura Compartida<span></span></div>
                <div class="felicidades">
                    <div id="mensaje_termino">
                        <h1>Felicidades! Compartiste tu Aventura con el Mundo:</h1>
                        <p>y de paso ayudaste a difundir los deportes de aventura en el Perú.</p>
                        <br/>
                        <p>Tu Aventura se mostrará en tu Muro del Facebook y en el website DeAventura.pe en:</p>
                        <a href="<?php echo $url_nuevo ?>"><?php echo $url_nuevo ?></a>

                        <p>Si quieres puedes compartirlo en otras redes sociales:</p>
                        <br/>
                        <div class="socials">
                            <ul>
                                <li><div class="fb-like" data-href="<?php echo $url_nuevo ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div></li>
                                <li><a class="twitter-share-button" href="https://twitter.com/share" data-url="<?php echo $url_nuevo ?>" data-text="Aventura" data-lang="es">Twittear</a>
                                    <script>!function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (!d.getElementById(id)) {
                                                js = d.createElement(s);
                                                js.id = id;
                                                js.src = "//platform.twitter.com/widgets.js";
                                                fjs.parentNode.insertBefore(js, fjs);
                                            }
                                        }(document, "script", "twitter-wjs");</script></li>
                                <li><a class="pinterest" data-pin-config="beside" data-pin-do="buttonPin" href="//pinterest.com/pin/create/button/?url=<?php echo $url_nuevo ?>%2F&media=&description="><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></li>
                                <li><div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $url_nuevo ?>"></div></li>
                                <li><a id="email_bt" href="mailto:"></a>   </li>
                                 
                            </ul>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-509974205a5b2732"></script>
                        <br><br><br><br><br><br><br>
                        <p>
                            - <a href="<?php echo _url_.'cuenta.php?cuenta=compartir'; ?>">Sube una Nueva Historia de Aventura</a>
                        </p>
                        <p>
                            - <a href="<?php echo _url_.'cuenta.php?cuenta=misAventuras'; ?>">Ir a Tus Historias de Aventuras</a>
                        </p>
                        <!-- AddThis Button END -->   
                    </div>
                </div>
                <div class="clear"></div>
            </div>

        </div>
        <?php
        unset($_SESSION["miaventura"]);
        unset($_SESSION['files_act']);
    }

    public function misAventuras() {  ?>
        <div id="steps">
            <div id="titu_step"> <span class="glyphicon glyphicon-picture"></span> Mis Historias <a class="btn btn_nuevo" href="cuenta.php?cuenta=compartir" title="Nueva aventura">Nueva Historia</a></div>
            <div id="panel_step">
            <?php
            $obj_aventuras = new Aventuras();
            $aventuras = $obj_aventuras->getAventurasPorCliente($this->_cliente->__get("_id"));
            $total_aventuras = count($aventuras);
            if ($total_aventuras > 0) { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>#</th>
                          <th>Publicado</th>
                          <th>Fotos</th>
                          <th>Vistas</th>
                          <th>Historia de Aventura</th>
                          <th>Opciones</th>
                        </tr>
                    </thead>
                <?php
                for($i = 0; $i < $total_aventuras; $i++) {
                    $imagenes = Aventura::getArchivos($aventuras[$i]["id_aventura"]);
                    $cantidad_imagenes = count($imagenes);
                    $modalidad = new Modalidad($aventuras[$i]["id_modalidad"]);
                    $url_aventura = _url_ . $obj_aventuras->url_Aventura($modalidad->__get("_deporte")->__get("_nombre_deporte"),$aventuras[$i]["id_aventura"], $aventuras[$i]["titulo_aventura"]); ?>
                    <tr>
    <!--                    <td>
                            <img src="aplication/utilities/timthumb.php?src=<?php echo _url_avfiles_users_ . $rowp['nombre_aventuras_archivos'] ?>&h=100&w=100&zc=1"/>
                        </td>-->
                        <td> <?php echo $aventuras[$i]["id_aventura"]; ?> </td>
                        <td class="fecha"> <?php echo formato_slash("-",$aventuras[$i]["fecha_aventura"]) ?> </td>
                        <td> <ul class="info_social"> <li class="photo"><?php echo $cantidad_imagenes ?></li> </ul> </td>
                        <td> <?php echo $aventuras[$i]['cantidad_visitas']; ?> </td>
                        <td> <a href="<?php echo $url_aventura ?>" target="_blank"><img src="aplication/webroot/imgs/icon_mas.jpg" width="16" height="17"></a> <?php echo $aventuras[$i]['titulo_aventura'] ?></td>
                        <td>
                            <a class="btn-circle btn-edit glyphicon glyphicon-pencil" href="cuenta.php?cuenta=edit&idAventura=<?php echo $aventuras[$i]["id_aventura"]; ?>" title="editar"></a>
                            <a class="btn-circle btn-delete glyphicon glyphicon-remove" href="#" title="eliminar"><input type="hidden" value="<?php echo $rowp['id_aventura'] ?>"></a>
                        </td>
                    </tr>
                    <?php
                }?>      
              </table>
            <?php
        } else {
            echo '<br/><div align="center">No tienes aventuras para mostrar.</div>';
        }?>

                 
            </div>

        </div>
        <?php
    }
    
    public function misReservas(){ ?>
        <div id="steps">
            <div id="titu_step"> <span class="glyphicon glyphicon-picture"></span> Mis Reservas   <!--<a class="btn btn_nuevo" href="cuenta.php?cuenta=compartir" title="Nueva aventura">Nueva Aventura</a>--></div>
            <div id="panel_step">
            <?php
            $obj_reservas = new Reservas();
            $reservas = $obj_reservas->getReservasPorCliente($this->_cliente->__get("_id"));
            $total_reservas = count($reservas);
//            echo "<pre>";
//            print_r($reservas);
//            echo "</pre>";
            if ($total_reservas > 0) { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>#</th>
                          <th>Fecha</th>
                          <th>Actividad</th>
                          <th>Inscripciones</th>
                          <th>Reserva</th>
                          <th>Opciones</th>
                        </tr>
                    </thead>
                <?php
                for($i = 0; $i < $total_reservas; $i++) {
                    $inscripciones = Reserva::getInscripciones($reservas[$i]["id"]);
                    $cantidad_inscripciones = count($inscripciones);
                    //echo "...".$cantidad_inscripciones;
                    //$modalidad = new Modalidad($reservas[$i]["id_modalidad"]);
                    //$url_reserva = _url_ . $obj_reservas->url_Reserva($modalidad->__get("_deporte")->__get("_nombre_deporte"),$reservas[$i]["id_reserva"], $reservas[$i]["titulo_reserva"]); ?>
                    <tr>
    <!--                    <td>
                            <img src="aplication/utilities/timthumb.php?src=<?php echo _url_avfiles_users_ . $rowp['nombre_reservas_archivos'] ?>&h=100&w=100&zc=1"/>
                        </td>-->
                        <td> <?php echo $reservas[$i]["id"]; ?> </td>
                        <td class="fecha"> <?php echo formato_slash("-",substr($reservas[$i]["fecha"],0,10)) ?> </td>
                        <td> <?php echo $reservas[$i]["nombre_actividad"]; ?> <a href="<?php echo $url_reserva ?>" target="_blank"><img src="aplication/webroot/imgs/icon_mas.jpg" width="16" height="17"></a></td>
                        <td><?php echo $cantidad_inscripciones ?></td>
                        <td>  <?php echo $reservas[$i]['monto'] ?></td>
                        <td>
                            <a class="btn-circle btn-edit glyphicon glyphicon-pencil" href="cuenta.php?cuenta=edit&idReserva=<?php echo $reservas[$i]["id"]; ?>" title="editar"></a>
                            <a class="btn-circle btn-delete glyphicon glyphicon-remove" href="#" title="eliminar"><input type="hidden" value="<?php echo $rowp['id_reserva'] ?>"></a>
                        </td>
                    </tr>
                    <?php
                }?>      
              </table>
            <?php
        } else {
            echo '<br/><div align="center">No tienes reservas para mostrar.    <br> Empieza ahora vista nuestra sección de actividades</div>';
        }?>

                 
            </div>

        </div>
        <?php
    }

    public function favoritos_cuenta() {
        ?>
        <div id="steps">
            <div id="titu_step"><img src="aplication/webroot/imgs/icon_star_b.png" width="16" height="16"> Mis Favoritos<span></span></div>
            <div id="panel_step">

        <?php
        $favoritos = new Favoritos();
        $favoritos->listFavoritos($this->_cliente->__get("_id"));
        ?>
                <div class="clear"></div>
            </div>

        </div>
        <?php
    }

    public function __get($atributo){
        return $this->$atributo;
    }
}
?>