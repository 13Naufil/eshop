<!--<h5 class="widget-name"><i class="icon-home"></i>Dashboard</h5>-->
<div class="panel panel-default">
<div class="panel-heading">
    <h6 class="panel-title"><i class="icon-cogs"></i> Modules</h6>

    <div class="panel-icons-group">
        <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a>
        <!--<a href="#" data-panel="close" class="btn btn-link btn-icon"><i class="icon-cancel-circle"></i></a>-->
    </div>
</div>
<div class="panel-body">
    <!-- Dashboard components -->
    <ul class="dashboard-components">
        <?php foreach ($modules as $module) {
            $status = $this->db->query("SELECT `status` FROM modules WHERE parent_id='" . $module->id . "'");
            if (!in_array($module->module, array('#', 'javascript:;', 'javascript: void(0);'))) {
                ?>
                <li>
                    <a href="<?= site_url(ADMIN_DIR . $module->module); ?>">
                        <?php
                        if(strpos($module->icon,'icon-') !== FALSE){
                            ?><i class="<?php echo $module->icon;?>"></i><?
                        }else{
                            ?><img src="<?php echo base_url('assets/admin/img/icons/' . $module->icon); ?>" alt="<?= $module->module_title; ?>"/><?
                        }
                        ?>
                        <span><?php echo $module->module_title; ?></span>
                    </a>
                </li>
            <?php
            }
        }?>

        <li><a href="<?php echo admin_url('login/logout') ; ?>"><i class="icon-lock"></i><span>Log Out</span></a>
        </li>
    </ul>
    <!-- /dashboard components -->
</div>
</div>



