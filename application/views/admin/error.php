

    <div class="error-wrapper text-center">
      <h1><?php echo $error_no; ?></h1>
      <h6><?php echo $error_message; ?></h6>
      <!-- Error content -->
      <div class="error-content">

        <div class="row">
          <div class="col-md-6"> <a href="<?php echo admin_url(); ?>" class="btn btn-danger btn-block">Back to dashboard</a> </div>
          <div class="col-md-6"> <a href="<?php echo site_url(); ?>" class="btn btn-success btn-block">Back to the website</a> </div>
        </div>
      </div>
      <!-- /error content -->
    </div>

