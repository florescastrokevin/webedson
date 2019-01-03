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
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table id="user" class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cargo</th>
                                <th>Login</th>
                                <th>Email</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_usu as $key => $usu): ?>
                                <tr>
                                    <td><?php echo $usu['nombre'] ?></td>
                                    <td><?php echo $usu['apellido'] ?></td>
                                    <td><?php echo $usu['rol'] ?></td>
                                    <td><?php echo $usu['login'] ?></td>
                                    <td><?php echo $usu['email'] ?></td>
                                    <td><span>
                                        <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp;eliminar</a>
                                        <a href="" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;editar</a>
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