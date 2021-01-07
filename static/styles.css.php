<?php header('Content-Type: text/css'); ?>
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 400;
  src: local('Roboto'), local('Roboto-Regular'), url(/static/fonts/roboto.woff2) format('woff2');
}
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 700;
  src: local('Roboto Bold'), local('Roboto-Bold'), url(/static/fonts/roboto700.woff2) format('woff2');
}
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
  display: block;
}
body {
  line-height: 1;
}
ol, ul {
  list-style: none;
}
blockquote, q {
  quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
  content: '';
  content: none;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
strong, b{
  font-weight: 700;
}
article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary {
  display: block;
}
html{height: 100%;}
body {
  font-size: 12px;
  font-family: 'Roboto', sans-serif;
  color: #333;
  background: #ebeff2;
  min-height: 100%;
}



.jodit_wysiwyg ul{list-style: circle;padding-left: 15px;}
.jodit_wysiwyg ol{list-style: decimal;padding-left: 15px;}
.jodit_wysiwyg h1{font-size: 28px;}
.jodit_wysiwyg h2{font-size: 24px;}
.jodit_wysiwyg h3{font-size: 20px;}
.jodit_wysiwyg h4{font-size: 18px;}
.jodit,.jodit *,.jodit_container,.jodit_container *{box-sizing:border-box}.jodit .jodit_workplace,.jodit_container .jodit_workplace{position:relative;overflow:auto}.jodit .jodit_workplace .jodit_wysiwyg,.jodit .jodit_workplace .jodit_wysiwyg_iframe,.jodit_container .jodit_workplace .jodit_wysiwyg,.jodit_container .jodit_workplace .jodit_wysiwyg_iframe{height:100%;width:100%}.jodit_container:not(.jodit_inline){background:#fff;font-size:14px;font-family:Helvetica,sans-serif}.jodit_container:not(.jodit_inline) .jodit_workplace{border:1px solid #ccc;border-top: none;}.jodit_disabled{-webkit-user-select:none!important;-moz-user-select:none!important;-ms-user-select:none!important;user-select:none!important}.jodit_hidden{display:none!important}.jodit_wysiwyg{outline:0}.jodit_wysiwyg::-moz-selection,.jodit_wysiwyg ::-moz-selection{background:#b5d6fd;color:#000}.jodit_wysiwyg::selection,.jodit_wysiwyg ::selection{background:#b5d6fd;color:#000}.jodit_container:not(.jodit_inline) .jodit_wysiwyg{margin:0;padding:10px;outline:0;overflow-x:auto;position:relative}.jodit_container:not(.jodit_inline) .jodit_wysiwyg img{position:relative;max-width:100%}.jodit_container:not(.jodit_inline) .jodit_wysiwyg p,.jodit_container:not(.jodit_inline) .jodit_wysiwyg pre{margin:0 0 10px}.jodit_container:not(.jodit_inline) .jodit_wysiwyg h1,.jodit_container:not(.jodit_inline) .jodit_wysiwyg h2,.jodit_container:not(.jodit_inline) .jodit_wysiwyg h3,.jodit_container:not(.jodit_inline) .jodit_wysiwyg h4,.jodit_container:not(.jodit_inline) .jodit_wysiwyg h5{margin-top:0}.jodit_container:not(.jodit_inline) .jodit_wysiwyg blockquote{border-left:1px solid #222;margin-left:0;padding-left:5px;color:#222}.jodit_clearfix:after,.jodit_clearfix:before{content:" ";display:table}.jodit_clearfix:after{clear:both}.jodit_dark_theme.jodit_container{background-color:#575757}.jodit_dark_theme .jodit_workplace{border-color:rgba(87,87,87,.8)}.jodit_dark_theme .jodit_statusbar{background-color:rgba(95,92,92,.8);border-color:rgba(87,87,87,.8)}.jodit_dark_theme .jodit_statusbar,.jodit_dark_theme .jodit_statusbar .jodit_statusbar_item span{color:#d1cccc}.jodit_dark_theme .jodit_toolbar_popup,.jodit_dark_theme .jodit_toolbar_popup-inline,.jodit_dark_theme .jodit_toolbar_popup-inline:before,.jodit_dark_theme .jodit_toolbar_popup:before{background:#575757}.jodit_dark_theme .jodit_toolbar{background:#5f5c5c;border-color:rgba(87,87,87,.8)}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn>a{color:#d1cccc}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn>a:hover{background-color:#575757}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn.jodit_toolbar_btn-break{border-top-color:#686767}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn.jodit_toolbar_btn-separator{border-right-color:#686767}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn.active,.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn.jodit_active,.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn:active,.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn:hover{background-color:#575757}.jodit_dark_theme .jodit_toolbar li.jodit_toolbar_btn.jodit_with_dropdownlist .jodit_with_dropdownlist-trigger{border-top-color:silver}.jodit_dark_theme .jodit_icon{fill:silver}.jodit_dark_theme .jodit_wysiwyg,.jodit_dark_theme .jodit_wysiwyg_iframe{background-color:#575757;color:#d1cccc}.jodit_dark_theme .jodit_wysiwyg [data-jodit-selected-cell],.jodit_dark_theme .jodit_wysiwyg_iframe [data-jodit-selected-cell]{border-color:#152f5f}.jodit_dark_theme .jodit_dropdownlist{background:#5f5c5c}.jodit_dark_theme .jodit_tabs .jodit_tabs_buttons>a{background-color:#686767;color:#d1cccc}.jodit_dark_theme .jodit_tabs .jodit_tabs_buttons>a:hover{background-color:hsla(0,0%,41%,.8);color:#d1cccc;border-color:hsla(0,0%,41%,.9)}.jodit_dark_theme .jodit_tabs .jodit_tabs_buttons>a.active{background:rgba(81,81,81,.41);border-color:#686767}.jodit_dark_theme .jodit_tabs .jodit_tabs_buttons>a svg{fill:silver}.jodit_dark_theme .jodit_form input[type=text],.jodit_dark_theme .jodit_form input[type=url],.jodit_dark_theme .jodit_form textarea{background-color:rgba(81,81,81,.41);border-color:#686767;color:#d1cccc}.jodit_dark_theme .jodit_form button{background-color:hsla(0,0%,41%,.75);color:#d1cccc}.jodit_dark_theme .jodit_placeholder{color:hsla(0,5%,81%,.8)}.jodit_dark_theme .jodit_draganddrop_file_box,.jodit_dark_theme .jodit_uploadfile_button{color:#d1cccc}.jodit_dark_theme .jodit_draganddrop_file_box:hover,.jodit_dark_theme .jodit_uploadfile_button:hover{background-color:hsla(0,0%,41%,.75)}.jodit_dark_theme .jodit-add-new-line:before{border-top-color:#686767}.jodit_dark_theme .jodit-add-new-line span{background:hsla(0,0%,41%,.75);border-color:#686767}.jodit_dark_theme .jodit-add-new-line span svg{fill:#d1cccc}.jodit_dark_theme .jodit_resizer>i{background:hsla(0,0%,41%,.75);border-color:silver}.jodit_btn{border:1px solid;border-radius:0;background-color:#f5f5f5;background-image:linear-gradient(180deg,#fff,#e6e6e6);border-color:#ccc;text-shadow:0 1px 1px hsla(0,0%,100%,.75);color:#333;background-repeat:repeat-x;outline:0;display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jodit_btn:hover{background-color:#e6e6e6;background-position:0 -15px;text-decoration:none}.jodit_btn.jodit_btn_success{text-shadow:0 -1px 0 rgba(0,0,0,.25);background-color:#5bb75b;background-image:linear-gradient(180deg,#62c462,#51a351);border-color:rgba(0,0,0,.1) rgba(0,0,0,.1) rgba(0,0,0,.25);color:#fff}.jodit_btn.jodit_btn_success svg{fill:#fff}.jodit_btn.jodit_btn_success:hover{background-color:#51a351}.jodit_btn.jodit_btn_danger{text-shadow:0 -1px 0 rgba(0,0,0,.25);background-color:#da4f49;background-image:linear-gradient(180deg,#ee5f5b,#bd362f);border-color:rgba(0,0,0,.1) rgba(0,0,0,.1) rgba(0,0,0,.25);color:#fff}.jodit_btn.jodit_btn_danger svg{fill:#fff}.jodit_btn.jodit_btn_danger:hover{background-color:#bd362f}.jodit_btn.jodit_btn_inverse{text-shadow:0 -1px 0 rgba(0,0,0,.25);background-color:#363636;background-image:linear-gradient(180deg,#444,#222);border-color:rgba(0,0,0,.1) rgba(0,0,0,.1) rgba(0,0,0,.25);color:#fff}.jodit_btn.jodit_btn_inverse svg{fill:#fff}.jodit_btn.jodit_btn_inverse:hover{background-color:#222}.jodit_btn.active,.jodit_btn:active{background-image:none;box-shadow:inset 0 2px 4px rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.05)}.jodit_btn_group{font-size:0;vertical-align:middle}.jodit_btn_group input{display:none}.jodit_btn_group button{float:left}.jodit_btn_group button+button{margin-left:-1px}.jodit_btn_group button:first-child,.jodit_btn_group input:first-child+button{border-right:0;border-top-right-radius:0;border-bottom-right-radius:0}.jodit_btn_group button:last-child,.jodit_btn_group input:last-child+button{border-left:0;border-top-left-radius:0;border-bottom-left-radius:0}.jodit_btn_group:after{content:"";clear:both;float:none;display:table}.jodit_context_menu{font-family:Helvetica,sans-serif;display:none;background:#fff;position:absolute;min-width:150px;box-shadow:0 0 5px 0 rgba(0,0,0,.24);z-index:16}.jodit_context_menu a{display:block;border-bottom:1px solid hsla(0,0%,80%,.24);text-decoration:none!important;color:#727272}.jodit_context_menu a svg{float:left;display:block;width:18px;height:28px;margin:0 4.5px;fill:#727272}.jodit_context_menu a span{margin-left:27px;display:block;padding:5px;border-left:1px solid hsla(0,0%,80%,.24);line-height:18px}.jodit_context_menu a:hover{background-color:#e3e3e3;color:#000}.jodit_context_menu a:hover .jodit_icon{fill:#000}.jodit_context_menu a:last-child{border:0}.jodit_context_menu-show{display:block}.jodit_dialog_box{box-sizing:border-box;display:none;width:0;height:0;border:0;position:absolute;will-change:left,top,width,height}.jodit_dialog_box.jodit_dialog_box-moved{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jodit_dialog_box *{box-sizing:border-box}.jodit_dialog_box .jodit_elfinder,.jodit_dialog_box .jodit_elfinder *{box-sizing:initial}.jodit_dialog_box .jodit_dialog_overlay{position:fixed;top:0;left:0;width:100%;height:100%;z-index:14;text-align:center;white-space:nowrap;overflow:auto;display:none;background-color:rgba(0,0,0,.5)}.jodit_dialog_box.active,.jodit_dialog_box.jodit_modal .jodit_dialog_overlay{display:block}.jodit_dialog_box .jodit_dialog{z-index:15;display:inline-block;vertical-align:middle;white-space:normal;text-align:left;position:fixed;left:0;top:0;background-color:#fff;box-shadow:0 10px 20px rgba(0,0,0,.19),0 6px 6px rgba(0,0,0,.23);min-width:200px;min-height:100px}@media (max-width:480px){.jodit_dialog_box .jodit_dialog{max-width:100%;width:100%!important;height:100%!important;top:0!important;left:0!important}}.jodit_dialog_box .jodit_dialog .jodit_promt{max-width:300px;min-width:200px;padding:10px;word-break:break-all}.jodit_dialog_box .jodit_dialog .jodit_promt label{margin-bottom:5px;display:block}.jodit_dialog_box .jodit_dialog .jodit_promt input[type=text]{display:block;border:1px solid #ccc;background:#fff;width:100%;height:28px;line-height:16px;padding:3px 6px;outline:0}.jodit_dialog_box .jodit_dialog .jodit_alert{max-width:300px;min-width:200px;padding:10px;word-break:break-all}.jodit_dialog_box .jodit_dialog .jodit_button{padding:0;margin:0;border:0;display:inline-block;vertical-align:top;width:32px;height:48px;line-height:48px;text-align:center;cursor:pointer;text-decoration:none}.jodit_dialog_box .jodit_dialog .jodit_button:not(.disabled):hover{background-color:#ecebe9}.jodit_dialog_box .jodit_dialog .jodit_button.disabled{opacity:.7}.jodit_dialog_box .jodit_dialog .jodit_input{border:1px solid #ccc;padding:5px;background-color:#fff;outline:0;width:120px;margin-left:10px;font:13px Arial;height:28px;vertical-align:middle}.jodit_dialog_box .jodit_dialog select.jodit_input{width:75px}.jodit_dialog_box .jodit_dialog .jodit_button .jodit_icon,.jodit_dialog_box .jodit_dialog .jodit_button svg,.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_icon,.jodit_dialog_box .jodit_dialog .jodit_dialog_header svg{width:16px;height:16px;display:inline-block;vertical-align:middle}.jodit_dialog_box .jodit_dialog .jodit_dialog_header{text-align:left;color:#222;box-shadow:0 1px 3px rgba(0,0,0,.16),0 1px 2px rgba(0,0,0,.23);cursor:move;height:48px;overflow:hidden}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title{font-size:18px;padding:0;padding-left:20px;margin:0;font-weight:400;line-height:48px;display:inline-block;vertical-align:top}@media (max-width:480px){.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title{padding-left:0}}.jodit_dialog_box .jodit_dialog .jodit_dialog_header button{margin-right:10px}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-button{color:#222;font-size:24px;font-weight:700;display:inline-block;transition:background-color .2s ease 0s;width:48px;height:48px;vertical-align:top;line-height:48px;text-decoration:none;text-align:center;float:right}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-button:hover{background-color:#ecebe9}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_close svg{width:18px;height:18px;margin:15px 0;vertical-align:top}.jodit_dialog_box .jodit_dialog .jodit_dialog_content{height:calc(100% - 48px);overflow:auto}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group{margin-bottom:10px;padding:0 10px}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group:first-child{margin-top:10px}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:700}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input.select,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=number],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=text],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=url],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select.select,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=number],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=text],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=url]{display:block;height:34px;padding:6px 4px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:0;box-shadow:inset 0 1px 1px rgba(0,0,0,.075);transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input.select:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=number]:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=text]:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=url]:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select.select:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=number]:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=text]:focus,.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=url]:focus{border-color:#66afe9;outline:0;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input.select[disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=number][disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=text][disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=url][disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select.select[disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=number][disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=text][disabled],.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=url][disabled]{background-color:#f0f0f0;color:#ccc}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input.select:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=number]:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=text]:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group input[type=url]:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select.select:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=number]:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=text]:not([class*=col-]),.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group select[type=url]:not([class*=col-]){width:100%}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group{display:table;border-collapse:separate;width:100%}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group>*{vertical-align:middle;display:table-cell;height:34px}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group>input{float:left;margin:0!important}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group>input:not([class*=col-]){width:100%}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group-buttons{width:1%;font-size:0;white-space:nowrap;vertical-align:middle}.jodit_dialog_box .jodit_dialog .jodit_dialog_content .jodit_form_group .jodit_input_group-buttons>a{text-align:center;display:inline-block;border:1px solid #ccc;margin-left:-1px;position:relative;height:34px;line-height:34px}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer{padding:0 10px;padding-top:10px;text-align:center;height:48px;display:none}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button{width:auto;margin-bottom:10px;height:32px;line-height:100%;padding:0 15px;background-color:#ccc;border:1px solid #ccc;color:#000;font-size:0}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button:before{content:"";display:inline-block;vertical-align:middle;height:100%}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button svg{display:inline-block;width:24px;height:24px;vertical-align:middle}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button span{display:inline-block;vertical-align:middle;font-size:14px;margin-left:5px}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button:focus{border:1px solid #8bade4;outline:1px solid #82b2e8}.jodit_dialog_box .jodit_dialog .jodit_dialog_footer .jodit_button:nth-child(n+2){margin-left:10px}.jodit_dialog_box .jodit_dialog.with_footer .jodit_dialog_content{height:calc(100% - 96px)}.jodit_dialog_box .jodit_dialog.with_footer .jodit_dialog_footer{display:block}.jodit_dialog_box .jodit_dialog .jodit_dialog_resizer{position:absolute;bottom:0;right:0;cursor:se-resize;width:7px;height:7px;display:inline-block;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADFJREFUeNpilJGRYcACIoB4ORMuCSCOZMIlga4TRQJZJ4YETCdWCSBmZMIlATIOIMAAEyAPt4RnNx0AAAAASUVORK5CYII=)}.jodit_dialog_box .jodit_dialog .jodit_dialog_resizer:hover{border-color:rgba(0,0,0,.6)}@media (max-width:480px){.jodit_dialog_box .jodit_dialog .jodit_dialog_resizer{display:none}}.jodit_dialog_box-fullsize .jodit_dialog{top:0!important;bottom:0!important;left:0!important;right:0!important;width:100%!important;height:100%!important}.jodit_dialog_box-fullsize .jodit_dialog .jodit_dialog_resizer{display:none}@media (max-width:768px){.jodit_dialog_header .jodit_input,.jodit_dialog_header_fullsize,.jodit_dialog_header_title{display:none!important}}.jodit_toolbar_list>.jodit_toolbar{max-height:400px;overflow:auto;box-shadow:0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23);padding:0;margin:auto;text-align:left;position:absolute;box-sizing:border-box;transition:max-height .2s ease 0s;margin-top:0!important;list-style-type:none;font-size:16px;z-index:9;left:0;top:100%}.jodit_toolbar_list>.jodit_toolbar,.jodit_toolbar_list>.jodit_toolbar .jodit_toolbar{background:#f9f9f9}.jodit_toolbar_list>.jodit_toolbar blockquote,.jodit_toolbar_list>.jodit_toolbar h1,.jodit_toolbar_list>.jodit_toolbar h2,.jodit_toolbar_list>.jodit_toolbar h3,.jodit_toolbar_list>.jodit_toolbar h4,.jodit_toolbar_list>.jodit_toolbar h5,.jodit_toolbar_list>.jodit_toolbar p,.jodit_toolbar_list>.jodit_toolbar pre{font-family:Helvetica,sans-serif;margin:0;padding:0;font-weight:400}.jodit_toolbar_list>.jodit_toolbar h5{font-size:.8em;line-height:1.4}.jodit_toolbar_list>.jodit_toolbar h3{font-size:1.31em;line-height:1.4}.jodit_toolbar_list>.jodit_toolbar h4,.jodit_toolbar_list>.jodit_toolbar p{font-size:1em;line-height:1.5em}.jodit_toolbar_list>.jodit_toolbar h2{font-size:1.74em;line-height:1.4}.jodit_toolbar_list>.jodit_toolbar h1{font-size:2.17em;line-height:1.4}.jodit_toolbar_list>.jodit_toolbar blockquote,.jodit_toolbar_list>.jodit_toolbar pre{font-family:monospace}.jodit_toolbar_list>.jodit_toolbar li.jodit_toolbar_btn{display:block;cursor:pointer;white-space:nowrap;color:inherit;text-decoration:none;width:100%;height:auto;box-sizing:border-box;text-align:left}.jodit_toolbar_list>.jodit_toolbar li.jodit_toolbar_btn>a{background-image:none;padding:7px 24px;cursor:pointer;line-height:100%;width:auto;height:auto;display:block}.jodit_toolbar_list>.jodit_toolbar li.jodit_toolbar_btn>a>span{display:inline-block}.jodit_toolbar_list>.jodit_toolbar li.jodit_toolbar_btn>a:hover{background-color:#f3f0f0}.jodit_toolbar_list>.jodit_toolbar li.jodit_toolbar_btn>a:after{display:none}.jodit_filebrowser{font-family:Helvetica,sans-serif;font-size:0;height:100%}.jodit_filebrowser .jodit_filebrowser_loader{height:100%;width:100%;position:absolute;top:0;left:0}.jodit_filebrowser .jodit_filebrowser_loader i{position:absolute;top:50%;left:50%;margin-top:-64px;margin-left:-64px}.jodit_filebrowser .jodit_filebrowser_status{position:absolute;font-size:10px;padding:2px 3px;border-top:1px solid hsla(0,0%,50%,.4);left:31%;right:0;bottom:0;background-color:#4a4a4a;visibility:hidden;opacity:0;transition:opacity .3s linear;color:#b38888;word-break:break-all}.jodit_filebrowser .jodit_filebrowser_status.success{color:#c5c5c5}.jodit_filebrowser .jodit_filebrowser_status.active{visibility:visible;opacity:1}.jodit_filebrowser .jodit_filebrowser_files,.jodit_filebrowser .jodit_filebrowser_tree{display:none;vertical-align:top;height:100%;position:relative}.jodit_filebrowser .jodit_filebrowser_files.active,.jodit_filebrowser .jodit_filebrowser_tree.active{display:inline-block}.jodit_filebrowser .jodit_filebrowser_files::-webkit-scrollbar,.jodit_filebrowser .jodit_filebrowser_tree::-webkit-scrollbar{width:5px}.jodit_filebrowser .jodit_filebrowser_files::-webkit-scrollbar-track,.jodit_filebrowser .jodit_filebrowser_tree::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3)}.jodit_filebrowser .jodit_filebrowser_files::-webkit-scrollbar-thumb,.jodit_filebrowser .jodit_filebrowser_tree::-webkit-scrollbar-thumb{background-color:#a9a9a9;outline:1px solid #708090}.jodit_filebrowser .jodit_filebrowser_tree.active{width:31%;background-color:#3f3f3f;overflow-y:auto}@media (max-width:480px){.jodit_filebrowser .jodit_filebrowser_tree.active{display:none}}.jodit_filebrowser .jodit_filebrowser_tree.active::-webkit-scrollbar{width:5px}.jodit_filebrowser .jodit_filebrowser_tree.active::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3)}.jodit_filebrowser .jodit_filebrowser_tree.active::-webkit-scrollbar-thumb{background-color:hsla(0,0%,50%,.5);outline:1px solid #708090}.jodit_filebrowser .jodit_filebrowser_tree.active .jodit_filebrowser_source_title{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;display:block;padding:10px;color:#969696;border-bottom:1px solid #484848;line-height:17px;min-height:38px;position:relative;word-break:break-all;background:#5a5a5a;font-size:16px}.jodit_filebrowser .jodit_filebrowser_tree.active a{display:block;padding:10px 20px;text-decoration:none;color:#b1b1b1;font-weight:600;transition:background-color .2s ease 0s;border-bottom:1px solid #474747;line-height:17px;min-height:38px;position:relative;word-break:break-all;font-size:16px}.jodit_filebrowser .jodit_filebrowser_tree.active a i.remove{height:16px;width:16px;line-height:17px;font-size:16px;position:absolute;right:5px;top:11px;opacity:0;padding-left:3px;display:inline-block}.jodit_filebrowser .jodit_filebrowser_tree.active a i.remove:hover{background:#696969}.jodit_filebrowser .jodit_filebrowser_tree.active a:hover{color:#222;background-color:#ecebe9}.jodit_filebrowser .jodit_filebrowser_tree.active a:hover i.remove{opacity:.6}.jodit_filebrowser .jodit_filebrowser_tree.active a.jodit_button{cursor:pointer;background:#696969;text-align:center;width:auto;height:38px;color:#333}.jodit_filebrowser .jodit_filebrowser_tree.active a.jodit_button svg{vertical-align:top}.jodit_filebrowser .jodit_filebrowser_tree.active a.jodit_button:not(.disabled):hover{background-color:#ecebe9}.jodit_filebrowser .jodit_filebrowser_tree.active a.jodit_button.disabled,.jodit_filebrowser .jodit_filebrowser_tree.active a.jodit_button:hover i{opacity:.7}.jodit_filebrowser .jodit_filebrowser_files.active{width:100%;overflow-y:auto;padding:10px}.jodit_filebrowser .jodit_filebrowser_files.active .jodit_filebrowser_source_title{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;margin:-10px -10px 0;display:block;padding:10px;line-height:17px;min-height:38px;position:relative;word-break:break-all;background:#5a5a5a;font-size:16px;color:#969696}.jodit_filebrowser .jodit_filebrowser_files.active a+.jodit_filebrowser_source_title{margin-top:10px}.jodit_filebrowser .jodit_filebrowser_files.active a{vertical-align:top;display:inline-block;width:150px;height:150px;line-height:150px;text-align:center;border:1px solid #ccc;margin:5px 5px 10px;font-size:0;overflow:hidden;transition:border .1s linear,bottom .1s linear;box-sizing:content-box;position:relative}.jodit_filebrowser .jodit_filebrowser_files.active a img{max-width:100%;vertical-align:middle}.jodit_filebrowser .jodit_filebrowser_files.active a:hover{border-color:#433b5c}.jodit_filebrowser .jodit_filebrowser_files.active a.active{border-color:#1e88e5;background-color:#b5b5b5}.jodit_filebrowser .jodit_filebrowser_files.active a .jodit_filebrowser_files_item-info{position:absolute;right:0;left:0;bottom:0;white-space:normal;opacity:.85;overflow:visible;padding:.3em .6em;transition:opacity .4s ease;background-color:#e9e9e9;color:#333;text-shadow:#eee 0 1px 0;font-size:14px;line-height:16px;text-align:left}.jodit_filebrowser .jodit_filebrowser_files.active a .jodit_filebrowser_files_item-info>span{display:block;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;font-size:.75em}.jodit_filebrowser .jodit_filebrowser_files.active a .jodit_filebrowser_files_item-info>span.jodit_filebrowser_files_item-info-filename{font-weight:700;font-size:.9em}.jodit_filebrowser .jodit_filebrowser_files.active a.active .jodit_filebrowser_files_item-info{background-color:#b5b5b5;color:#fff;text-shadow:none}.jodit_filebrowser .jodit_filebrowser_files.active a:hover .jodit_filebrowser_files_item-info{bottom:-100px}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a{display:block;width:100%;height:26px;line-height:26px;margin:0;border-width:0 0 1px;text-align:left;white-space:nowrap}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a img{min-width:16px;max-width:16px;vertical-align:middle;display:inline-block;margin-left:4px}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a .jodit_filebrowser_files_item-info{padding:0;position:static;display:inline-block;width:calc(100% - 20px);margin-left:4px;background-color:transparent;height:100%;line-height:inherit;vertical-align:middle;font-size:0}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a .jodit_filebrowser_files_item-info>span{display:inline-block;height:100%;font-size:12px}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a .jodit_filebrowser_files_item-info>span.jodit_filebrowser_files_item-info-filename{width:50%}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a .jodit_filebrowser_files_item-info>span.jodit_filebrowser_files_item-info-filechanged,.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a .jodit_filebrowser_files_item-info>span.jodit_filebrowser_files_item-info-filesize{width:25%}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a:hover{background-color:#433b5c}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a:hover .jodit_filebrowser_files_item-info{color:#fff;text-shadow:none}.jodit_filebrowser .jodit_filebrowser_files.active.jodit_filebrowser_files_view-list a:before{height:100%;content:"";vertical-align:middle;display:inline-block}.jodit_filebrowser .jodit_filebrowser_tree.active+.jodit_filebrowser_files.active{width:69%}@media (max-width:480px){.jodit_filebrowser .jodit_filebrowser_tree.active+.jodit_filebrowser_files.active{width:auto;display:block}}.jodit_filebrowser_preview{text-align:center;min-width:300px;max-width:900px;max-height:700px;position:relative}.jodit_filebrowser_preview .jodit_filebrowser_preview_navigation{position:absolute;top:0;height:100%;left:0}.jodit_filebrowser_preview .jodit_filebrowser_preview_navigation-next{left:auto;right:0}.jodit_filebrowser_preview .jodit_filebrowser_preview_navigation svg{width:45px;height:45px;position:relative;top:50%;margin-top:-22px;transition:fill .3s linear;fill:#9e9ba7}.jodit_filebrowser_preview .jodit_filebrowser_preview_navigation:hover svg{fill:#000}.jodit_filebrowser_preview img{max-width:100%;max-height:100%}.jodit_draghover{background-color:#ecebe9}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_upload_button{position:relative;width:220px;border:0;padding:25px 0;margin:10px 0;overflow:hidden}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_upload_button input{cursor:pointer;position:absolute;top:0;bottom:0;right:0;margin:0 -10px 0 0;padding:0;opacity:0;font-size:400px}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_toolbar{background:0 0;display:block;height:100%;border:0}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_toolbar>li.jodit_toolbar_btn{vertical-align:middle}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_toolbar>li.jodit_toolbar_btn input,.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title .jodit_toolbar>li.jodit_toolbar_btn select{margin:0 5px;padding-left:10px;width:auto}.jodit_dialog_box .jodit_dialog .jodit_dialog_header .jodit_dialog_header-title.jodit_filebrowser_title_box{padding-left:10px}.jodit_grid{width:100%}.jodit_grid [class*=jodit_col-]{display:block;float:left}.jodit_grid .jodit_col-lg-5-5{width:100%}.jodit_grid .jodit_col-lg-4-5{width:80%}.jodit_grid .jodit_col-lg-3-5{width:60%}.jodit_grid .jodit_col-lg-2-5{width:40%}.jodit_grid .jodit_col-lg-1-5{width:20%}.jodit_grid .jodit_col-lg-4-4{width:100%}.jodit_grid .jodit_col-lg-3-4{width:75%}.jodit_grid .jodit_col-lg-2-4{width:50%}.jodit_grid .jodit_col-lg-1-4{width:25%}.jodit_grid:after,.jodit_grid:before{content:" ";display:table}.jodit_grid:after{clear:both}@keyframes a{to{transform:rotate(1turn)}}.jodit_icon-loader{background:url(data:image/png;base64,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) no-repeat 50%;background-size:100% 100%;width:128px;height:128px;will-change:transform;animation:a 2s ease-out 0s infinite}.jodit_icon,.jodit_icon-loader{display:inline-block;vertical-align:middle}.jodit_icon{font-style:normal;width:14px;font-size:8px;fill:#222;transform-origin:0 0!important;overflow:visible}.jodit_text_icon{font-size:14px}.jodit_toolbar_size-small .jodit_icon{min-width:12px;height:12px;line-height:12px}.jodit_toolbar_size-large .jodit_icon{min-width:16px;height:16px;line-height:16px}.jodit_image_editor{width:100%;height:100%;padding:10px;overflow:hidden}@media (max-width:768px){.jodit_image_editor{height:auto}}.jodit_image_editor>div,.jodit_image_editor>div>div{height:100%}@media (max-width:768px){.jodit_image_editor>div,.jodit_image_editor>div>div{height:auto;min-height:200px}}.jodit_image_editor *{box-sizing:border-box}.jodit_image_editor .jodit_image_editor_slider-title{text-shadow:#f3f3f3 0 1px 0;color:#333;border-bottom:1px solid hsla(0,0%,62%,.31);background-color:#f9f9f9;padding:.8em 1em;text-overflow:ellipsis;white-space:nowrap;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;font-weight:700;line-height:1em}.jodit_image_editor .jodit_image_editor_slider-title svg{margin-right:10px;width:16px;display:inline-block;vertical-align:middle}.jodit_image_editor .jodit_image_editor_slider-content{display:none}.jodit_image_editor .jodit_image_editor_slider.active .jodit_image_editor_slider-title{background-color:#5d5d5d;color:#fff;text-shadow:#000 0 1px 0}.jodit_image_editor .jodit_image_editor_slider.active .jodit_image_editor_slider-title svg{fill:#fff}.jodit_image_editor .jodit_image_editor_slider.active .jodit_image_editor_slider-content{display:block}.jodit_image_editor_area{background-color:#eee;background-image:linear-gradient(45deg,#ccc 25%,transparent 0,transparent 75%,#ccc 0,#ccc),linear-gradient(45deg,#ccc 25%,transparent 0,transparent 75%,#ccc 0,#ccc);background-size:30px 30px;background-position:0 0,15px 15px;height:100%;overflow:hidden;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;position:relative;display:none}.jodit_image_editor_area.active{display:block}.jodit_image_editor_area .jodit_image_editor_box{overflow:hidden;position:relative;z-index:1;pointer-events:none;height:100%}.jodit_image_editor_area .jodit_image_editor_box img{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;max-width:100%;max-height:100%}.jodit_image_editor_area .jodit_image_editor_croper,.jodit_image_editor_area .jodit_image_editor_resizer{z-index:2;width:100px;height:100px;position:absolute;box-shadow:0 0 11px #000;border:1px solid #fff;background-repeat:no-repeat;top:10px;left:20px;pointer-events:none}.jodit_image_editor_area .jodit_image_editor_croper i.jodit_bottomright,.jodit_image_editor_area .jodit_image_editor_resizer i.jodit_bottomright{position:absolute;display:inline-block;border:1px solid #383838;z-index:4;background-color:#8c7878;cursor:se-resize;border-radius:10px;height:20px;width:20px;right:-10px;bottom:-10px;box-shadow:0 0 11px #000;pointer-events:all}.jodit_image_editor_area .jodit_image_editor_croper i.jodit_bottomright:active,.jodit_image_editor_area .jodit_image_editor_resizer i.jodit_bottomright:active{border:1px solid #ff0}.jodit_image_editor_area.jodit_image_editor_area_crop{height:100%;background:#eee;text-align:center;line-height:100%;position:relative}.jodit_image_editor_area.jodit_image_editor_area_crop:before{content:"";line-height:100%;vertical-align:middle;height:100%;display:inline-block}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box{height:100%;overflow:visible;display:inline-block;vertical-align:middle;pointer-events:all;font-size:0;text-align:left;line-height:100%}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box img{max-width:100%;max-height:100%}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box:before{content:"";line-height:100%;vertical-align:middle;height:100%;display:inline-block}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box:after{content:"";position:absolute;top:0;left:0;bottom:0;right:0;margin:auto;background:hsla(0,0%,100%,.3);z-index:1}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box .jodit_image_editor_croper{pointer-events:all;cursor:move}.jodit_image_editor_area.jodit_image_editor_area_crop .jodit_image_editor_box .jodit_image_editor_croper i.jodit_sizes{font-size:12px;white-space:pre;position:absolute;bottom:-30px;left:100%;text-align:center;color:#fff;text-shadow:none;background:rgba(0,0,0,.2);border-radius:.4em;padding:9px 6px;display:block}.jodit_properties svg{font-style:normal;display:inline-block;width:14px;height:14px;line-height:14px;font-size:8px;overflow:hidden;vertical-align:middle;fill:#222;transform-origin:0 0!important}.jodit_properties #tabsbox{padding:10px}.jodit_properties #tabsbox .jodit_form_group{padding:0}.jodit_properties .jodit_properties_view_box{padding:10px}.jodit_properties .jodit_properties_view_box .jodit_properties_image_view{height:150px;text-align:center;line-height:1;vertical-align:middle;padding:0;background-color:#f6f6f6;margin:0;vertical-align:baseline;font-size:100%;margin-bottom:10px}.jodit_properties .jodit_properties_view_box .jodit_properties_image_view:before{content:"";display:inline-block;vertical-align:middle;height:100%}.jodit_properties .jodit_properties_view_box .jodit_properties_image_view img{max-width:100%;max-height:100%;vertical-align:middle}.jodit_properties .jodit_properties_view_box .jodit_properties_image_sizes.jodit_form_group{padding:0!important;margin:0!important}.jodit_properties .jodit_properties_view_box .jodit_properties_image_sizes.jodit_form_group a{display:inline-block;cursor:pointer}.jodit_properties .jodit_properties_view_box .jodit_properties_image_sizes.jodit_form_group input[type=number]{display:inline-block!important;width:calc(50% - 8px)!important}.jodit_toolbar,.jodit_toolbar *{box-sizing:border-box}
.jodit_toolbar{
  position:relative;
  left:0;top:0;margin:0!important;padding:0!important;list-style:none!important;font-size:0;background:#fff;
  box-shadow:0 4px 4px -2px rgba(0,0,0,.14);z-index:5;border:1px solid #ccc;border-bottom:0;min-height:16px!important;
-webkit-border-top-left-radius: 5px;
-moz-border-top-left-radius: 5px;
border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-moz-border-top-right-radius: 5px;
border-top-right-radius: 5px;
}
.jodit_toolbar+.jodit_toolbar_dummy{display:none}.jodit_toolbar.jodit_fly{position:absolute;left:0;right:0;z-index:11;background:#fff}.jodit_toolbar.jodit_sticky{position:fixed;position:-webkit-sticky;position:sticky;z-index:3;top:0;left:auto}.jodit_toolbar.jodit_sticky+.jodit_toolbar_dummy{display:block}.jodit_toolbar .jodit_toolbar_btn>a{color:#000;text-decoration:none;display:block;background:no-repeat 50%}.jodit_toolbar>li.jodit_toolbar_btn{display:inline-block;vertical-align:top;margin:0!important;padding:0;list-style:none!important;outline:0;position:relative;text-align:center;cursor:pointer;transition:background-color .2s linear,opacity .1s linear}.jodit_toolbar>li.jodit_toolbar_btn.jodit_disabled{background-color:transparent!important;opacity:.3;cursor:default}.jodit_toolbar>li.jodit_toolbar_btn.jodit_disabled a{cursor:default}.jodit_toolbar>li.jodit_toolbar_btn.jodit_toolbar_btn-separator{border-left:0;border-right:1px solid #e6e6e6;padding:0;margin:2px 3px 0!important;cursor:default}.jodit_toolbar>li.jodit_toolbar_btn.jodit_toolbar_btn-break{display:block!important;width:auto;border-top:1px solid #e6e6e6;height:0;margin:0 3px!important}.jodit_toolbar>li.jodit_toolbar_btn .jodit_toolbar_btn>a,.jodit_toolbar>li.jodit_toolbar_btn>a{width:100%;height:100%;display:inline-block;outline:0;text-decoration:none}.jodit_toolbar>li.jodit_toolbar_btn .jodit_toolbar_btn>a:after,.jodit_toolbar>li.jodit_toolbar_btn>a:after{content:"";display:inline-block;height:100%;vertical-align:middle}.jodit_toolbar>li.jodit_toolbar_btn .jodit_toolbar_btn>a:active+.jodit_tooltip,.jodit_toolbar>li.jodit_toolbar_btn>a:active+.jodit_tooltip{visibility:hidden!important}.jodit_toolbar>li.jodit_toolbar_btn.jodit_disabled .jodit_tooltip{display:none!important}.jodit_toolbar>li.jodit_toolbar_btn>a{line-height:100%}.jodit_toolbar>li.jodit_toolbar_btn.jodit_dropdown_open .jodit_tooltip,.jodit_toolbar>li.jodit_toolbar_btn .jodit_popap_open,.jodit_toolbar>li.jodit_toolbar_btn.jodit_popup_open .jodit_tooltip{visibility:hidden!important}.jodit_toolbar>li.jodit_toolbar_btn:not(.jodit_toolbar-input):hover{background-color:#dde4ef;outline:0}.jodit_toolbar>li.jodit_toolbar_btn.jodit_active,.jodit_toolbar>li.jodit_toolbar_btn:not(.jodit_toolbar-input):active{background-color:hsla(0,0%,87%,.4);outline:0}.jodit_toolbar>li.jodit_toolbar_btn.jodit-btn-hidden{display:none!important}.jodit_toolbar>li.jodit_toolbar_btn.jodit_with_dropdownlist .jodit_with_dropdownlist-trigger{width:0;height:0;border-right:3px solid transparent;border-left:3px solid transparent;border-top:3px solid #4c4c4c;display:inline-block;vertical-align:middle;margin-left:3px}.jodit_toolbar>li.jodit_toolbar_btn.jodit_toolbar-input input,.jodit_toolbar>li.jodit_toolbar_btn.jodit_toolbar-input select{-webkit-appearance:none;-moz-appearance:none;appearance:none;height:100%;border-radius:0;outline:0;line-height:100%}.jodit_toolbar>li.jodit_toolbar_btn.jodit_toolbar-input select{padding-right:20px;background:url(data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0Ljk1IDEwIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjt9LmNscy0ye2ZpbGw6IzQ0NDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmFycm93czwvdGl0bGU+PHJlY3QgY2xhc3M9ImNscy0xIiB3aWR0aD0iNC45NSIgaGVpZ2h0PSIxMCIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMiIgcG9pbnRzPSIxLjQxIDQuNjcgMi40OCAzLjE4IDMuNTQgNC42NyAxLjQxIDQuNjciLz48cG9seWdvbiBjbGFzcz0iY2xzLTIiIHBvaW50cz0iMy41NCA1LjMzIDIuNDggNi44MiAxLjQxIDUuMzMgMy41NCA1LjMzIi8+PC9zdmc+) no-repeat 98% 50%!important}.jodit_toolbar>li{min-width:32px;height:32px;line-height:32px}.jodit_toolbar>li.jodit_toolbar_btn-separator{height:28px;width:0;min-width:0}.jodit_tooltip{position:fixed;background:#727171;color:#fff;font-size:12px;line-height:15px;padding:4px 5px;font-family:Arial,sans-serif;z-index:10;width:90px;transition:opacity .3s linear}@media (max-width:768px){.jodit_tooltip{display:none}}.jodit_toolbar_size-small .jodit_toolbar{min-height:12px!important}.jodit_toolbar_size-small .jodit_toolbar>li{min-width:24px;height:24px;line-height:24px}.jodit_toolbar_size-small .jodit_toolbar>li.jodit_toolbar_btn-separator{height:20px;width:0;min-width:0}.jodit_toolbar_size-large .jodit_toolbar{min-height:18px!important}
.jodit_toolbar_size-large .jodit_toolbar>li{min-width:36px;height:40px;line-height:40px}.jodit_toolbar_size-large .jodit_toolbar>li.jodit_toolbar_btn-separator{height:32px;width:0;min-width:0}.jodit_toolbar_popup{position:absolute;z-index:8;top:100%;margin-top:10px;padding-top:0;left:0;font-size:14px;line-height:14px!important;background:#fff;box-shadow:0 2px 4px rgba(0,0,0,.2);border:1px solid rgba(0,0,0,.2)}.jodit_toolbar_popup .jodit_toolbar{box-shadow:none;border-width:0;background-color:transparent}.jodit_toolbar_popup .jodit_toolbar .jodit_toolbar{background-color:#f9f9f9;box-shadow:0 4px 4px -2px rgba(0,0,0,.14);border:1px solid #ccc}.jodit_toolbar_popup>*{margin:10px}.jodit_toolbar_popup .jodit_popup_triangle{padding:0;margin:0;width:8px;height:8px;position:absolute;top:-5px;left:9px;display:inline-block;transform:rotate(45deg);background:#fff;border:1px solid rgba(0,0,0,.2);border-width:1px 0 0 1px;z-index:6}.jodit_toolbar_popup.jodit_right{left:auto;right:0}.jodit_toolbar_popup.jodit_right:before{left:auto;right:14px}.jodit_toolbar .jodit_toolbar_btn>svg{max-width:50%;vertical-align:middle;font-smoothing:antialiased}.jodit_container>.jodit_toolbar>li:first-child{margin-left:2px!important}.jodit_draganddrop_file_box,.jodit_uploadfile_button{position:relative;width:220px;border:1px dashed #ccc;padding:25px 0;margin:10px 0;text-align:center;overflow:hidden}.jodit_draganddrop_file_box:hover,.jodit_uploadfile_button:hover{background-color:#ecebe9}.jodit_draganddrop_file_box input,.jodit_uploadfile_button input{cursor:pointer;position:absolute;top:0;bottom:0;right:0;margin:0;padding:0;opacity:0;font-size:400px}@media (max-width:768px){.jodit_draganddrop_file_box{width:auto;max-width:100%;min-width:120px}}
.jodit_statusbar{border:1px solid #ccc;border-top:0;font-size:0;background-color:#f9f9f9;padding:0 5px;
-webkit-border-bottom-left-radius: 5px;
-moz-border-bottom-left-radius: 5px;
border-bottom-left-radius: 5px;
-webkit-border-bottom-right-radius: 5px;
-moz-border-bottom-right-radius: 5px;
border-bottom-right-radius: 5px;
}
.jodit_statusbar .jodit_statusbar_item{font-size:11px;float:left;line-height:1.57142857em;margin:0 10px 0 0;padding:0;vertical-align:middle}.jodit_statusbar .jodit_statusbar_item.jodit_statusbar_item-right{float:right;margin:0 0 0 10px}.jodit_statusbar .jodit_statusbar_item li,.jodit_statusbar .jodit_statusbar_item ul{margin:0;padding:0;list-style:none;display:inline-block;vertical-align:top;position:relative}.jodit_statusbar .jodit_statusbar_item li li,.jodit_statusbar .jodit_statusbar_item ul li{margin-right:5px}.jodit_statusbar .jodit_statusbar_item a,.jodit_statusbar .jodit_statusbar_item span{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;display:inline-block;vertical-align:baseline;text-align:left;white-space:nowrap;padding:2px 3px;line-height:10px;outline:0;border:0;color:#222}.jodit_statusbar .jodit_statusbar_item a span,.jodit_statusbar .jodit_statusbar_item span span{padding:0}.jodit_statusbar .jodit_statusbar_item svg{width:11px;height:11px;display:inline-block;vertical-align:top}.jodit_statusbar .jodit_statusbar_item a{text-decoration:none;cursor:default;border-radius:3px}.jodit_statusbar .jodit_statusbar_item a:hover{background-color:hsla(0,0%,88%,.99);text-decoration:none;color:#222}.jodit_statusbar:after{content:" ";display:block;visibility:hidden;font-size:0;height:0;float:none;clear:both}.jodit_form{color:#000}.jodit_form input[type=text],.jodit_form input[type=url],.jodit_form textarea{-webkit-appearance:none;-moz-appearance:none;display:block;outline:0;border:1px solid #b5b5b5;height:28px;line-height:28px;padding:0 5px;min-width:220px;margin-top:10px}.jodit_form input[type=text].jodit_error,.jodit_form input[type=url].jodit_error,.jodit_form textarea.jodit_error{border-color:#f7d1d1;box-shadow:inset 0 0 3px 0 hsla(0,0%,74%,.3)}@media (max-width:768px){.jodit_form input[type=text],.jodit_form input[type=url],.jodit_form textarea{min-width:150px}}.jodit_form textarea{height:128px}.jodit_form button{height:36px;line-height:1;color:#000;padding:10px;cursor:pointer;text-decoration:none;border:none;background:#d6d6d6;font-size:16px;outline:0;transition:background .2s ease 0s;margin-top:10px;margin-bottom:10px}.jodit_form button:hover{background-color:#ecebe9;color:#000}.jodit_form button:active{background:#ecebe9;color:#000}.jodit_form input[type=checkbox]{display:inline-block;z-index:2;border:0 none;cursor:pointer;height:16px;margin:0;padding:0;width:16px;position:relative;outline:0;top:3px}.jodit_form input[type=checkbox]:after{content:"";background:#fff;border:1px solid hsla(0,0%,88%,.99);border-radius:2px;background-clip:padding-box;width:16px;height:16px;display:inline-block;position:relative;z-index:1;box-sizing:border-box;transition:background .2s ease 0s,border-color .2s ease 0s}.jodit_form input[type=checkbox]:checked:after{background:url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cpath d='M27 4L12 19l-7-7-5 5 12 12L32 9z' fill='%23FFF'/%3E%3C/svg%3E") no-repeat 50%;background-color:#b5b5b5;border-color:#b5b5b5}.jodit_form label{margin-top:10px;display:block;text-align:left}.jodit_form form:after{content:"";display:table;clear:both}.jodit_about{padding:20px}.jodit_about a{color:#459ce7;text-decoration:none}.jodit_about a:focus,.jodit_about a:hover{color:#23527c;text-decoration:underline;outline:0}.jodit_about div{margin-bottom:5px}.jodit_colorpicker{min-width:180px;text-align:left;margin:0;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jodit_colorpicker .jodit_colorpicker_group{margin-bottom:5px;white-space:normal}.jodit_colorpicker a{width:18px;height:18px;line-height:16px;display:inline-block;text-decoration:none;vertical-align:middle;text-align:center}.jodit_colorpicker a.jodit_text_icon{width:auto;text-decoration:none;color:#000}.jodit_colorpicker a:before{content:"";display:inline-block;height:100%;vertical-align:middle;width:0}.jodit_colorpicker a svg{display:inline-block;vertical-align:middle;font-smoothing:antialiased;max-width:14px}.jodit_colorpicker a:hover{border-color:#000}.jodit_colorpicker a:active{background:#d6d6d6;color:#b5b5b5}@keyframes b{30%{opacity:.6}60%{opacity:0}to{opacity:.6}}.jodit_progress_bar{position:absolute;top:0;left:0;height:2px;z-index:17;border-radius:1px;display:none}.jodit_progress_bar div{position:relative;background:#b91f1f;height:2px;transition:width .5s ease-out,opacity .5s linear;will-change:width,opacity}.jodit_progress_bar div:after,.jodit_progress_bar div:before{animation:b 2s ease-out 0s infinite;content:"";display:inline-block;position:absolute;top:0;height:2px;box-shadow:1px 0 6px 1px #b91f1f;border-radius:100%;opacity:.6}.jodit_progress_bar div:before{width:180px;right:-80px;clip:rect(-6px,90px,14px,-6px)}.jodit_progress_bar div:after{width:20px;right:0;clip:rect(-6px,22px,14px,10px)}.jodit_tabs .jodit_tabs_buttons{line-height:18px;margin-bottom:5px;margin-top:4px}.jodit_tabs .jodit_tabs_buttons>a{display:inline-block;text-decoration:none;font-size:11px;font-weight:700;text-align:center;white-space:nowrap;height:29px;line-height:27px;position:relative;vertical-align:middle;transition:background .1s linear;text-overflow:ellipsis;overflow:hidden;box-shadow:none;background-color:#f5f5f5;color:#737373;border:1px solid rgba(0,0,0,.1);outline:0}@media (max-width:768px){.jodit_tabs .jodit_tabs_buttons>a{width:100%!important;border-radius:0!important}}.jodit_tabs .jodit_tabs_buttons>a+a{margin-left:-1px}.jodit_tabs .jodit_tabs_buttons>a i,.jodit_tabs .jodit_tabs_buttons>a svg{width:16px;height:16px;display:inline-block;vertical-align:sub;margin-right:5px;fill:#737373}.jodit_tabs .jodit_tabs_buttons>a:hover{border:1px solid #c6c6c6;color:#111;box-shadow:none;background-color:#f8f8f8;outline:0}.jodit_tabs .jodit_tabs_buttons>a:hover i,.jodit_tabs .jodit_tabs_buttons>a:hover svg{fill:#111}.jodit_tabs .jodit_tabs_buttons>a.active,.jodit_tabs .jodit_tabs_buttons>a:active{outline:0;background:#fff;border:1px solid #ccc;color:#333}.jodit_tabs .jodit_tabs_buttons>a.active i,.jodit_tabs .jodit_tabs_buttons>a.active svg,.jodit_tabs .jodit_tabs_buttons>a:active i,.jodit_tabs .jodit_tabs_buttons>a:active svg{fill:#333}.jodit_tabs .jodit_tabs_wrapper .jodit_tab{display:none}.jodit_tabs .jodit_tabs_wrapper .jodit_tab.active{display:block}.jodit_tabs .jodit_tabs_wrapper .jodit_tab .jodit_tab_empty{min-width:220px;min-height:100px}.jodit-add-new-line{z-index:1;position:absolute;height:20px;line-height:100%;vertical-align:middle;font-size:0;top:0;outline:0;margin-top:-10px;display:none}.jodit-add-new-line,.jodit-add-new-line *{box-sizing:border-box}.jodit-add-new-line:before{height:100%}.jodit-add-new-line:after,.jodit-add-new-line:before{display:inline-block;vertical-align:middle;content:""}.jodit-add-new-line:after{box-sizing:border-box;border-top:1px solid #ccc;height:1px;width:calc(100% - 30px)}.jodit-add-new-line span{right:0;position:absolute;display:inline-block;width:30px;height:20px;background:hsla(40,7%,92%,.3);vertical-align:top;border:1px solid #ccc;padding:0 5px;cursor:pointer}.jodit-add-new-line span:hover{background:#ecebe9}.jodit-add-new-line svg{width:16px;fill:#ccc;vertical-align:top}.jodit_source_mode .jodit-add-new-line{display:none!important}.jodit_error_box_for_messages{position:absolute;right:0;bottom:0;width:0;height:0;overflow:visible;z-index:3}.jodit_error_box_for_messages>*{position:absolute;right:5px;bottom:0;display:block;transition:opacity .1s linear,bottom .3s linear;opacity:0;background:rgba(255,0,0,.29);color:#e02b2b;padding:2px 7px;border:1px solid hsla(0,65%,67%,.44);font-size:14px;white-space:pre}.jodit_error_box_for_messages>.active{opacity:1}.jodit_error_box_for_messages>.info{background:rgba(204,229,247,.71);color:#776565;border:1px solid hsla(0,0%,60%,.44)}.jodit_error_box_for_messages>.success{background:rgba(77,236,112,.29);color:#5d5a5a;border:1px solid hsla(0,0%,58%,.44)}.jodit_fullsize_box{z-index:12!important;position:static!important;overflow:visible!important}body.jodit_fullsize_box,html.jodit_fullsize_box{height:0!important;width:0!important;overflow:initial!important}html.jodit_fullsize_box{position:fixed!important}.jodit_fullsize{position:absolute;top:0;left:0;right:0;bottom:0;z-index:12;max-width:none!important}.jodit_fullsize .toolbar{width:100%!important}.jodit_fullsize .jodit_area,.jodit_fullsize .jodit_editor{height:100%}.jodit_fullsize .jodit_workflow{height:calc(100% - 24px);overflow:auto}.jodit_fullsize.jodit_toolbar_size-small .jodit_workflow{height:calc(100% - 18px)}.jodit_fullsize.jodit_toolbar_size-large .jodit_workflow{height:calc(100% - 27px)}.jodit_placeholder{-webkit-user-select:none!important;-moz-user-select:none!important;-ms-user-select:none!important;user-select:none!important;top:0;left:0;display:block;position:absolute;padding:10px;color:rgba(0,0,0,.35);z-index:1;pointer-events:none}.jodit_toolbar_popup-inline-target{position:absolute;width:0;height:0}.jodit_toolbar_popup-inline{display:inline-block!important;position:relative!important}.jodit_toolbar_popup-inline>div{color:hsla(0,0%,88%,.99);background:#fff;box-shadow:none;background-clip:padding-box;font-family:Helvetica,sans-serif;box-sizing:border-box;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;z-index:13!important;text-align:left;border:1px solid hsla(0,0%,88%,.99);display:inline-block;vertical-align:top}.jodit_toolbar_popup-inline .jodit_toolbar{z-index:7;border:0;white-space:normal}.jodit_toolbar_popup-inline>div>.jodit_toolbar{white-space:nowrap;box-shadow:none;vertical-align:top}.jodit_toolbar_popup-inline>.jodit_popup_triangle{padding:0;margin:0;width:8px;height:8px;position:absolute;top:-4px;margin-left:-4px;display:inline-block;transform:rotate(45deg);background:#fff;border:1px solid hsla(0,0%,88%,.99);border-width:1px 0 0 1px;z-index:6}.jodit_toolbar_popup-inline.jodit_toolbar_popup-inline-top>.jodit_popup_triangle{top:auto;bottom:-4px;border-width:0 1px 1px 0}.jodit_toolbar_popup-inline .buttons{box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);padding:0 2px;white-space:nowrap;line-height:0;border-bottom:0}[data-jodit_iframe_wrapper]{display:block;clear:both;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;position:relative}[data-jodit_iframe_wrapper]:after{position:absolute;content:"";z-index:1;top:0;left:0;right:0;bottom:0;cursor:pointer;display:block;background:transparent}.jodit_resizer{width:100px;height:100px;position:absolute;border:1px solid rgba(3,14,82,.92);top:0;left:0;display:none;pointer-events:none;font-size:0}.jodit_resizer *{box-sizing:border-box}.jodit_resizer>span{opacity:0;transition:opacity .2s linear;left:50%;top:50%;height:24px;line-height:24px;font-size:12px;width:70px;margin-left:-35px;margin-top:-12px;text-align:center;overflow:visible;color:#fff;background-color:rgba(0,0,0,.35);max-width:100%}.jodit_resizer>i,.jodit_resizer>span{position:absolute;display:inline-block}.jodit_resizer>i{z-index:4;pointer-events:all;border:1px solid rgba(3,14,82,.92);background-color:hsla(0,0%,88%,.99);width:10px;height:10px}.jodit_resizer>i:hover{background-color:#f8f8f8}.jodit_resizer>i:first-child{left:-5px;top:-5px;cursor:nw-resize}.jodit_resizer>i:nth-child(2){right:-5px;top:-5px;cursor:ne-resize}.jodit_resizer>i:nth-child(3){right:-5px;bottom:-5px;cursor:se-resize}.jodit_resizer>i:nth-child(4){left:-5px;bottom:-5px;cursor:sw-resize}@media (max-width:768px){.jodit_resizer>i{width:20px;height:20px}.jodit_resizer>i:first-child{left:-10px;top:-10px;cursor:nw-resize}.jodit_resizer>i:nth-child(2){right:-10px;top:-10px;cursor:ne-resize}.jodit_resizer>i:nth-child(3){right:-10px;bottom:-10px;cursor:se-resize}.jodit_resizer>i:nth-child(4){left:-10px;bottom:-10px;cursor:sw-resize}}.jodit_container{min-height:100px}.jodit_container .jodit_workplace{display:-ms-flexbox;display:flex;height:auto;min-height:50px;overflow:hidden}.jodit_editor_resize{position:relative}.jodit_editor_resize a{position:absolute;bottom:0;right:0;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;width:0;height:0;overflow:hidden;border-width:7px 7px 0 0;border-color:transparent #ccc transparent transparent;border-style:dashed solid dashed dashed;cursor:se-resize}.jodit_source{display:none;position:relative;background-color:#f8f8f8;font-size:0;-ms-flex:1;flex:1;overflow:auto}.jodit_source,.jodit_source .jodit_source_mirror-fake{min-height:100%}.jodit_container.jodit_source_mode .jodit_wysiwyg,.jodit_container.jodit_source_mode .jodit_wysiwyg_iframe{display:none!important}.jodit_container.jodit_source_mode .jodit_source{display:block!important}.jodit_container.jodit_split_mode .jodit_source,.jodit_container.jodit_split_mode .jodit_wysiwyg,.jodit_container.jodit_split_mode .jodit_wysiwyg_iframe{display:block!important;width:50%;-ms-flex:1;flex:1}.jodit_source_mirror{border:0;width:100%;background:#3f3f3f;margin:0;height:100%;box-shadow:none;resize:none;box-sizing:border-box;color:#f0f0f0;outline:0;font-family:Menlo,Monaco,monospace,sans-serif;font-size:13px;line-height:1.3em;z-index:2;padding:10px;overflow:auto;white-space:pre-wrap;-moz-tab-size:2em;-o-tab-size:2em;tab-size:2em;min-height:100%}.jodit_source_mirror::-moz-selection{background:#bdbdbd}.jodit_source_mirror::selection{background:#bdbdbd}.jodit_table_resizer{cursor:col-resize;position:absolute;z-index:3;padding-left:5px;padding-right:5px;margin-left:-5px}.jodit_table_resizer:after{content:"";display:block;height:100%;width:0;border:1px solid transparent;border-width:0 1px 0 0}.jodit_table_resizer-moved{z-index:2}.jodit_table_resizer-moved:after{border-color:#1e88e5}.jodit_wysiwyg table{width:100%;border:none;border-collapse:collapse;empty-cells:show;max-width:100%;margin-top:20px}.jodit_wysiwyg table tr{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jodit_wysiwyg table tr td,.jodit_wysiwyg table tr th{border:1px solid #ddd;padding:2px 5px;text-align:left;vertical-align:middle;-webkit-user-select:text;-moz-user-select:text;-ms-user-select:text;user-select:text}.jodit_wysiwyg table tr td[data-jodit-selected-cell],.jodit_wysiwyg table tr th[data-jodit-selected-cell]{border:1px double #1e88e5}.jodit_form_inserter .jodit_form-table-creator-box{font-size:0}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-container{display:inline-block;vertical-align:top;padding:0;margin:0;min-width:180px;font-size:0}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-container>div{width:18px;height:18px;box-sizing:border-box;display:inline-block;position:relative;vertical-align:top}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-container>div:after{content:"";position:absolute;top:0;left:0;display:inline-block;width:12px;height:12px;border:1px solid #ccc}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-container>div.hovered:after{background:#7a450f;border:1px solid #b5b5b5}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-options{font-size:14px;display:inline-block;vertical-align:top}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-options label{text-align:left;padding-top:0}.jodit_form_inserter .jodit_form-table-creator-box .jodit_form-options label input{margin-right:10px}.jodit_form_inserter label{text-align:center;font-size:14px;padding:8px;display:block;margin:0}.jodit_text_icons .jodit_icon{width:auto;font-size:14px}.jodit_text_icons .jodit_icon:first-letter{text-transform:uppercase}.jodit_text_icons .jodit_tabs .jodit_tabs_buttons>a{font-family:Helvetica,sans-serif;width:auto}.jodit_text_icons .jodit_tabs .jodit_tabs_buttons>a i,.jodit_text_icons .jodit_toolbar>li{width:auto}.jodit_text_icons .jodit_toolbar>li>a{text-decoration:none}.jodit_text_icons.jodit_dialog_box .jodit_dialog .jodit_button,.jodit_text_icons.jodit_dialog_box .jodit_dialog .jodit_dialog_header a,.jodit_text_icons .jodit_toolbar>li>a{padding:0 12px;font-family:Helvetica,sans-serif;width:auto;color:rgba(0,0,0,.75)}.jodit_text_icons.jodit_dialog_box .jodit_dialog .jodit_button .jodit_icon,.jodit_text_icons.jodit_dialog_box .jodit_dialog .jodit_dialog_header a .jodit_icon{width:auto}.jodit_widget,.jodit_widget *{box-sizing:border-box}.jodit_search{visibility:hidden;position:absolute;top:0;right:0;width:0;height:0}.jodit_search.jodit_search-active{visibility:visible}.jodit_search .jodit_search_box{width:320px;position:absolute;right:0;background-color:#f9f9f9;border:1px solid #ccc;border-width:0 0 1px 1px;padding:5px}.jodit_search .jodit_search_box input{margin:0;width:100%;height:100%;border:0;background-color:transparent;outline:0;padding:0 10px}.jodit_search .jodit_search_box input.jodit_search-replace{display:none}.jodit_search .jodit_search_box .jodit_search_buttons,.jodit_search .jodit_search_box .jodit_search_counts,.jodit_search .jodit_search_box .jodit_search_inputs{height:30px;display:inline-block;vertical-align:top}.jodit_search .jodit_search_box .jodit_search_inputs{width:60%;padding-right:5px}.jodit_search .jodit_search_box .jodit_search_counts{width:15%;line-height:100%;text-align:center;color:#ccc;border-left:1px solid #ccc}.jodit_search .jodit_search_box .jodit_search_counts:before{content:"";display:inline-block;vertical-align:middle;height:100%}.jodit_search .jodit_search_box .jodit_search_counts span{display:inline-block;vertical-align:middle}.jodit_search .jodit_search_box .jodit_search_buttons{padding-left:0;width:25%}.jodit_search .jodit_search_box .jodit_search_buttons button{outline:0;width:32%;padding:1px 5px;margin-right:1%;transition:transform .1s linear;height:100%;border:1px solid transparent;background-color:transparent}.jodit_search .jodit_search_box .jodit_search_buttons button.jodit_search_buttons-replace{width:100%;border:1px solid #ccc;margin-top:2px;display:none}.jodit_search .jodit_search_box .jodit_search_buttons button:hover{background-color:#ecebe9}.jodit_search .jodit_search_box .jodit_search_buttons button:focus{border:1px solid rgba(181,214,253,.5)}.jodit_search .jodit_search_box .jodit_search_buttons button:active{border:1px solid #b5d6fd;transform:scale(.95)}.jodit_search.jodit_search-and-replace .jodit_search_counts,.jodit_search.jodit_search-and-replace .jodit_search_inputs{height:60px}.jodit_search.jodit_search-and-replace .jodit_search_counts input,.jodit_search.jodit_search-and-replace .jodit_search_inputs input{height:50%;transition:background-color .1s linear}.jodit_search.jodit_search-and-replace .jodit_search_counts input:focus,.jodit_search.jodit_search-and-replace .jodit_search_inputs input:focus{box-shadow:inset 0 0 3px 0 hsla(0,0%,80%,.58)}.jodit_search.jodit_search-and-replace .jodit_search_buttons button.jodit_search_buttons-replace,.jodit_search.jodit_search-and-replace .jodit_search_inputs input.jodit_search-replace{display:block}@media (max-width:320px){.jodit_search,.jodit_search .jodit_search_box{width:100%}}.jodit_symbols{width:460px;padding:10px}.jodit_symbols .jodit_symbols-container_preview,.jodit_symbols .jodit_symbols-container_table{display:inline-block;vertical-align:top}.jodit_symbols .jodit_symbols-container_table{width:88%}.jodit_symbols .jodit_symbols-container_preview{width:12%}.jodit_symbols .jodit_symbols-container_preview .jodit_symbols-preview{font-size:34px;text-align:center;padding:20px 0;border:1px solid #ccc}.jodit_symbols table{border:0;border-spacing:0;table-layout:fixed}.jodit_symbols table td{padding:0}.jodit_symbols table td a{font-size:16px;text-decoration:none;color:#000;display:inline-block;box-sizing:border-box;width:21.6px;height:21.6px;border:1px solid transparent;text-align:center;line-height:21.6px;vertical-align:top}.jodit_symbols table td a:focus,.jodit_symbols table td a:hover{border:1px solid #1e88e5}.jodit_sticky-dummy_toolbar{display:none}.jodit_sticky>.jodit_toolbar{position:fixed;z-index:3;top:0;left:auto}.jodit_sticky .jodit_sticky-dummy_toolbar{display:block}.jodit_paste_storage{padding:10px;max-width:600px}@media (max-width:768px){.jodit_paste_storage{max-width:100%}}.jodit_paste_storage>div{max-width:100%;max-height:300px;border:1px solid #ccc}.jodit_paste_storage>div:first-child{margin-bottom:10px}.jodit_paste_storage>div:first-child a{outline:0;box-sizing:border-box;display:block;max-width:100%;white-space:pre;overflow:hidden;text-overflow:ellipsis;padding:5px;margin:0;border:1px solid transparent;text-decoration:none;color:#000}.jodit_paste_storage>div:first-child a.jodit_active{color:#fff;background-color:#575757}.jodit_paste_storage>div:first-child a:focus{outline:0}.jodit_paste_storage>div:last-child{padding:10px;overflow:auto}.jodit_paste_storage>div:last-child li,.jodit_paste_storage>div:last-child ul{margin:0}





/*
 * Pikaday
 */

.pika-single {
    z-index: 9999;
    display: block;
    position: relative;
    color: #333;
    background: #fff;
    border: 1px solid #ccc;
    border-bottom-color: #bbb;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

/*
clear child float (pika-lendar), using the famous micro clearfix hack
http://nicolasgallagher.com/micro-clearfix-hack/
*/
.pika-single:before,
.pika-single:after {
    content: " ";
    display: table;
}
.pika-single:after { clear: both }
.pika-single { *zoom: 1 }

.pika-single.is-hidden {
    display: none;
}

.pika-single.is-bound {
    position: absolute;
    box-shadow: 0 5px 15px -5px rgba(0,0,0,.5);
}

.pika-lendar {
    float: left;
    width: 240px;
    margin: 8px;
}

.pika-title {
    position: relative;
    text-align: center;
}

.pika-label {
    display: inline-block;
    *display: inline;
    position: relative;
    z-index: 9999;
    overflow: hidden;
    margin: 0;
    padding: 5px 3px;
    font-size: 14px;
    line-height: 20px;
    font-weight: bold;
    background-color: #fff;
}
.pika-title select {
    cursor: pointer;
    position: absolute;
    z-index: 9998;
    margin: 0;
    left: 0;
    top: 5px;
    filter: alpha(opacity=0);
    opacity: 0;
}

.pika-prev,
.pika-next {
    display: block;
    cursor: pointer;
    position: relative;
    outline: none;
    border: 0;
    padding: 0;
    width: 20px;
    height: 30px;
    /* hide text using text-indent trick, using width value (it's enough) */
    text-indent: 20px;
    white-space: nowrap;
    overflow: hidden;
    background-color: transparent;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: 75% 75%;
    opacity: .5;
    *position: absolute;
    *top: 0;
}

.pika-prev:hover,
.pika-next:hover {
    opacity: 1;
}

.pika-prev,
.is-rtl .pika-next {
    float: left;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAeCAYAAAAsEj5rAAAAUklEQVR42u3VMQoAIBADQf8Pgj+OD9hG2CtONJB2ymQkKe0HbwAP0xucDiQWARITIDEBEnMgMQ8S8+AqBIl6kKgHiXqQqAeJepBo/z38J/U0uAHlaBkBl9I4GwAAAABJRU5ErkJggg==');
    *left: 0;
}

.pika-next,
.is-rtl .pika-prev {
    float: right;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAeCAYAAAAsEj5rAAAAU0lEQVR42u3VOwoAMAgE0dwfAnNjU26bYkBCFGwfiL9VVWoO+BJ4Gf3gtsEKKoFBNTCoCAYVwaAiGNQGMUHMkjGbgjk2mIONuXo0nC8XnCf1JXgArVIZAQh5TKYAAAAASUVORK5CYII=');
    *right: 0;
}

.pika-prev.is-disabled,
.pika-next.is-disabled {
    cursor: default;
    opacity: .2;
}

.pika-select {
    display: inline-block;
    *display: inline;
}

.pika-table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    border: 0;
}

.pika-table th,
.pika-table td {
    width: 14.285714285714286%;
    padding: 0;
}

.pika-table th {
    color: #999;
    font-size: 12px;
    line-height: 25px;
    font-weight: bold;
    text-align: center;
}

.pika-button {
    cursor: pointer;
    display: block;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    border: 0;
    margin: 0;
    width: 100%;
    padding: 5px;
    color: #666;
    font-size: 12px;
    line-height: 15px;
    text-align: center;
    background: #f5f5f5;
}

.pika-week {
    font-size: 11px;
    color: #999;
}

.is-today .pika-button {
    color: #33aaff;
    font-weight: bold;
}

.is-selected .pika-button,
.has-event .pika-button {
    color: #fff;
    font-weight: bold;
    background: #33aaff;
    box-shadow: inset 0 1px 3px #178fe5;
    border-radius: 3px;
}

.has-event .pika-button {
    background: #005da9;
    box-shadow: inset 0 1px 3px #0076c9;
}

.is-disabled .pika-button,
.is-inrange .pika-button {
    background: #D5E9F7;
}

.is-startrange .pika-button {
    color: #fff;
    background: #6CB31D;
    box-shadow: none;
    border-radius: 3px;
}

.is-endrange .pika-button {
    color: #fff;
    background: #33aaff;
    box-shadow: none;
    border-radius: 3px;
}

.is-disabled .pika-button {
    pointer-events: none;
    cursor: default;
    color: #999;
    opacity: .3;
}

.is-outside-current-month .pika-button {
    color: #999;
    opacity: .3;
}

.is-selection-disabled {
    pointer-events: none;
    cursor: default;
}

.pika-button:hover,
.pika-row.pick-whole-week:hover .pika-button {
    color: #fff;
    background: #ff8000;
    box-shadow: none;
    border-radius: 3px;
}

/* styling for abbr */
.pika-table abbr {
    border-bottom: none;
    cursor: help;
}










*::selection {
    background: #d75656;
    color: #ffffff;
}
*::-webkit-selection {
    background: #d75656;
    color: #fff;
}
*::-moz-selection {
    background: #d75656;
    color: #ffffff;
}
*, *::before, *::after {
  -webkit-box-sizing: border-box; 
  -moz-box-sizing: border-box; 
    box-sizing: border-box;
}
a{
  text-decoration: none;
  color: #34a6f1;
}
a:hover{
  color: #2f97dc;
}

.super_hidden{
  display: none;position: absolute;left: -9999px;width: 1px;height: 1px;
}
.wrapper {
  padding: 70px 15px 0 15px;
  width: 100%;
  min-width: 280px;
}
#content{padding-left: 200px;    -webkit-transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    transition: all 0.2s ease-in;}
.sb-mini #content{padding-left: 90px}

h1, h2, h3, h4, h5, h6 {
    color: #222;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-style: normal;
    font-weight: 400;
    line-height: 1.4;
    text-rendering: optimizelegibility;
}
li{
  list-style: outside none none;
}
select {
    height: 30px;
    padding: 0 10px;
    outline: none;
    border-radius: 3px;
    border: none;
}


/*

*/
#header{
  position: fixed;
  top: 0;left: 0;width: 100%;
  height: 70px;background: #fff;border-bottom: 1px solid #ddd;
  padding: 0 15px;
  z-index: 4;
}
#logo{float: left;margin-top: 15px;}
#logo img{width: 218px;}
#hm{
  min-height: 42px;
  float: left;margin-top: 19px; margin-left: 15px;
}
#menu{
  float: left;width: 32px;height: 32px;background: url('/static/images/ui/menu-button.png');
  background-size: 32px 32px;cursor: pointer;
  display: none;
}
#user-menu{
  float: right;
  height: 100%;
  position: relative;
}
#user-menu-list{opacity: 0;display: none;width: 200px;background: #fff;position: absolute;top: 130%;right: 0;
  -webkit-box-shadow: 0 0 2px 2px #ddd;
  -moz-box-shadow: 0 0 2px 2px #ddd;
  box-shadow: 0 0 2px 2px #ddd;
  border-radius: 5px;
  padding: 10px 0;
  z-index: 10;
}
.hm{
width: 200px;background: #fff;position: absolute;top: 100%;
  -webkit-box-shadow: 3px 2px 2px 2px #dce5ed;
  -moz-box-shadow: 3px 2px 2px 2px #dce5ed;
  box-shadow: 3px 2px 2px 2px #dce5ed;
  padding: 0;
  z-index: 10;

  left: -220px;
  width: 220px;

}
#sidebar {
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    width: 200px;
    height: 100%;
    -webkit-transition: width 0.2s ease-in;
    -moz-transition: width 0.2s ease-in;
    transition: width 0.2s ease-in;
}
#sidebar .hm{position: absolute;top: 0;left: 0;height: 100%;padding-top: 70px;width: 100%;}


