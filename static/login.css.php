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
body {
  font-size: 12px;
  font-family: 'Roboto', sans-serif;
  color: #333;
  background: #ebeff2;
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
  color: #0a67e4;
}
.super_hidden{
  display: none;position: absolute;left: -9999px;width: 1px;height: 1px;
}
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
.btn-loader{display: inline-block;min-width: 40px;text-align: center;}
.btn-loader img{
    display: inline-block;
    width: 19px;
    height: 19px;
    vertical-align: middle;
}
#login{
  position: fixed;
  z-index: 2;
  width: 360px;
  margin-left: -180px;
  min-height: 300px;
  top: 50%;
  left: 50%;
  text-align: center;
  opacity: 0;
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  transition: all 0.5s ease;
}
#login.visible{opacity:1;
  -webkit-transform: translateY(-55%);
  -moz-transform: translateY(-55%);
  transform: translateY(-55%);
}

.bi{position: relative;}
.bi .input-label{position: absolute;top: 12px;left: 12px;color: #666;-webkit-transition: all 0.5s ease;-moz-transition: all 0.5s ease;transition: all 0.5s ease;}
.bi input{color: #222;width: 100%;height: 36px;padding-bottom: 2px;padding-left: 12px;border: 1px solid #ccc;outline: none;border-radius: 3px;}
.bi.active .input-label{top: -16px;font-size: 11px;}

.login-psb{position: relative;opacity: 0;left: 100px;}
.send-form{margin-top: 25px;}
.mid-text a{color: #2c8bcb;
font-size: 14px;
cursor: pointer;}
.btn{background: #35acfc;color: #fff;font-weight: bold;color: #fff;line-height: 38px;height: 38px;padding: 0 32px;border-radius: 32px;
display: inline-block;font-size: 15px;cursor: pointer;  -webkit-transition: all 0.5s ease;-moz-transition: all 0.5s ease;transition: all 0.5s ease;}
.btn:hover{background: #2c8bcb;}
#login .logo{margin-bottom: 30px;}
#login .head{font-size: 18px;color: #222;margin-bottom: 30px;}
#login .logo img{
  display: inline-block;
width: 250px;
}
#login .form{width: 100%;padding: 30px 30px 35px 30px;background: #fff;border-radius: 5px;}
#login .form+.form{margin-top: 20px;}
#login .bi{margin-bottom: 30px;}
/*.error{
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
  width: 100%;
  padding: 15px 20px 15px 54px;
  font-size: 14px;
  text-align: left;
}*/
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
  width: 100%;
  padding: 15px 20px 15px 54px;
  font-size: 14px;
  text-align: left;
}
.success{
  background-color: #4caf50 !important;
  background-image: url('/static/images/ui/res_success.png') !important;
}

@media (max-width: 600px){
  #login{position:relative;width: 100%;left: 0;margin-left: 0;top: 20px;-webkit-transform: translateY(0%) !important;-moz-transform: translateY(0%) !important;transform: translateY(0%) !important;}
  #login .form:last-child{margin-bottom: 45px;}
}