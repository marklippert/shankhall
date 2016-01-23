<?php
include_once "../inc/dbconfig.php";
$today = strtotime("today 00:00");
$tomorrow = strtotime("tomorrow 00:00");
$rightnow = time();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Shank Hall<?php if ($PageTitle != "") echo " | " . $PageTitle; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Mark Lippert">

    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../inc/main.css">
    <link rel="stylesheet" href="inc/admin.css">

    <script type="text/javascript" src="../inc/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../inc/bootstrap-collapse.js"></script>
    <link rel="stylesheet" href="inc/bootstrap-datepicker.css" type="text/css" media="screen,print">
    <script type="text/javascript" src="inc/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="inc/jquery.timepicker.css" type="text/css" media="screen,print">
    <script type="text/javascript" src="inc/jquery.timepicker.js"></script>
    <script type="text/javascript" src="inc/jquery-toggle-box.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("a[href^='http'], a[href$='.pdf']").not("[href*='" + window.location.host + "']").attr('target','_blank');
        $("#access_password").focus();
        $("#show_date").datepicker({format: "m/d/yyyy"}).on('changeDate', function(ev){$("#show_date").datepicker('hide');});
        $(".mytimepicker").timepicker({'step': 30, 'scrollDefaultTime': "8:00pm"});
        $("#embargo_date").datepicker({format: "m/d/yyyy"}).on('changeDate', function(ev){$("#embargo_date").datepicker('hide');});
        $(".embargo_hour").timepicker({'step': 60, 'timeFormat': "G:i"});
      });
    </script>
    <script language="JavaScript" type="text/JavaScript">
      function toggle(obj,obj2) {
        document.getElementById(obj).style.display = (document.getElementById(obj).style.display != 'none' ? 'none' : 'block' );
        document.getElementById(obj2).style.display = (document.getElementById(obj2).style.display != 'none' ? 'none' : 'block' );
      }
    </script>

    <!--[if lt IE 9]><script src="../inc/modernizr-2.6.2-respond-1.1.0.min.js"></script><![endif]-->
    <!--[if lt IE 7 ]>
    <script type="text/javascript" src="../inc/dd_belatedpng.js"></script>
    <script type="text/javascript">DD_belatedPNG.fix('img, .png');</script>
    <![endif]-->
  </head>
  <body>

    <div id="wrap">
      <div id="content">
        <div id="slogan">
          Site Administration
        </div>

        <article>
