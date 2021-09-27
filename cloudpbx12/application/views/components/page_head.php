<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<title>Cloud PBX Portal</title>

<link href="<?php echo site_url('/assets/css/bootstrap.css'); ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/fontawesome/css/all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/datatables/datatables.css'); ?>"/>
<link href="<?php echo site_url('assets/css/mdb.min.css'); ?>" rel="stylesheet">     
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/sweetalert2/sweetalert2.css') ?>">
<?php if($this->uri->segment(2)=='Call_forward'){?>
<link href="<?php echo site_url('assets/css/callmanagement.css'); ?>" rel="stylesheet">
<?php }?>
<link href="<?php echo site_url('assets/css/style.css'); ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/mdb-file-upload.min.css'); ?>">
<link href="<?php echo site_url('assets/dropzone/dropzone.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<style type="text/css">

@font-face {
font-family: 'Libre Baskerville';
font-style: normal;
font-weight: 400;
src: local('Libre Baskerville'), local('LibreBaskerville-Regular'), url(<?php echo site_url('assets/font/kmKnZrc3Hgbbcjq75U4uslyuy4kn0qNZaxM.woff2'); ?>) format('woff2');
unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}

/* latin */
@font-face {
font-family: 'Libre Baskerville';
font-style: normal;
font-weight: 400;
src: local('Libre Baskerville'), local('LibreBaskerville-Regular'), url(<?php echo site_url('assets/font/kmKnZrc3Hgbbcjq75U4uslyuy4kn0qNZaxM.woff2'); ?>) format('woff2');
unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

@font-face {
font-family: 'Material Icons';
font-style: normal;
font-weight: 400;
src: url(<?php echo site_url('assets/material_icons/iconfont/MaterialIcons-Regular.eot'); ?>); /* For IE6-8 */
src: local('Material Icons'),
local('MaterialIcons-Regular'),
url(<?php echo site_url('assets/material_icons/iconfont/MaterialIcons-Regular.woff2'); ?>) format('woff2'),
url(<?php echo site_url('assets/material_icons/iconfont/MaterialIcons-Regular.woff'); ?>) format('woff'),
url(<?php  echo site_url('assets/material_icons/iconfont/MaterialIcons-Regular.ttf'); ?>) format('truetype');
}

.material-icons {
font-family: 'Material Icons';
font-weight: normal;
font-style: normal;
font-size: 24px;  /* Preferred icon size */
display: inline-block;
line-height: 1;
text-transform: none;
letter-spacing: normal;
word-wrap: normal;
white-space: nowrap;
direction: ltr;

/* Support for all WebKit browsers. */
-webkit-font-smoothing: antialiased;
/* Support for Safari and Chrome. */
text-rendering: optimizeLegibility;

/* Support for Firefox. */
-moz-osx-font-smoothing: grayscale;

/* Support for IE. */
font-feature-settings: 'liga';
}

.dataTables_info
{
float: left;
color: #007bff;
}

/*//Copy this css*/
.navbar-light .navbar-nav .nav-link {
color: rgb(64, 64, 64);
}
.btco-menu li > a {
padding: 10px 15px;
color: #000;

}

.btco-menu .active a:focus,
.btco-menu li a:focus ,
.navbar > .show > a:focus{
background: transparent;
outline: 0;
}


.dropdown-menu .show > .dropdown-toggle::after{
transform: rotate(-90deg);
}


div.dataTables_wrapper div.dataTables_length label {

font-weight: normal;
text-align: left;
white-space: nowrap;
margin-top: 40px !important;
margin-right: 15px !important;
} 

.flex-row
{
-webkit-box-orient: horizontal !important;
-webkit-box-direction: normal !important;
-ms-flex-direction: row !important;
flex-direction: row !important;
width: 180px !important;
}   

</style>
<link href="<?php echo site_url('assets/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet">
<link href="<?php echo site_url('assets/css/addons-pro/stepper.min.css'); ?>" rel="stylesheet">

</head>
<body class="body">