.sb-mini #sidebar{width: 90px;}
.sb-mini #sidebar li a{font-size: 15px;}

#header-menu{opacity: 0;display: none;}
#sidebar-tg {
    position: absolute;
    top: 50%;
    right: -7px;
    width: 40px;
    height: 40px;
    cursor: pointer;
    background-image: url('/static/images/ui/sb_arrow.png');
    background-repeat: no-repeat;
    z-index: 10;
    background-size: 16px;
    opacity: 0.5;
    background-position: center;
    -webkit-transition: all 0.3s ease-in;
    -moz-transition: all 0.3s ease-in;
    transition: all 0.3s ease-in;
}
#sidebar-tg:hover{opacity: 0.8;width: 55px;}
.sb-mini #sidebar-tg{-webkit-transform: rotateY(180deg);-moz-transform: rotateY(180deg);transform: rotateY(180deg);}
.sb-mini #sidebar-tg:hover{background-position: 5px center;}
#user-menu img{display: inline-block;vertical-align: middle;width: 38px;height: 38px;}

#user-menu .inline-name{
  float: left;
  height: 100%;
  line-height: 70px;
  position: relative;
  padding: 0 30px 0 15px;
  cursor: pointer;
}
#user-menu .inline-name span{
  display: inline-block;
  vertical-align: top;
  margin-top: 2px;
  margin-left: 9px;
  color: #333;
  font-weight: normal;
  font-size: 14px;
}
#user-menu .inline-name:after{
  top: 50%;
  right: 5px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(174, 183, 190, 0);
  border-top-color: #aeb7be;
  border-width: 6px;
  margin-left: -6px;
}
#user-menu-list li{
  margin: 0;
}
.hm li{margin: 0;}
#user-menu-list li:last-child, .hm li:last-child{
  border-bottom: 0
}
#user-menu-list li a{
  display: block;
  line-height: 38px;
  padding: 0 20px;
  font-size: 14px;
  cursor: pointer;
}
.hm li a{
  position: relative;
  font-size: 16px;
  padding: 50px 0 12px 0;
  color: #4e6d82;
  display: block;
  text-align: center;
  background-image: url('/static/images/ui/menu_users_gray.png');
  background-repeat: no-repeat;
  background-size: 26px;
  background-position: center 12px;
}
.hm li a i{
    position: absolute;
    top: 8px;
    right: 8px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    color: #fff;
    z-index: 2;
    line-height: 18px;
    background: #d85353;
        font-size: 13px;
        text-align: center;
}
.hm li a:hover{background-color: #94a5ad;color: #fff;background-image: url('/static/images/ui/menu_users_white.png');}
.hm li a.reports-icon{background-image: url('/static/images/ui/menu_reports_gray.png');}
.hm li a.reports-icon:hover{background-image: url('/static/images/ui/menu_reports_white.png') !important;}
.hm li a.docs-icon{background-image: url('/static/images/ui/menu_docs_gray.png');}
.hm li a.docs-icon:hover{background-image: url('/static/images/ui/menu_docs_white.png') !important;}
.hm li a.options-icon{background-image: url('/static/images/ui/menu_options_gray.png');}
.hm li a.options-icon:hover{background-image: url('/static/images/ui/menu_options_white.png') !important;}
.hm li a.cert-icon{background-image: url('/static/images/ui/menu_cert_gray.png');background-size: 32px;background-position: center 10px;}
.hm li a.cert-icon:hover{background-image: url('/static/images/ui/menu_cert_white.png') !important;}
.hm li a.orders-icon{background-image: url('/static/images/ui/menu_orders_gray.png');background-size: 35px;}
.hm li a.orders-icon:hover{background-image: url('/static/images/ui/menu_orders_white.png') !important;}
.hm li a.credit-icon{background-image: url('/static/images/ui/menu_credits_gray.png');background-size: 32px;background-position: center 10px;}
.hm li a.credit-icon:hover{background-image: url('/static/images/ui/menu_credits_white.png') !important;}

#user-menu-list li a{
  background-size: 16px;
  background-repeat: no-repeat;
  background-position: 20px 11px;
  color: #333;
  padding-left: 48px;
}
#user-menu-list li.profile-link a{background-image: url('/static/images/ui/user-menu-profile.png');}
#user-menu-list li.logout-link a{background-image: url('/static/images/ui/user-menu-logout.png');}
#user-menu-list li.buy-credits-link{display: none;}
#user-menu-list li.buy-credits-link a{background-image: url('/static/images/ui/user-menu-buy-credits.png');}

