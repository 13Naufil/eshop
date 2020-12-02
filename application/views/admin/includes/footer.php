<br/>
<!-- Footer -->
    <div class="footer clearfix">
      <div class="pull-left">&copy; Copyright 2010-<?= date('Y'); ?>. Design & Developed by <a href="mailto:developer.systech@gmail.com">Naufil khan</a></div>
      <div class="pull-right icons-group"> <a href="#"><i class="icon-screen2"></i></a> <a href="#"><i class="icon-balance"></i></a> <a href="#"><i class="icon-cog3"></i></a> </div>
    </div>
    <!-- /footer -->
  </div>
  <!-- /page content -->
</div>
<!-- /page container -->
</body>
</html>

<script type="text/javascript">
    (function ($) {
        function active_nav_item(li_active_nav_item, level) {
            if (!li_active_nav_item) return; // exit condition

            li_active_nav_item.parent('ul').css('display', 'block');
            var p_li_active_nav_item = li_active_nav_item.parents('li');
            if(level == 1){
                p_li_active_nav_item.addClass('active')
            }else{

                p_li_active_nav_item.find('li.active:eq(0)').removeClass('active').find('a:eq(0)').addClass('expand level-opened')
            }

            if(p_li_active_nav_item[0])
                active_nav_item(p_li_active_nav_item, (level + 1));
        }

        $(document).ready(function () {
            var li_active_nav_item = $('.sidebar-content .navigation li.active');
            active_nav_item(li_active_nav_item, 1);
        });
    })(jQuery)
</script>