<?php
header("Cache-Control: no-transform"); // Fix AT&T's wireless servers gzipping bullshit (random characters on page)
// ob_start('ob_gzhandler'); also works

function email($address, $name="") {
  $email = "";
  for ($i = 0; $i < strlen($address); $i++) { $email .= (rand(0, 1) == 0) ? "&#" . ord(substr($address, $i)) . ";" : substr($address, $i, 1); }
  if ($name == "") $name = $email;
  echo "<a href=\"&#109;&#97;&#105;&#108;&#116;&#111;&#58;$email\">$name</a>";
}

include_once "inc/dbconfig.php";
$today = strtotime("today 00:00");
$tomorrow = strtotime("tomorrow 00:00");
$rightnow = time();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Shank Hall<?php if (isset($PageTitle)) echo " | " . $PageTitle; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <meta name="description" content="Milwaukee's showcase live music venue since 1989.">
    <meta name="keywords" content="Milwaukee, WI, Wisconsin, music, bands, live music, live, concert, concerts, ticket, tickets, entertainment, Blues, Rock, Pop, Alternative, Jazz, Folk, Bluegrass, Metal, Irish, Celtic, Spinal Tap, stonehenge">
    <meta name="author" content="Mark Lippert">

    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="inc/main.css?<?php echo filemtime("inc/main.css"); ?>">

    <link rel="stylesheet" href="inc/jquery-magnific-popup-0.9.8.css">
    <script type="text/javascript" src="inc/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="inc/jquery-magnific-popup-0.9.8.min.js"></script>
    <script type="text/javascript" src="inc/bootstrap-collapse.js"></script>
    <script type="text/javascript" src="inc/jquery-equalheights.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("a[href^='http'], a[href$='.pdf']").not("[href*='" + window.location.host + "']").attr('target','_blank');
        $('.popup-link').magnificPopup({ type:'inline', midClick: true });
        $(".calendar-day").equalHeights(100,500);
        $(window).resize();
      });
      $(window).resize(function() {
         if ($(this).width() > 480) {
            $(".ticket-left, .ticket-right").equalHeights(66,500);
         }
      });
    </script>

    <!--[if lt IE 9]><script src="inc/modernizr-2.6.2-respond-1.1.0.min.js"></script><![endif]-->
    <!--[if lt IE 7 ]>
    <script type="text/javascript" src="inc/dd_belatedpng.js"></script>
    <script type="text/javascript">DD_belatedPNG.fix('img, .png');</script>
    <![endif]-->

    <link rel="alternate" type="application/rss+xml" href="rssfeed.xml" title="Shank Hall">

    <!-- BEGIN Google Analytics -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-9892672-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <!-- END Google Analytics -->

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
     fbq('init', '533197170168078'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
     <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=533197170168078&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
  </head>
  <body>

    <div id="wrap">
      <header>
        <a href="."><img src="images/logo.png" alt="Shank Hall" id="logo"></a>

        <a id="menu-toggle" data-toggle="collapse" data-target="#menu"></a>

        <div id="menu-wrap">
          <nav id="menu" class="collapse">
            <?php include "menu.php"; ?>
          </nav>
        </div>
      </header>

      <div id="content<?php if (!isset($PageTitle)) echo "-cal"; ?>">
        <div id="slogan">

          <div id="social">
            <a href="https://www.facebook.com/shank.hall.7"><img src="images/icon-facebook.png" alt="Facebook"></a>
            <a href="http://twitter.com/ShankHallMke"><img src="images/icon-twitter.png" alt="Twitter"></a>
          </div>
          Milwaukee's Showcase Live Music Venue Since 1989
        </div>

        <article>
