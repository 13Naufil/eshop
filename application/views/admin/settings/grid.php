<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Form of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<?php
$form_btns = array('save');
echo show_validation_errors();
?>

    <form id="validate" class="form-horizontal validate"
          action="<?= site_url(ADMIN_DIR . $this->module_route . '/update'); ?>"
          method="post" enctype="multipart/form-data">


    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-settings"></i>
                <?php echo $this->module_title; ?> - Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="well">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general-setting" data-toggle="tab"><i class="icon-cogs"></i> General Settings</a></li>
                    <li><a href="#web-setting" data-toggle="tab"><i class="icon-globe"></i> Website Settings</a></li>
                    <li><a href="#social-setting" data-toggle="tab"><i class="icon-facebook2"></i> Social Settings</a></li>
                    <li><a href="#email-setting" data-toggle="tab"><i class="icon-envelop2"></i> SMTP Settings</a></li>
                    <li><a href="#contact-setting" data-toggle="tab"><i class="icon-contract"></i> Contact Settings</a></li>
                    <li><a href="#recaptcha-setting" data-toggle="tab"><i class="icon-key"></i> Re-captcha</a></li>
                    <li><a href="#shipping-method" data-toggle="tab"><i class="icon-truck"></i> Shipping Method</a></li>
                </ul>
                <div class="tab-content with-padding">

                    <div class="tab-pane fade in active" id="general-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Site Title:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[site_title]" class="form-control" value="<?php echo get_option('site_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Admin Title:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[admin_title]" class="form-control" value="<?php echo get_option('admin_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tag Line:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[tag_line]" class="form-control" value="<?php echo get_option('tag_line'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Copyright Text:</label>
                            <div class="col-sm-10">
                                <textarea name="setting[copyright]" cols="" rows="5" class="form-control col-sm-12"><?php echo get_option('copyright'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email Address:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[contact_email]" class="form-control" value="<?php echo get_option('contact_email'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone Number:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[phone_number]" class="form-control" value="<?php echo get_option('phone_number'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone Title:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[phone_number_title]" class="form-control" value="<?php echo get_option('phone_number_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Company Address:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[company_address]" class="form-control" value="<?php echo get_option('company_address'); ?>">
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="web-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Prefix:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[title_prefix]" class="form-control" value="<?php echo get_option('title_prefix'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Suffix:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[title_suffix]" class="form-control" value="<?php echo get_option('title_suffix'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo:</label>
                            <div class="col-sm-5">
                                <input type="file" name="setting[logo]" class="styled" value="<?php echo get_option('logo'); ?>">
                            </div>
                            <?php
                            $_logo = get_option('logo');
                            if (!empty($_logo)) {
                                $thumb_url = base_url('assets/admin/img/' . $_logo);
                                $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/logo/' . $_logo);
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Favicon Icon:</label>
                            <div class="col-sm-5">
                                <input type="file" name="setting[favicon]" class="styled" value="<?php echo get_option('favicon'); ?>">
                            </div>
                            <?php
                            $_favicon = get_option('favicon');
                            if (!empty($_favicon)) {
                                $thumb_url = base_url('assets/admin/img/' . $_favicon);
                                $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/favicon/' . $_favicon);
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Default Description:</label>
                            <div class="col-sm-10">
                                <textarea name="setting[meta_description]" id="meta_description" class="form-control" cols="30" rows="5"><?php echo get_option('meta_description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Default Keywords:</label>
                            <div class="col-sm-10">
                                <textarea name="setting[meta_keywords]" id="meta_keywords" class="form-control" cols="30" rows="5"><?php echo get_option('meta_keywords'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Google analytics (JS):</label>
                            <div class="col-sm-10">
                                <textarea name="setting[google_analytics_js]" id="google_analytics_js" class="form-control" cols="30" rows="5"><?php echo get_option('google_analytics_js'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">External CSS:</label>
                            <div class="col-sm-10">
                                <textarea name="setting[external_css]" id="external_css" class="form-control" cols="30" rows="5"><?php echo get_option('external_css'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Default Robots:</label>
                            <div class="col-sm-10">
                                <select id="robots" name="setting[robots]" class="select">
                                    <?php
                                    $_robots = array(
                                        'INDEX,FOLLOW'  => 'INDEX, FOLLOW',
                                        'NOINDEX, FOLLOW'  => 'NOINDEX, FOLLOW',
                                        'INDEX, NOFOLLOW'  => 'INDEX, NOFOLLOW',
                                        'NOINDEX, NOFOLLOW'  => 'NOINDEX, NOFOLLOW',
                                    );
                                    echo selectBox($_robots, get_option('robots'));
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Selected Theme:</label>
                            <div class="col-sm-10">
                                <select id="robots" name="setting[theme]" class="select">
                                    <?php
                                    foreach(array_filter(glob(dirname(__FILE__) . '/../../themes/*'), 'is_dir') as $_dir){
                                        $_theme_dir = end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))));
                                        $_theme_name = ucwords(str_replace(array('-','_'), ' ', end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))))));
                                        $_themes[$_theme_dir] = $_theme_name;
                                    }

                                    echo selectBox($_themes, get_option('theme'));
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Front Page:</label>
                            <div class="col-sm-10">
                                <select id="front_page" name="setting[front_page]" class="select">
                                    <?php
                                    $_pages = "SELECT `id`,`title`  FROM `pages` WHERE `status`='published'";
                                    echo selectBox($_pages, get_option('front_page'));
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Blog Page:</label>
                            <div class="col-sm-10">
                                <select id="blog_page" name="setting[blog_page]" class="select">
                                    <?php
                                    $_pages = "SELECT `id`,`title`  FROM `pages` WHERE `status`='published'";
                                    echo selectBox($_pages, get_option('blog_page'));
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Posts Per Page:</label>
                            <div class="col-sm-2">
                                <input type="text" name="setting[posts_per_page]" class="form-control" value="<?php echo get_option('posts_per_page'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Color Attribute:</label>
                            <div class="col-sm-10">
                                <select id="blog_page" name="setting[color_attr_id]" class="select-search">
                                    <option value="">- Select Color Attribute -</option>
                                    <?php
                                    $_options = "SELECT `id`, `admin_label` FROM `attributes`";
                                    echo selectBox($_options, get_option('color_attr_id'));
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="social-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Facebook URL:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[facebook_url]" class="form-control" value="<?php echo get_option('facebook_url'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Twitter URL:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[twitter_url]" class="form-control" value="<?php echo get_option('twitter_url'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Google+ URL:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[googleplus_url]" class="form-control" value="<?php echo get_option('googleplus_url'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Instagram URL:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[instagram_url]" class="form-control" value="<?php echo get_option('instagram_url'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="email-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Enable SMTP:</label>
                            <div class="col-sm-10">
                                <select id="smtp" name="setting[smtp]" class="select">
                                    <?php
                                    $_enable_contact = array(
                                        '0'  => 'No',
                                        '1'  => 'Yes',
                                    );
                                    echo selectBox($_enable_contact, get_option('smtp'));
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SMTP Host:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[smtp_host]" class="form-control" value="<?php echo get_option('smtp_host'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">SMTP User:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[smtp_user]" class="form-control" value="<?php echo get_option('smtp_user'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">SMTP Password:</label>
                            <div class="col-sm-10">
                                <input type="password" name="setting[smtp_pass]" class="form-control" value="<?php echo get_option('smtp_pass'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">SMTP Port:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[smtp_port]" class="form-control" value="<?php echo get_option('smtp_port'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="contact-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Enable Contact Us:</label>
                            <div class="col-sm-10">
                                <select id="robots" name="setting[enable_contact]" class="select">
                                    <?php
                                    $_enable_contact = array(
                                        '1'  => 'Yes',
                                        '0'  => 'No'
                                    );
                                    echo selectBox($_enable_contact, get_option('enable_contact'));
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Send Emails To:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[recipient_email]" class="form-control" value="<?php echo get_option('recipient_email'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email Template:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[contcat_email_template]" class="form-control" value="<?php echo get_option('contcat_email_template'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="recaptcha-setting">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Re-captcha Public Key:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[recaptcha_public_key]" class="form-control" value="<?php echo get_option('recaptcha_public_key'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Re-captcha Private Key:</label>
                            <div class="col-sm-10">
                                <input type="text" name="setting[recaptcha_private_key]" class="form-control" value="<?php echo get_option('recaptcha_private_key'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Re-captcha Skin:</label>
                            <div class="col-sm-10">
                                <select name="setting[recaptcha_skin]" id="recaptcha_skin" class="select">
                                    <?php
                                    $_recaptcha_skins = array(
                                        'red' => 'Red (default theme)',
                                        'white' => 'White',
                                        'blackglass' => 'blackglass',
                                        'clean' => 'clean'
                                    );
                                    echo selectBox($_recaptcha_skins, get_option('recaptcha_skin'));?>
                                </select>
                                <!--<input type="text" name="setting[recaptcha_skin]" class="form-control" value="<?php /*echo get_option('recaptcha_skin'); */?>">-->
                            </div>
                        </div>
                    </div>
                    <?php
                    include "shipping-method.php";
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="well">
        <div class="form-actions text-right">
            <button type="submit" class="btn btn-danger" name="form_submit">Update</button>
            <a href="<?php echo admin_url(); ?>" class="btn btn-primary">Dashboard</a>
        </div>
    </div>
</form>
<div class="clear"><br/></div>