<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade show">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <div class="alert alert-secondary p-10 m-b-0">
                    <dl class="m-b-0">
                        <dt class="text-inverse">File Name:</dt>
                        <dd class="name">{%=file.name%}</dd>
                        <dt class="text-inverse m-t-10">File Size:</dt>
                        <dd class="size">Processing...</dd>
                    </dl>
                </div>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <dl>
                    <dt class="text-inverse m-t-3">Progress:</dt>
                    <dd class="m-t-5">
                        <div class="progress progress-sm progress-striped active rounded-corner"><div class="progress-bar progress-bar-primary" style="width:0%; min-width: 40px;">0%</div></div>
                    </dd>
                </dl>
            </td>
            <td nowrap>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start width-100 p-r-20 m-r-3" disabled>
                        <i class="fa fa-upload fa-fw pull-left m-t-2 m-r-5 text-inverse"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-default cancel width-100 p-r-20">
                        <i class="fa fa-trash fa-fw pull-left m-t-2 m-r-5 text-muted"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade show">
            <td width="1%">
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } else { %}
                        <div class="bg-silver text-center f-s-20" style="width: 80px; height: 80px; line-height: 80px; border-radius: 6px;">
                            <i class="fa fa-file-image fa-lg text-muted"></i>
                        </div>
                    {% } %}
                </span>
            </td>
            <td>
                <div class="alert alert-secondary p-10 m-b-0">
                    <dl class="m-b-0">
                        <dt class="text-inverse">File Name:</dt>
                        <dd class="name">
                            {% if (file.url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                            {% } else { %}
                                <span>{%=file.name%}</span>
                            {% } %}
                        </dd>
                        <dt class="text-inverse m-t-10">File Size:</dt>
                        <dd class="size">{%=o.formatFileSize(file.size)%}</dd>
                    </dl>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </div>
            </td>
            <td></td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete width-100 m-r-3 p-r-20" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash pull-left fa-fw text-inverse m-t-2"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-default cancel width-100 m-r-3 p-r-20">
                        <i class="fa fa-trash pull-left fa-fw text-muted m-t-2"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo _admin_assets_?>plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
    <script src="<?php echo _admin_assets_?>crossbrowserjs/html5shiv.js"></script>
    <script src="<?php echo _admin_assets_?>crossbrowserjs/respond.min.js"></script>
    <script src="<?php echo _admin_assets_?>crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo _admin_assets_?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/js-cookie/js.cookie.js"></script>
<script src="<?php echo _admin_assets_?>js/theme/default.min.js"></script>
<script src="<?php echo _admin_assets_?>js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo _admin_assets_?>cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/gritter/js/jquery.gritter.js"></script>
<script src="<?php echo _admin_assets_?>plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/sparkline/jquery.sparkline.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo _admin_assets_?>plugins/nvd3/build/nv.d3.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/address/address.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/typeaheadjs/lib/typeahead.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/typeaheadjs/typeaheadjs.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/bootstrap-wysihtml5/wysihtml5.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap3-editable/inputs-ext/select2/select2.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/mockjax/jquery.mockjax.js"></script>
<script src="<?php echo _admin_assets_?>plugins/moment/moment.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jstree/dist/jstree.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo _admin_assets_?>plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?php echo _admin_assets_?>plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo _admin_assets_?>plugins/select2/dist/js/select2.min.js"></script>

