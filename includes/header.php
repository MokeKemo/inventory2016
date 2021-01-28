<?php
session_start();
Access::checkSession();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<head>
<title>Inventory Manager</title>
<meta name="description" content="Phone Order Panel" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link href="<?= CSS_PATH . 'style.css'?>" rel="stylesheet" type="text/css" />
<link href="<?= CSS_PATH . 'viewData.css'?>" rel="stylesheet" type="text/css" />
<link href="<?= CSS_PATH . 'chosen.css'?>"  rel="stylesheet">
 <link rel="stylesheet" href="css/formvalidator.css" type="text/css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="http://www.devinfopoint.com/inventory/js/popup.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
 <!-- <script src="http://code.jquery.com/jquery-1.10.2.js"></script>-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.1.3/parsley.min.js"></script> 
  <script type="text/javascript" src="<?= JS_PATH.'functions.js' ?>"></script>
  <script type="text/javascript" src="<?= JS_PATH.'menu.js' ?>"></script>

    <!-- ZA TEBELE -->
    <script src="<?= JS_PATH.'plugins/datatables/jquery.dataTables.js'?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/DT_bootstrap.js' ?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/media/js/ZeroClipboard.js' ?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/media/js/TableTools.js' ?>"></script>
</head>