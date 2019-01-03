<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item">Categorias</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Don Regalo <small>Adminitrador de contenido</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-lg-4">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Categorias Para Productos - Don Regalo</h4>
                </div>
                <div class="panel-body">
                    <button class="btn btn-xs btn-success m-b-10" onclick="modalNewCategoria(0)">Nueva Categoria (principal) &nbsp;&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                    <div id="jstree-default">
                        <!-- <ul>
                            <li data-jstree='{"opened":true}' >
                                Root node 1
                                <ul>
                                    <li data-jstree='{"opened":true, "selected":true }'>Initially Selected</li>
                                    <li>Folder 1
                                        <ul>
                                            <li id-carpeta="1">tets1</li>
                                            <li>test2</li>
                                        </ul>            
                                    </li>
                                    <li>Folder 3</li>
                                    <li data-jstree='{"opened":true}' >
                                        Initially open
                                        <ul>
                                            <li data-jstree='{"disabled":true}' >Disabled node</li>
                                            <li>Another node</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{ "icon" : "fa fa-warning fa-lg text-danger" }'>custom icon class (fontawesome)</li>
                                    <li data-jstree='{ "icon" : "fa fa-link fa-lg text-primary" }'><a href="https://www.jstree.com/">Clickable link node</a></li>
                                </ul>
                            </li>
                            <li>Root node 2</li>
                        </ul> -->
                    </div>
                    <!-- modal -->
                    <div class="modal fade" id="modal-new">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Nueva Categoria</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form id="new-categoria" method="post">
                                        <input type="hidden" value="new_parent" name="new_parent"> 
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Nombre</label>
                                            <div class="col-md-9">
                                                <input type="text" name="new_nombre" class="form-control" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Titulo</label>
                                            <div class="col-md-9">
                                                <input type="text" name="new_titulo" class="form-control" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Descripción</label>
                                            <div class="col-md-9">
                                                <textarea type="text" name="new_descripcion" class="form-control" rows="7"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-10">
                                            <label class="col-md-3 col-form-label">Activo</label>
                                            <div class="col-md-9 p-t-3">
                                                <div class="switcher switcher-success">
                                                    <input type="checkbox" name="new_activo" id="new_activo" checked="">
                                                    <label for="new_activo"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                    <a href="javascript:;" class="btn btn-green text-white" onclick="saveNewCategoria()">Guardar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-lg-8">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Editar Datos de Categoria - Don Regalo</h4>
                </div>
                <div class="panel-body" id="contenedor-editar-categoria">

                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-8 -->
    </div>
    <!-- end row -->
</div>

