<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if IE 9 ]>
<html class="ie9 no-js">
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js">
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Basic page needs ================================================== -->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Helpers ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <title><?php echo $this->template->site_title;?></title>
    <meta name="description" content="<?php echo $this->template->meta('description');?>">
    <meta name="keywords" content="<?php echo $this->template->meta('keywords');?>">
    <meta name="author" content="<?php echo $this->template->meta('author');?>">
    <meta name="robots" content="<?php echo get_option('robots'); ?>" />
    <link rel="icon" href="<?php echo asset_url('admin/img/'.get_option('favicon')); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo asset_url('admin/img/'.get_option('favicon')); ?>" type="image/x-icon">
    <link rel="canonical" href="<?php echo current_url();?>"/>


    <!-- fonts -->
    <!--   { { 'fullpage.scss' | asset_url | stylesheet_tag }} -->
    <script type="text/javascript">
        WebFontConfig = {
            google: { families: [
                'Montserrat:100,200,300,400,500,600,700,800,900',
                'Montserrat:100,200,300,400,500,600,700,800,900',
                'Montserrat:100,200,300,400,500,600,700,800,900',
                'Montserrat:100,200,300,400,500,600,700,800,900'
            ] }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
    <style>
        #fixed {
            width: 100%;
            position: fixed;
            top: 0px;
            right: 0px;
            display: inline-block;
            z-index: 9999;
            overflow: visible;
        }

        #fixed .header-panel {
            clear: both;
            background: #000;
        }

        #fixed .nav-bar {
            background-color: #f4f4f4f4;
            border-bottom: 1px solid #d6d2d280;
        }
        ul#sub-menu-menu li {
    display: block!important;
  width: 89%!important;
  border-bottom:1px solid #e5e5e5;
}
.plussign:before{
    content: "+"!important;
}
    </style>
    <!-- Styles -->

    <noscript>

            <div class="alert alert-danger">
                <p>
                    <strong>JavaScript seems to be disabled in your browser.</strong><br/>
                    You must have JavaScript enabled in your browser to utilize the functionality of this website.
                </p>
            </div>

    </noscript>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $this->template->meta('og:title');?>" />
    <meta property="og:description" content="<?php echo $this->template->meta('og:description');?>" />
    <meta property="og:type" content="<?php echo $this->template->meta('og:type');?>" />
    <meta property="og:url" content="<?php echo $this->template->meta('og:url');?>" />
    <meta property="og:image" content="<?php echo $this->template->meta('og:image');?>" />
    <meta property="og:image:type" content="<?php echo $this->template->meta('og:image:type');?>" />
    <meta property="og:image:width" content="<?php echo $this->template->meta('og:image:width');?>" />
    <meta property="og:image:height" content="<?php echo $this->template->meta('og:image:height');?>" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="<?php echo $this->template->meta('twitter:card');?>" />
    <meta name="twitter:title" content="<?php echo $this->template->meta('twitter:title');?>" /><!--gmail:naufil_khan13@hotmail.com-->
    <meta name="twitter:description" content="<?php echo $this->template->meta('twitter:description');?>" /><!--Naufil khan - Web App Developer.-->
    <meta name="twitter:image:src" content="<?php echo $this->template->meta('twitter:image:src');?>" />
    <meta name="twitter:image:width" content="<?php echo $this->template->meta('twitter:image:width');?>" />
    <meta name="twitter:image:height" content="<?php echo $this->template->meta('twitter:image:height');?>" />
    <meta name="twitter:site" content="<?php echo $this->template->meta('twitter:site');?>" />
    <meta name="twitter:creator" content="<?php echo $this->template->meta('twitter:creator');?>" />

    <!-- Styles -->
    <link href="<?php echo media_url('css/bootstrap.min.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <!-- Theme base and media queries -->
    <link href="<?php echo media_url('css/owl.carousel.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/owl.theme.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/jcarousel.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/selectize.bootstrap.css?') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/jquery.fancybox.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/component.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/theme-styles.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/theme-styles-setting.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/theme-styles-responsive.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/animate.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo media_url('css/retina-responsive.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <!-- Scripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo media_url('js/selectize.min.js') ; ?>" type="text/javascript"></script>
    <script src="<?php echo media_url('js/jquery.flexslider-min.js') ; ?>" type="text/javascript"></script>
    <!-- Header hook for plugins ================================================== -->
    <link rel="stylesheet" href="<?php echo media_url('css/font-awesome.min.css') ; ?>">
    <link href="<?php echo media_url('css/buddha-megamenu.css') ; ?>" rel="stylesheet" type="text/css" media="all" />
    <script src="<?php echo media_url('js/buddha-megamenu.js') ; ?>"></script>
    <link rel="stylesheet" media="screen" href="<?php echo media_url('css/styles.css') ; ?>">

    <!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        <?php echo get_option('external_css');?>
    </style>
    

<div itemscope itemtype="http://schema.org/Person" class="hidden">
   <span itemprop="name"><?php echo $this->template->site_title;?></span>
   <span itemprop="company"><?php echo get_option('site_url');?></span>
   <span itemprop="tel"><?php echo get_option('contact_number');?></span>
   <a itemprop="email" href="mailto:<?php echo get_option('email');?>"><?php echo get_option('email');?></a>
</div>
    
    
    
    
    <!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window,document,'script',

'https://connect.facebook.net/en_US/fbevents.js');


fbq('init', '247468572941076'); 

fbq('track', 'PageView');

</script>

<noscript>

<img height="1" width="1" 

src="https://www.facebook.com/tr?id=247468572941076&ev=PageView

&noscript=1"/>

</noscript>

<!-- End Facebook Pixel Code -->
    
    
</head>
<body class="app-container">