#user-menu-list li a:hover{
  background-color: #f8f8f8;
}
.btn,.btnsave,.graybtn, #clear-params{
  display: inline-block;
  cursor: pointer;
  border-radius: 3px;
  line-height: 38px;
  height: 38px;
  padding: 0 15px;
  color: #fff;
  font-weight: bold;
  font-size: 15px;
}
.btnsave{padding: 0 34px;border-radius: 19px}
.graybtn{background: #6d7b84}
.graybtn:hover, #clear-params:hover{
  background: #2f97dc;
  color: #fff;
}
#clear-params{
  line-height: 30px;
  height: 30px;
  font-weight: normal;
  margin-right: 20px;
  font-size: 14px;
  background: #f6f8fa;
  color: #000;
}
.btn-wrap .btnsave{margin-right: 15px;}
.btn-inline-wrap{display: inline-block;margin-left: 15px;}
.btn-inline-wrap .btnsave{height: 30px;line-height: 30px;padding: 0 20px;}
.btn-inline-wrap .btnsave:last-child{margin-right: 0}
.btn-loader{display: inline-block;min-width: 40px;text-align: center;}
.btn-loader img{
    display: inline-block;
    width: 19px;
    height: 19px;
    vertical-align: middle;
}
.actions-td a .btn-loader img{height: 11px;width: 11px;}

