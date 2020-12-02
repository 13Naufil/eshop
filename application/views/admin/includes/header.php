<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
  <div class="navbar-header">
      <a href="<?= site_url(); ?>" title="" class="navbar-brand">
          <!--<img src="<?php /*echo base_url('assets/admin/img/admin_logo.png');*/?>" alt="<?php /*echo get_option('admin_title'); */?>" width="180"/>-->
          <h1 style="margin: 5px;"><?php echo get_option('admin_title'); ?></h1>
      </a>
      <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
  </div>
  <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">

    <!--<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"><i class="icon-bubble4"></i><span class="label label-danger">3</span></a>
      <div class="popup dropdown-menu dropdown-menu-right">
        <div class="popup-header"><a href="#" class="pull-left"><i class="icon-spinner7"></i></a><span>Alerts</span><a href="#" class="pull-right"><i class="icon-new-tab"></i></a></div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Description</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span class="status status-success item-before"></span> <a href="#">Frontpage fixes</a></td>
              <td><span class="text-smaller text-semibold">Bugs</span></td>
            </tr>
            <tr>
              <td><span class="status status-danger item-before"></span> <a href="#">CSS compilation</a></td>
              <td><span class="text-smaller text-semibold">Bugs</span></td>
            </tr>
            <tr>
              <td><span class="status status-info item-before"></span> <a href="#">Responsive layout changes</a></td>
              <td><span class="text-smaller text-semibold">Layout</span></td>
            </tr>
            <tr>
              <td><span class="status status-success item-before"></span> <a href="#">Add categories filter</a></td>
              <td><span class="text-smaller text-semibold">Content</span></td>
            </tr>
            <tr>
              <td><span class="status status-success item-before"></span> <a href="#">Media grid padding issue</a></td>
              <td><span class="text-smaller text-semibold">Bugs</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    --></li>
      <?php
      if ($this->session->userdata('cct_user_id')) {
          ?>
    <li class="user dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown"><img src="<?= _img('assets/admin/img/users/'. user_info('photo'),32,32, 'assets/front/uploads/user.jpg'); ?>" alt="">
            <span><?php echo user_info('first_name') . ' ' . user_info('last_name'); ?></span><i class="caret"></i>
        </a>
      <ul class="dropdown-menu dropdown-menu-right icons-right">
        <li><a href="<?php echo admin_url('users/profile');?>"><i class="icon-user"></i> Profile</a></li>
        <li><a href="#"><i class="icon-bubble4"></i> Alerts</a></li>
        <li><a href="<?php echo admin_url('login/logout');?>"><i class="icon-exit"></i> Logout</a></li>
      </ul>
    </li>
              <?php } ?>
  </ul>
</div>
<!-- /navbar -->

<!-- Page container -->
<div class="page-container">