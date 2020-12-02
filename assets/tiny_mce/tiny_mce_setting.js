/**
 * Naufil khan
 * Email:  developer.systech@gmail.com

 */

tinyMCE.init({
    mode: "textareas",
    editor_selector: "editor",

    relative_urls: true,
    remove_script_host: false,
    forced_root_block: '',

    theme: "advanced",
    /*skin: "bootstrap",*/
    /*skin_variant: "silver",*/
    plugins: "imagemanager,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

    // Theme options
    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,|,insertimage,|,widgets",//insertfile,
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,

    // Example content CSS (should be your site CSS)
    content_css: theme_assets_url + "/css/editor.css",

    /*relative_url: false,
    relative_urls: true,
    document_base_url: base_url,*/

    language: "en",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url: assets_url + "tiny_mce/lists/templates_list.php",
    external_link_list_url: "lists/link_list.js",



    // Replace values for the template plugin
    template_replace_values: {
        username: "Some User",
        staffid: "991234"
    },
    setup : function(ed) {
        ed.addButton('widgets', {
            title : 'Widgets',
            image : assets_url + 'admin/img/tree-icon.png',
            onclick : function() {

                bootbox.modal('<div class="modal-content" style="overflow: hidden;">\
                          <div class="modal-header">\
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                            <h4 class="modal-title"><i class="icon-stack"></i> Widgets</h4>\
                          </div>\
                          <div class="modal-body with-padding" style="padding: 18px;">\
                            <div class="row">\
                            <div class="col-sm-3"><a href="#" class="ed-left-side-img">Left Side Image</a></div>\
                            <div class="col-sm-3"><a href="#" class="ed-right-side-img">Right Side Image</a></div>\
                            <div class="col-sm-3"><a href="#" class="ed-left-right-side-img">Left Right Side Image</a></div>\
                            <div class="col-sm-3"><a href="#" class="ed-full-image">Full Image</a></div>\
                            <div class="col-sm-3"><a href="#" class="ed-full-text">Full Text</a></div>\
                            </div>\
                          </div>\
                          </div>');
                $('.bootbox  > .modal-body').css('padding', '0');
                $('.ed-left-side-img').on('click', function (e) {
                    e.preventDefault();
                    ed.execCommand('mceInsertContent', false, '<div class="row">\
                            <div class="col-sm-5"><img src="../../assets/editor_img/feature-2.png" alt="" class="img-responsive"/></div>\
                            <div class="col-sm-7">Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</div>\
                        </div>');
                });
                $('.ed-right-side-img').on('click', function (e) {
                    e.preventDefault();
                    ed.execCommand('mceInsertContent', false, '<div class="row">\
                            <div class="col-sm-7">Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</div>\
                            <div class="col-sm-5"><img src="../../assets/editor_img/feature-2.png" alt="" class="img-responsive"/></div>\
                        </div>');
                });
                $('.ed-left-right-side-img').on('click', function (e) {
                    e.preventDefault();
                    ed.execCommand('mceInsertContent', false, '<div class="row">\
                            <div class="col-sm-4"><img src="../../assets/editor_img/feature-2.png" alt="" class="img-responsive"/></div>\
                            <div class="col-sm-6">Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</div>\
                            <div class="col-sm-4"><img src="../../assets/editor_img/feature-2.png" alt="" class="img-responsive"/></div>\
                        </div>');
                });
                $('.ed-full-text').on('click', function (e) {
                    e.preventDefault();
                    ed.execCommand('mceInsertContent', false, '<div class="row">\
                            <div class="col-sm-12">Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</div>\
                        </div>');
                });
                $('.ed-full-img').on('click', function (e) {
                    e.preventDefault();
                    ed.execCommand('mceInsertContent', false, '<div class="row">\
                            <div class="col-sm-12 text-center"><img src="../../assets/editor_img/feature-2.png" alt=""/></div>\
                        </div>');
                });

            }
        });
    }
});

/*-------------------------------------------------------------------------*/

tinyMCE.init({
    mode: "textareas",
    editor_selector: "small_editor",
    theme: "advanced",
    skin: "o2k7",
    skin_variant: "silver",
    forced_root_block: '',
    //plugins: "imagemanager",

    /*relative_urls: false,
        remove_script_host: false,*/

    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,
    file_browser_callback: "imagemanager",
    theme_advanced_resize_horizontal: true,
    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

    // Example content CSS (should be your site CSS)
    content_css: theme_assets_url + "/css/editor.css"
});

tinyMCE.init({
    mode: "textareas",
    editor_selector: "simple_editor",
    theme: "simple",
    forced_root_block: ''
});