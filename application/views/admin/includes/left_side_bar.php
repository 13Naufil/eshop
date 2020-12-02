<!-- Sidebar -->
  <div class="sidebar collapse">
    <div class="sidebar-content">
        <!-- User dropdown -->
          <!--<div class="user-menu dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php /*echo base_url('assets/admin/img/left-logo.png'); */?>" alt="">
            <div class="user-info"><?php /*echo get_option('admin_title'); */?><span>Web Developer</span></div>
            </a>
            <div class="popup dropdown-menu dropdown-menu-right">
              <div class="thumbnail">
                <div class="thumb"><img alt="" src="images/demo/users/face3.png">
                  <div class="thumb-options"><span><a href="#" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a><a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a></span></div>
                </div>
                <div class="caption text-center">
                  <h6>Madison Gartner <small>Front end developer</small></h6>
                </div>
              </div>
              <ul class="list-group">
                <li class="list-group-item"><i class="icon-pencil3 text-muted"></i> My posts <span class="label label-success">289</span></li>
                <li class="list-group-item"><i class="icon-people text-muted"></i> Users online <span class="label label-danger">892</span></li>
                <li class="list-group-item"><i class="icon-stats2 text-muted"></i> Reports <span class="label label-primary">92</span></li>
                <li class="list-group-item"><i class="icon-stack text-muted"></i> Balance
                  <h5 class="pull-right text-danger">$45.389</h5>
                </li>
              </ul>
            </div>
          </div>-->
          <!-- /user dropdown -->

        <!-- Main navigation -->
        <ul class="navigation widget">
        <li>
            <a href="<?= site_url(ADMIN_DIR . 'dashboard'); ?>" title="">
                <i class="icon-screen2"></i>Dashboard
            </a>
        </li>
        <?php
        $this->multilevels->id_Column = 'id';
        $this->multilevels->title_Column = 'module_title';
        $this->multilevels->link_Column = 'module';
        $this->multilevels->type = 'menu';
        $this->multilevels->level_spacing = 5;
        $this->multilevels->selected = $row->parent_id;
        $this->multilevels->has_child_html = '<i style="float: right;margin: 0 21px" class="icon-arrow-down2"></i>';

        $this->multilevels->parent_li_start = "<li class='{active_class}'>\n  <a class='expand' href='{href}'>{icon} {title}{has_child}</a>\n";/**/
        $this->multilevels->child_li_start = "<li class='{active_class}'>\n  <a href='{href}'>{icon}{title}</a>\n";

        $this->multilevels->active_class = 'active';
        $this->multilevels->active_link = getUri(2);

        $this->multilevels->url = site_url(ADMIN_DIR) . '/';

        $this->multilevels->query = "SELECT *,
        IF(icon != '',
        IF(SUBSTRING_INDEX(icon,'-',1) = 'icon', CONCAT('<i class=\"',icon,'\"></i>'), CONCAT('<i class=\"icon\"><img width=\"17\" src=\"" . base_url('assets/admin/img/icons/') . "/',icon,'\"/></i>'))
        ,'<i class=\"icon-stack\"></i>') as icon
        FROM `modules` WHERE `status`='1' AND `show_on_menu`=1 AND id IN (SELECT `module_id` FROM `user_type_module_rel` WHERE user_type_id='" . intval($this->session->userdata('user_type')) . "') ORDER BY ordering ASC";
        echo $multiLevelComponents = $this->multilevels->build();
        ?>
        <li>
            <a href="<?php echo admin_url('login/logout'); ?>" title="">
                <i class="icon-lock"></i>Logout
            </a>
        </li>
    </ul>
    <!-- /main navigation -->
    <div class="widget">
        <!--<h6 class="widget-name"><i class="icon-calendar"></i>Calendar</h6>
        <div class="inlinepicker datepicker-liquid"></div>-->
    </div>
  </div>
</div>

<!-- /sidebar -->