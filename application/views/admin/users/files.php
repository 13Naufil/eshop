<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */

?>
<div id="form_content">
    <div class="wrapper">

        <div class="page-header">
            <h5 class="widget-name">
                <i class="icon">
                    <img width="22" src="<?= base_url('assets/admin/img/icons/22_' . getModuleDetail()->icon); ?>" alt=""/>
                </i>
                <strong class="color-red"><?=$row->first_name . ' ' . $row->last_name; ?> (<?=$row->email ; ?>)</strong> : Files

                <a href="#" onclick="window.history.back()" class="back-btn btn pull-right" ><i class="icon-step-backward"></i> &nbsp;Back</a>
            </h5>
        </div>
        <?php
        echo show_validation_errors();
        ?>
        <div class="row-fluid">
            <!-- START -->
            <div id="file-uploader" class="well">You browser doesn't have HTML 4 support.</div>


            <br/>

            <div class="files">
                <div class="navbar">
                    <div class="navbar-inner"><h6>Uploaded Files</h6></div>
                </div>
                <div class="table-overflow">
                    <table class="xgrid table table-bordered table-checks table-striped table-files">
                        <thead>
                        <tr>
                            <th>Sr.#</th>
                            <th>File</th>
                            <th>Size</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($files)){
                            foreach ($files as $k => $file) {
                            ?>
                            <tr>
                                <td><?= ($k + 1); ?></td>
                                <td><?= $file->file_name; ?></td>
                                <td><?= number_format(((filesize('./assets/admin/users_files/' . $file->user_id .'/' . $file->file_name) / 1024)), 2); ?> KB</td>
                                <td width="40">
                                    <ul class="table-controls">
                                        <li>
                                            <a data-original-title="Download" title="" class="tip "
                                               href="<?= admin_url($this->module_route . '/download_file/' . $file->id); ?>"
                                               action="download">
                                                <i class="icon-download"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-original-title="Delete" title="" class="tip "
                                               href="<?= admin_url($this->module_route . '/delete_file/' . $file->id); ?>"
                                               action="file_delete">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?
                        }
                        }
                        echo '</tbody></table></div></div>';
                        ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/uploader/plupload.full.min.js'); ?>"></script>
<script type="text/javascript"
        src="<?= base_url('assets/admin/js/plugins/uploader/jquery.plupload.queue.js'); ?>"></script>

<script type="text/javascript">

    $(document).on('click', '.table-controls a[action="file_delete"]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        bootbox.confirm("Are you sure do you want to delete?", function (confirmed) {
            if (confirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: {id: 1},
                    complete: function (data) {
                        var json = $.parseJSON(data.responseText);
                        console.log(json);
                    }
                });
            }
        });
    });

    var uploader = $("#file-uploader").pluploadQueue({
        runtimes: 'html5,html4',
        url: '<?=admin_url($this->module_route . '/file_uploader/' . $row->id);?>',
        max_file_size: '100mb',
        unique_names: true,
        filters: [
            {title: "Files", extensions: "<?php echo get_option('user_files_ext');?>"}
        ],
        init: {
            FilesAdded: function (up, files) {
                console.log('FilesAdded');
            },
            UploadComplete: function (up, files) {
                // Called when all files are either uploaded or failed
                console.log('UploadComplete');
            },
            FileUploaded: function (up, file, info) {
                // Called when file has finished uploading
                var data = jQuery.parseJSON(info.response);

                if ('result' in data) {
                    var sr_no = $('.table-files tbody tr:last td:first').text();
                    $('.table-files tbody').append('<tr>\
                                                    <td>'+(parseInt(sr_no) + 1)+'</td>\
                                                    <td>'+data.result.filename+'</td>\
                                                    <td>'+data.result.filesize+' MB</td>\
                                                    <td width="40">\
                                                        <ul class="table-controls">\
                                                            <li>\
                                                                <a data-original-title="Download" title="" class="tip "\
                                                                   href="<?= admin_url($this->module_route . '/download_file'); ?>/'+data.result.id+'"\
                                                                   action="download">\
                                                                    <i class="icon-download"></i>\
                                                                </a>\
                                                            </li>\
                                                            <li>\
                                                                <a data-original-title="Delete" title="" class="tip "\
                                                                   href="<?= admin_url($this->module_route . '/delete_file'); ?>/'+data.result.id+'"\
                                                                   action="file_delete">\
                                                                    <i class="icon-trash"></i>\
                                                                </a>\
                                                            </li>\
                                                        </ul>\
                                                    </td>\
                                                </tr>');
                    //$('.uploaded-files').append('<input type="hidden" name="files[]" id="files" value="' + data.result.filename + '" class=""/>');

                }
            }
        }
    });

</script>
