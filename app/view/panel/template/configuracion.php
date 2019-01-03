<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item">Configuración</li>
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
                    <h4 class="panel-title">Form Editable</h4>
                </div>
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table id="user" class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Nombre Campo</th>
                                <th>Valor</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_config as $key => $conf): ?>
                                <tr class="table-tr-data">
                                    <td class="bg-silver-lighter"><?php echo $conf['nombre'] ?></td>
                                    <td><a href="javascript:;" id="id<?php echo $conf['id'] ?>" data-type="text" data-clase="Configuration" data-action="updateConfigurationAjax" data-id="<?php echo $conf['id'] ?>"><?php echo $conf['valor'] ?></a></td>
                                    <td><span class="text-black-lighter"><?php echo $conf['descripcion'] ?></span></td>
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