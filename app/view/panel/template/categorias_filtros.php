<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item">Usuarios</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Don Regalo <small>Adminitrador de contenido</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-8 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Lista de Usuarios - Don Regalo</h4>
                </div>
                <br>
                <div class="text-right p-r-15 p-b-15">
                    <button class="btn btn-sm  btn-success" onclick="showModalNewCategoriaFiltro()">Crear Nueva Categoria Filtro &nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                </div>
                <div class="modal fade" id="modal-new">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Nueva Categoria-Filtro</h4>
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
                                        <label class="col-form-label col-md-3">Categoria</label>
                                        <div class="col-md-9">
                                            <select name="new_categoria" id="" class="form-control">
                                                <?php foreach ($lista_categorias as $cate): ?>
                                                    <option value="<?php echo $cate['value'] ?>"><?php echo $cate['text'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-3">Filtro</label>
                                        <div class="col-md-9">
                                            <select name="new_filtro" id="" class="form-control">
                                                <?php foreach ($lista_filtros as $fil): ?>
                                                    <option value="<?php echo $fil['value'] ?>"><?php echo $fil['text'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row m-b-10">
                                        <label class="col-md-3 col-form-label">Url</label>
                                        <div class="col-md-9">
                                            <input type="text" name="new_url" class="form-control" placeholder="" value="" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                <a href="javascript:;" class="btn btn-green text-white" onclick="saveNewCategoriaFiltro()">Guardar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table id="user" class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Filtro</th>
                                <th>Url</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_cate_filtro as $cate_filt): ?>
                            <?php $obj_filtro = new Filtro($cate_filt['id_filtro']); ?>
                            <?php $obj_cate = new Categoria($cate_filt['id_categoria']); ?>
                                <tr class="table-tr-data" data-id="<?php echo $cate_filt['id'] ?>">
                                    <td><a href="javascript:;" class="cf-nombre" data-type="text" data-id="<?php echo $conf['id'] ?>"><?php echo $cate_filt['nombre'] ?></a></td>
                                    <td><a href="javascript:;" class="cf-categoria" data-type="select"><?php echo $obj_cate->__get('_nombre') ?></a></td>
                                    <td><a href="javascript:;" class="cf-filtro" data-type="select"><?php echo $obj_filtro->__get('_nombre') ?></a></td>
                                    <td><a href="javascript:;" class="cf-url" data-type="text" data-clase="Configuration" data-action="updateConfigurationAjax"><?php echo $cate_filt['url'] ?></a></td>
                                    <td><span>
                                        <a href="javascript:;" onclick="deleteRow(<?php echo $cate_filt['id'] ?>)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp;eliminar</a>
                                    </span></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-8 -->
    </div>
    <!-- end row -->
</div>