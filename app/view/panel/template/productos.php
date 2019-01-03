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
                    <button id="btn-new-producto" class="btn btn-xs btn-success m-b-10" onclick="modalNewProducto()">Nuevo Producto &nbsp;&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                    <div id="jstree-default">
                    </div>
                    <!-- modal -->
                    <div class="modal fade" id="modal-new">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Nueva Producto</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form id="new-categoria" method="post">
                                        <input type="hidden" name="new_id_categoria" value="">
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Nombre</label>
                                            <div class="col-md-9">
                                                <input type="text" name="new_nombre" class="form-control" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Descripción Corta</label>
                                            <div class="col-md-9">
                                                <textarea type="text" name="new_descripcion_corta" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-15">
                                            <label class="col-form-label col-md-3">Descripción</label>
                                            <div class="col-md-9">
                                                <textarea type="text" name="new_descripcion" class="form-control" rows="7"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row m-b-10">
                                                    <label class="col-md-3 col-form-label">Precio</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                                            <input type="number" class="form-control text-right" value="" name="new_precio">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row m-b-10">
                                                    <label class="col-form-label col-md-3">Cantidad</label>
                                                    <div class="col-md-9">
                                                        <input type="number" name="new_cantidad" class="form-control text-right" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group row m-b-10">
                                                    <label class="col-md-6 col-form-label">Activo <i class="fas fa-star text-success"></i></label>
                                                    <div class="col-md-6 p-t-3 m-b-10">
                                                        <div class="switcher switcher-success">
                                                            <input type="checkbox" name="new_activo" id="new_activo" checked="checked" >
                                                            <label for="new_activo"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row m-b-10">
                                                    <label class="col-md-6 col-form-label">Destacado <i class="fas fa-star text-yellow-lighter"></i></label>
                                                    <div class="col-md-6 p-t-3 m-b-10">
                                                        <div class="switcher switcher-warning">
                                                            <input type="checkbox" name="new_destacado" id="new_destacado">
                                                            <label for="new_destacado"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row m-b-10">
                                                    <label class="col-md-6 col-form-label">EsComplemento <i class="fas fa-star text-indigo-lighter"></i></label>
                                                    <div class="col-md-6 p-t-3 m-b-10">
                                                        <div class="switcher switcher-indigo">
                                                            <input type="checkbox" name="new_is_complemento" id="new_is_complemento" >
                                                            <label for="new_is_complemento"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                    <a href="javascript:;" class="btn btn-green text-white" onclick="saveNewProducto()">Guardar</a>
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
            <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                <!-- begin panel-heading -->
                <div class="panel-heading p-0">
                    <div class="panel-heading-btn m-r-10 m-t-10">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <!-- begin nav-tabs -->
                    <div class="tab-overflow">
                        <ul class="nav nav-tabs nav-tabs-inverse">
                            <li class="nav-item f-s-14 prev-button"><a href="javascript:;" data-click="prev-tab" class="nav-link text-success"><i class="fa fa-arrow-left"></i></a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active">Descripción</a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-2" data-toggle="tab" class="nav-link">Filtros</a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-3" data-toggle="tab" class="nav-link">Insumos</a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-4" data-toggle="tab" class="nav-link">Complementos</a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-5" data-toggle="tab" class="nav-link">Imagenes</a></li>
                            <li class="nav-item f-s-14"><a href="#nav-tab-6" data-toggle="tab" class="nav-link">Nav Tab 6</a></li>
                            <li class="nav-item next-button"><a href="javascript:;" data-click="next-tab" class="nav-link text-success"><i class="fa fa-arrow-right"></i></a></li>
                        </ul>
                    </div>
                    <!-- end nav-tabs -->
                </div>
                <!-- end panel-heading -->
                <!-- begin tab-content -->
                <div class="tab-content" id="contenido-producto">
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade active show" id="nav-tab-1">
                        
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" id="nav-tab-2">
                        <!-- begin table-responsive -->
                        
                        <!-- end table-responsive -->
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" id="nav-tab-3">
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" id="nav-tab-4">
                        <!-- begin table-responsive -->
                        
                        <!-- end table-responsive -->
                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" id="nav-tab-5">
                        
                        <!-- begin form-file-upload -->
                        
                        <!-- end form-file-upload -->

                    </div>
                    <!-- end tab-pane -->
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade" id="nav-tab-6">
                        <h3 class="m-t-10">Nav Tab 6</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor, 
                            est diam sagittis orci, a ornare nisi quam elementum tortor. 
                            Proin interdum ante porta est convallis dapibus dictum in nibh. 
                            Aenean quis massa congue metus mollis fermentum eget et tellus. 
                            Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien, 
                            nec eleifend orci eros id lectus.
                        </p>
                        <p>
                            Aenean eget odio eu justo mollis consectetur non quis enim. 
                            Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet. 
                            Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula, 
                            at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                            Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum. 
                            Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat. 
                            Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                        </p>
                    </div>
                    <!-- end tab-pane -->
                </div>
                <!-- end tab-content -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-8 -->
    </div>
    <!-- end row -->
</div>