.content-wrapper{padding: 30px 20px 80px 20px;}
.content-inner-wrapper{padding: 0 20px 0 0;}
.content-top-nav{margin-bottom: 30px;}

.table-size{float: left;}
.table-search{float: left;margin-left: 50px;}
.table-right-side{float: right;}
.table-entries{float: left;}
.table-pagination{float: right;}

#table-size{margin: 0 5px;}
#table-search{height: 30px;padding: 0 10px;color: #333;border: 1px solid #eee;outline: 0;margin-left: 7px;border-radius: 3px;}

.tb-rb{height: 36px;line-height: 36px;margin-top: -6px}

.table-pre-params {
    display: inline-block;
    width: 100%;
    margin-bottom: 15px;
}
#table-after-params {
    display: inline-block;
    width: 100%;
    margin-top: 20px;
}
#table-content{position: relative;}
#table-content .loader{position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(255,255,255,.7);z-index: 10;padding: 9px 0 0 10px;}

.pagi{border-radius: 3px;display: inline-block;}
.pagi a, .pagi div{float: left;height: 38px;line-height: 38px;padding: 0 15px;color: #828a91;background: #fff;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;}
.pagi a:hover{color: #111;background-color: #f6f8fa;}
.pagi a:last-child, .pagi div:last-child{border-right: 1px solid #ddd;border-top-right-radius: 3px;border-bottom-right-radius: 3px;}
.pagi a:first-child, .pagi div:first-child{border-left: 1px solid #ddd;border-top-left-radius: 3px;border-bottom-left-radius: 3px;}
.pagi .active:first-child{border-left: 0;}
.pagi .active:last-child{border-right: 0;}
.pagi .active{background: #37adfb;color: #fff;font-weight: bold;position: relative;border-top-color: #37adfb;border-bottom-color: #37adfb;}
.error, .success{
  background-color: #ff5252;
  background-image: url('/static/images/ui/error_icon.png');
  background-position: 15px center;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background-size: 24px 24px;
  background-repeat: no-repeat;
  color: #fff;
  margin-bottom: 25px;
  width: 40%;
  padding: 15px 20px 15px 54px;
  font-size: 14px;
  text-align: left;
}
.success{
  background-color: #4caf50 !important;
  background-image: url('/static/images/ui/res_success.png') !important;
}
/*table styles*/
.table-no-results {
    width: 100%;border: 1px solid #d9e2e7;border-top: 0;
    background: #fff;
    padding: 15px;
}
.default-table{background: #fff;width: 100%;border-collapse: collapse;}
.default-table thead{background-color: #f6f8fa}
.default-table th, .default-table td{text-align: left;border: 1px solid #d9e2e7;line-height: 13px;max-width: 160px;}
.default-table td{padding: 15px;}
.default-table th{padding: 15px;font-weight: bold;}
.th-search{margin-top: 4px;}
.th-search input{border: 1px solid #ddd;height: 28px;padding-left: 7px;border-radius: 3px;background: #fff;min-width: 70%;max-width: 100%;}
.actions-td{padding: 12px 0 12px 15px !important;min-width: 253px;max-width: 260px !important;}
.actions-td a{margin-top: 3px;display: inline-block;background-color: #6d7b84;color: #fff;padding: 5px 10px;border-radius: 3px;margin-right: 7px;cursor: pointer;font-weight: bold;}
.actions-td a.blue, .blue{background-color: #37adfb;}
.actions-td a:hover{background-color: #2f97dc;}
.blue:hover{background-color: #2f97dc;color: #fff;}
.red{background-color: #d9534f;color: #fff;}
.red:hover{background-color: #b52b27}
.gray{background-color: #eee;color: #444;}
.gray:hover{background-color: #999;color: #fff;}
.green{background-color: #47ca47;color: #fff}
.green:hover{background-color: #3aa23a;color: #fff;}
.graygg{
  position: relative;
  background: #ebeff2;
  color: #666;
  padding-right: 40px
}
.graygg:hover{
  background: #dce4e2;
color: #000;
}
.graygg:after {
  top: 50%;
  right: 18px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(50, 50, 50, 0);
  border-top-color: #999;
  border-width: 6px;
  margin-left: -6px;
  margin-top: -2px;
}
.graygg.notselectable{padding-right: 15px;}
.graygg.notselectable:after{display: none;}
.btn-add-resource, .btn-edit-resource{display: inline-block;margin-left: 15px;position: relative;}


th.sortable{position: relative;cursor: pointer;min-width: 180px;}
th.sortable:before {
  top: 50%;
  right: 15px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(190, 190, 191, 0);
  border-bottom-color: #bebebf;
  border-width: 6px;
  margin-left: -6px;
  margin-top: -12px;
}
th.sortable-search:before{
  margin-top: -8px;
}
th.sortable:after {
  top: 50%;
  right: 15px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(190, 190, 191, 0);
  border-top-color: #bebebf;
  border-width: 6px;
  margin-left: -6px;
  margin-top: 5px;
}
th.sortable-search:after{
  margin-top: 10px;
}
th.sortable.sorted-asc:before{
  border-color: rgba(55, 173, 251, 0);
  border-bottom-color: #37adfb;
}
th.sortable.sorted-desc:after{
  border-color: rgba(55, 173, 251, 0);
  border-top-color: #37adfb;
}

#overlay{display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(255,255,255,.8);z-index: 60;}
#edit-modal, #exam-res-modal, .super-modal{
  display: none;
  border: 1px solid #d9e2e7;
  top: 50%;
  left: 50%;
  position: fixed;
  z-index: 61;
  width: 360px;
  min-height: 260px;
  margin-left: -180px;
  background: #eceff4;
  -webkit-transform: translateY(-55%);
  -moz-transform: translateY(-55%);
  transform: translateY(-55%);
  padding: 30px 30px 35px 30px;
  border-radius: 5px;
}
#edit-modal h3, #exam-res-modal h3, .super-modal h3{font-size: 18px;font-weight: bold;color: #333;}
#edit-modal .bi , #exam-res-modal .bi, .super-modal .bi{margin: 20px 0 30px 0;}
#edit-modal h3+.bi, , #exam-res-modal h3+.bi, .super-modal h3+.bi{margin-top: 40px;}
#edit-modal .error, #edit-modal .success, .super-modal .success, .super-modal .error{
  width: 100%;
}

#jodit-preview-content{
  width: 650px;
  margin-left: -325px;
  background: #f9f9f9;
}




.close-modal{
  position: absolute;
top: -70px;
right: -70px;
width: 70px;
height: 70px;
  background: url('/static/images/cross-out.png');
  background-size: 26px 26px;
  background-position: center center;
  background-repeat: no-repeat;
  z-index: 3;
  cursor: pointer;
}

body.fix{overflow-y: hidden;position: relative;}

.bi{position: relative;}
.bi .input-label{position: absolute;top: 12px;left: 12px;color: #666;-webkit-transition: all 0.5s ease;-moz-transition: all 0.5s ease;transition: all 0.5s ease;}
.bi input{color: #222;width: 100%;height: 36px;padding-bottom: 2px;padding-left: 12px;border: 1px solid #ccc;outline: none;border-radius: 3px;}
.bi.active .input-label{top: -16px;font-size: 11px;}
.ii-increase{
  position: absolute;
  top: 0px;
  right: 0px;
  z-index: 3;
  width: 40px;
  height: 18px;
  cursor: pointer;
}
.ii-decrease{
  position: absolute;
  top: 18px;
  right: 0px;
  z-index: 3;
  width: 40px;
  height: 18px;
  cursor: pointer;
}
.ii-increase:before {
  bottom: 2px;
  right: 35%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(190, 190, 191, 0);
  border-bottom-color: #bebebf;
  border-width: 6px;
  margin-left: -6px;
}
.ii-decrease:before, .bi-fulldd-wrap:after, .th-select:after {
  top: 3px;
  right: 35%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(190, 190, 191, 0);
  border-top-color: #bebebf;
  border-width: 6px;
  margin-left: -6px;
}
.bi-fulldd-wrap:after{top: 15px;right: 15px;}
.th-select:after{top: 12px;right: 7px;}
.data-row+.btn-wrap{margin-top: 15px;}
.content-inner-fragment {
    background: #ffffff;
    padding: 35px 45px;
}
.bi-inc .ii-increase{
  left: auto !important;right: 0;
  width: 38px;
  height: 100%;
  background: #eee;
}
.bi-inc .ii-decrease{
  left: 0;right: auto !important;
  top: 0 !important;
  width: 38px;
  height: 100%;
  background: #eee;
}
.bi-inc .ii-decrease:hover, .bi-inc .ii-increase:hover{background: #e8e8e8}
.bi-inc input{padding-left: 50px;}
.bi-inc .ii-decrease:before{
  content: "-";
  color: #667277;
  top: 0;
  line-height: 33px;
  font-size: 28px;
  right: 0;
  width: 100%;
  text-align: center;
  border: 0;
  background: none;
}
.bi-inc .ii-increase:before{
  color: #667277;
  content: "+";
  top: 0;
  line-height: 35px;
  font-size: 21px;
  right: 0;
  width: 100%;
  text-align: center;
  border: 0;
  background: none;
}

.sortable.sortable-search{padding-right: 32px;}
.content-inner-fragment+.content-inner-fragment{margin-top: 35px;}

.btn-sub-wrap{margin-top: 35px;}
.btn-sub-wrap .btn{margin-right: 15px}
.course-module-add-fragment{display: none;margin-top: 35px;}

.jodit_wysiwyg em{font-style: italic;}




input[type="file"] {
    cursor: pointer;
    background: #ebeff2;
    width: 100%;
    height: 36px;
    padding-top: 7px;
    padding-left: 12px;
    border-radius: 3px;
}
input[type="file"]:hover{
  background: #ccc;
}
h1, h2 {
    font-size: 22px;
}
.data-row {
    display: inline-block;
    width: 100%;
    margin-bottom: 25px;
}
.data-row .label {
  display: inline-block;
  width: 175px;
  font-weight: bold;
  vertical-align: top;
  margin-top: 12px;
}
.data-row .value {
    display: inline-block;
    width: auto;
    min-width: 350px;
}
.data-row .value.text{min-width: 500px;min-height: 180px;max-width: 750px;margin-bottom: 10px;}
.jode{display: none;}

.new-tr{
  background-color: #ffe9b0;
}
.content-description{margin-top: 15px;font-size: 14px;line-height: 15px;}
.content-description p{margin-bottom: 6px;}
.content-description table{border-top: 1px solid #ddd;border-bottom: 1px solid #ddd}
.content-description tbody td{border-right: 1px solid #ddd;padding: 10px 15px;}
.content-description tbody tr{border-bottom: 1px solid #ddd;}
.content-description tbody tr:last-child{border-bottom: 0;}



.ns {
  -webkit-touch-callout: none; 
    -webkit-user-select: none;
     -khtml-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
}



.th-select{position: relative;}
.th-select input{cursor: pointer;}

.bi-fulldd-wrap input{cursor: pointer;}
.bi-fulldd, .th-select-ul {
  opacity: 0;
  display: none;
  z-index: 10;
  width: 100%;
  background: #fff;
  -webkit-box-shadow: 0 0 2px 2px #ddd;
  -moz-box-shadow: 0 0 2px 2px #ddd;
  box-shadow: 0 0 2px 2px #ddd;
  border-radius: 5px;
  position: absolute;
  top: 130%;
  left: 0;
  padding: 0;
  margin: 0;
}
.bi-fulldd li, .th-select-ul li{
  cursor: pointer;
  margin: 0;
  padding: 0 15px;
  line-height: 28px;
  height: 28px;
}
.th-select li{font-weight: normal;}
.bi-fulldd li:first-child, .th-select-ul li:first-child{margin-top: 6px;}
.bi-fulldd li:last-child, .th-select-ul li:last-child{margin-bottom: 6px;}
.bi-fulldd li:hover, .th-select-ul li:hover{
  background: #eee;
}


.data-row-sep{padding-bottom: 35px;border-bottom: 1px solid #eee;margin-bottom: 45px;}
.center-page #content{padding: 0 20%;}

.data-bi-switcher .label{margin-top: 10px;}
.data-bi-switcher .input-label{display: none;}
.data-bi-switcher .bi-switcher input{display: none;}
.bi-switcher{
  background: #ccc;
  cursor: pointer;
  width: 56px;
  position: relative;
  border-radius: 14px;
  height: 28px;
  -webkit-transition: all 0.3s ease-in;
  -moz-transition: all 0.3s ease-in;
  transition: all 0.3s ease-in;
}
.bi-switcher .sw{
  background: #fff;
  width: 22px;
  height: 22px;
  position: absolute;
  border-radius: 50%;
  top: 3px;
  left: 3px;
  -webkit-transition: left 0.3s ease-in;
  -moz-transition: left 0.3s ease-in;
  transition: left 0.3s ease-in;
}
.bi-switcher .sw-val{
  position: absolute;
  left: 100%;
  width: auto;
  top: 0px;
  color: #ccc;
  line-height: 28px;
  font-size: 15px;
  padding-left: 12px;
}
.bi-switcher:hover{background: #999;}
.bi-switcher.active{background: #46b450 !important;}
.bi-switcher.active .sw{left: 31px;}

.red-bi-switcher{background: #aa2c2c}
.red-bi-switcher:hover{background: #aa2c2c}
.red-bi-switcher .sw-val{color: #aa2c2c}
.red-bi-switcher.active .sw-val{color: #46b450}

.bi-switcher-toggle{margin-top: 30px;}
.bi-switcher-toggle .input-label{display:block;}

.btnskip{color: #999;font-weight: normal;}
.btnskip:hover{color: #444}

.email-column {
  max-width: 130px !important;
  min-width: 130px !important;
  position: relative;
}
.email-column input{width: 100%;}
.email-address{position: absolute;top: 19px;max-width: 100px;overflow: hidden;z-index: 3;}
.email-address:after{
  position: absolute;
  top: 0;
  right: 0;
  width: 25px;
  height: 100%;
  content: "";
  background: rgba(255,255,255,0);
  background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
  background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
  background: linear-gradient(to right,  rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
}
.email-column .email-address span{padding: 0 12px 8px 0;border-bottom-right-radius: 4px;}
.email-column:hover .email-address{overflow: visible}
.email-column:hover .email-address:after{display: none;}
.email-column:hover .email-address span{
  -webkit-box-shadow: 4px 4px 6px 0px #eee;
  -moz-box-shadow: 4px 4px 6px 0px #eee;
  box-shadow: 4px 4px 6px 0px #eee;
  background: #fff;
}

.score-column{min-width: auto !important}
.downloaded-column{max-width: 100px !important}
.purchased-column{min-width: auto !important;}
.purchased-column input{width: 100%;}
.score-column:before, .score-column:after{
  top: 60% !important;right: 24px !important;
}

.checkbox-column{
  position: relative;
  min-width: 40px;
}
.row-checkbox, .pp-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.row-checkbox{    
  position: absolute;
    top: 50%;
    left: 50%;
    margin: -9px 0 0 -9px;
  }
.pp-checkbox{display: inline-block;vertical-align: top;
margin-top: -3px;
margin-right: 6px;background-color: #fdfdfd;}
.row-checkbox.checked:after, .pp-checkbox.checked:after{
  position: absolute;
  top: 1px;
  left: 2px;
  width: 14px;
  height: 14px;
  content: '';
  background-size: 14px 14px;
  background-repeat: no-repeat;
  background-image: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgdmlld0JveD0iMCAwIDc4LjM2OSA3OC4zNjkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDc4LjM2OSA3OC4zNjk7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48Zz4KCTxwYXRoIGQ9Ik03OC4wNDksMTkuMDE1TDI5LjQ1OCw2Ny42MDZjLTAuNDI4LDAuNDI4LTEuMTIxLDAuNDI4LTEuNTQ4LDBMMC4zMiw0MC4wMTVjLTAuNDI3LTAuNDI2LTAuNDI3LTEuMTE5LDAtMS41NDdsNi43MDQtNi43MDQgICBjMC40MjgtMC40MjcsMS4xMjEtMC40MjcsMS41NDgsMGwyMC4xMTMsMjAuMTEybDQxLjExMy00MS4xMTNjMC40MjktMC40MjcsMS4xMi0wLjQyNywxLjU0OCwwbDYuNzAzLDYuNzA0ICAgQzc4LjQ3NywxNy44OTQsNzguNDc3LDE4LjU4Niw3OC4wNDksMTkuMDE1eiIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIiBzdHlsZT0iZmlsbDojNkQ3Qjg0IiBkYXRhLW9sZF9jb2xvcj0iIzAwMDAwMCI+PC9wYXRoPgo8L2c+PC9nPiA8L3N2Zz4=);
}
.pp-checkbox.checked:after{
  top: -1px;left: 3px;
}

.accountstatus-column input, .status-column input, .compliant-column input{
  width: 100%;
}

.accountstatus-column{min-width: 98px !important;}
.accountstatus-column .th-select-ul{min-width: 90px;}
.status-column{min-width: 100px !important;}

.status-column .th-select-ul{min-width: 115px;}

.hidden{display: none;}

.tg-header{cursor: pointer;position: relative;-webkit-user-select:none!important;-moz-user-select:none!important;-ms-user-select:none!important;user-select:none!important}
.tg-header span{position: relative;}
.tg-header span:after {
  top: 46%;
  right: -20px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(94, 94, 94, 0);
  border-top-color: #5e5e5e;
  border-width: 5px;
  margin-left: -5px;
}
.tg-header.open span:after {
  top: auto;
  bottom: 37%;
  border-bottom-color: #5e5e5e;
  border-top-color: transparent;
}
.newton{display: none;}
.data-row-linked{font-size: 14px;}
.content-alert{
  color:#004085;
  background-color:#e2effd;
  border: 1px solid#b8daff;

  position: absolute;
  padding: 18px 20px 17px 23px;
  border-radius: 4px;
  font-size: 14px;
  z-index: 2;
  top: -63px;
  left: -40px;
  min-width: 525px;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  transition: all 0.4s ease;
  opacity: 0;
}
.content-alert.slowshow{opacity: 1;left: 0;}

.super-modal.autoheight-done{min-height: 205px;}
.delred{color: #d75656;background: #fff;margin-left: 60px;}
.delred:hover{color: #fff;background: #d75656}

.neo-list li{margin-bottom: 15px}
.neo-list li a{font-size: 17px;position: relative;padding-left: 32px;color: #7b8b91;}
.neo-list li a:before{
  background-image: url('/static/images/ui/sb_arrow.png');
  position: absolute;top: 0;left: 0;width: 18px;
  height: 18px;
  content: '';
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
  background-size: 16px 16px;
  background-repeat: no-repeat;
  -webkit-transition: left 0.2s ease-in;
  -moz-transition: left 0.2s ease-in;
  transition: left 0.2s ease-in;
}
.neo-list li a:hover:before{
  left: 5px;
}
.neo-list li:last-child{margin-bottom: 0;}
.report-date-input{
  background: transparent;
  color: #000;
  border: 0;
  outline: 0;
  margin-left: 15px;
  width: 100px;
  cursor: pointer;
  font-size: 18px;
  margin-top: -1px;
  border-bottom: 1px dotted #333;
  text-align: center;
}
.th-numid{width: 70px}
.date-custom-picker{display: inline-block;position: relative;margin-left: 15px;}
.date-custom-picker .pw-value{font-size: 18px;border-bottom: 1px dotted #333;cursor: pointer;}
.date-custom-picker .list{
display: none;position: absolute;top: 100%;left: 0;width: 335px;
padding: 6px 0;
background-color: #fff;
-webkit-box-shadow: 0 0 2px 2px #ccc;
-moz-box-shadow: 0 0 2px 2px #ccc;
box-shadow: 0 0 2px 2px #ccc;
font-size: 16px;
border-radius: 4px;
}
.date-custom-picker .list .pw{border-bottom: 1px solid #eee;cursor: pointer;padding: 6px 10px 6px 10px;margin-bottom: 6px;}
.date-custom-picker .list .pw:hover{background-color: #eee}
.date-custom-picker .list .pw:last-child{border-bottom: 0}
.th-wt{min-width: 155px;text-align: center;}
.th-wt span{font-weight: normal;}

#reports .default-table th{white-space: nowrap;}


@media (max-width: 1280px){
  .center-page #content{padding: 0 10%}
  .center-page .error, .center-page .success{width: 100%;}
  .content-inner-wrapper{padding: 0}
  .credit-history{ }
  th.sortable[data-id="email"]{min-width: 204px}
}
@media (max-width: 1100px){
  .table-search{float: right;margin-left: 0;}
  .table-right-side{width: 100%;float: left;margin-top: 25px;}
}
@media (max-width: 1050px){
   .center-page #content{padding: 0}
}
@media (max-width: 768px){
  .tt{display: none}
  #sidebar{display: none}
  #menu{display: block;}
#content {
    padding-left: 0;
}
.sb-mini #content{padding-left: 0;}
  #table-content{height: auto; overflow-x: auto; overflow-y: hidden; white-space: nowrap;}

  .content-wrapper{padding-left: 0;padding-right: 0;}
  .error, .success{width: 100%;min-width: 100%;max-width: 100%}
}
@media (max-width: 650px){
  .table-size, .table-search, .table-entries, .table-pagination, .table-right-side{float: left;width: 100%}
  .table-right-side{margin-top: 24px;}
  .table-search{margin-left: 0;}
  .table-search, .table-pagination{margin-top: 20px;}
  .content-inner-fragment{padding: 15px;}
  .content-inner-fragment .data-row .label{display: none;}
  .content-inner-fragment .data-row .value{width: 100%;min-width: 100%}
  .courses-limit{left: auto;right: 0;}

  #jodit-preview-content{width: 100%;margin-left: 0;}


  .user-course .course-name{min-height: 28px;width: auto;max-width: 67%;}
  .user-course{position: relative;}
  .user-course .inp{position: absolute;
right: 45px;
top: 0;}

.select-input{width: 59%;}
  .attachcoursebtn{position: absolute;top: 0;right: 45px;}
   .close-modal{right: -20px}
  .dl-inner.file-icon{background-position: 0 4px;}
  .dl-inner.file-icon .bi{margin-top: 4px;margin-bottom: 10px;}

  .cert-selection{margin-right: 5px;}
  .cert-selection select{background-color: #fff;width: 165px;padding-left: 5px;padding-right: 0;margin-right: 5px;}
  .table-right-side .tb-rb{padding: 0 15px;}

}
@media (max-width: 450px){
  .content-alert{width: 100%;line-height: 20px;min-width: 100%;}
  body.fix .default-table {
      display: none;
  }
  .super-modal{position: fixed;top: 0;left: 0;width: 100%;height: 100%;overflow-y: scroll;padding-bottom: 65px;-webkit-transform: none;-moz-transform: none;transform: none;margin-left: 0;}
  .super-modal .close-modal{position: fixed;top: 15px;right: 15px;}
  .hm li a i{top: 10px;right: 25px;width: 28px;height: 28px;line-height: 28px;}

  #user-menu .inline-name span{max-width: 68px;white-space: nowrap;}
  .wrapper{padding-left: 10px;padding-right: 10px}
  .close-modal{right: -15px}
  #logo{margin-top: 17px}
  #logo img{width: 100px;}
  #header{padding: 0 10px}
  #user-menu img{width: 32px;height: 32px;}
  #user-menu .inline-name{padding: 0 20px;}
  .changecreditsbtn{padding-left: 15px !important;height: 36px;line-height: 35px;}
  .changecreditsbtn span{padding: 0 15px !important;margin-left: 15px !important;font-weight: normal;}
  .table-right-side .tb-rb{margin-top: 10px}
}
