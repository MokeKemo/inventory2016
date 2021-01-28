<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<head>
<title>Phone Order Panel</title>
<meta name="description" content="Phone Order Panel" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link href="<?= CSS_PATH.'style.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?= CSS_PATH.'viewData.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?= CSS_PATH.'chosen.css' ?>" rel="stylesheet">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
 <!-- <script src="http://code.jquery.com/jquery-1.10.2.js"></script>-->
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
  <script type="text/javascript" src="<?= JS_PATH.'chosen.jquery.min.js' ?>"></script>
  <script type="text/javascript" src="<?= JS_PATH.'tracker.php?state=$state' ?>"></script>
  <script>
  var countryLocation = "<?= $state ?>";
  </script>
  <script type="text/javascript" src="<?= JS_PATH.'translations.js.php?state=' . $state ?>"></script>
  <script type="text/javascript" src="<?= JS_PATH.'functions.js' ?>"></script>
  <script type="text/javascript" src="<?= JS_PATH.'menu.js' ?>"></script>

    <!-- ZA TEBELE -->
    <script src="<?= JS_PATH.'plugins/datatables/jquery.dataTables.js'?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/DT_bootstrap.js' ?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/media/js/ZeroClipboard.js' ?>"></script>
    <script src="<?= JS_PATH.'plugins/datatables/media/js/TableTools.js' ?>"></script>
</head>