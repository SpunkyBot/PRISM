<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRISM - <?php echo $title; ?></title>
    <meta name="description" content="PRISM - Web frontend for Spunky Bot, a free game server administration bot and RCON tool for Urban Terror">
    <meta name="keywords" content="Spunky Bot, PRISM, Player, Related, Information, Statistic, Monitor, web, frontend, Urban, Terror">
    <meta name="apple-mobile-web-app-title" content="PRISM">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="Alexander Kress">
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
    <link rel="icon" sizes="16x16 32x32" href="./favicon.ico">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/yeti/bootstrap.min.css" integrity="sha256-1XXigimvLzHb7NeEJIG76DRDmTpUtVywP6B+jvo/a7Q=" crossorigin="anonymous" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css" integrity="sha256-PbaYLBab86/uCEz3diunGMEYvjah3uDFIiID+jAtIfw=" crossorigin="anonymous" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.9.0/css/flag-icon.min.css" integrity="sha256-D+ZpDJjhGxa5ffyQkuTvwii4AntFGBZa4jUhSpdlhjM=" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/prism.min.css">
    <link rel="stylesheet" href="./css/military-rank-icon.min.css">
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="page-top">
    <!--[if lt IE 9]>
      <div class="alert alert-warning">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div>
    <![endif]-->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./#page-top" title="Player Related Information and Statistic Monitor"><i class="fa fa-bolt"></i> PRISM</a>
        </div>
        <div class="navbar-collapse collapse navbar-right">
          <ul class="nav navbar-nav">
            <li<?php echo (basename($_SERVER['PHP_SELF'], '.php') == 'index') ? " class='active'" : ""; ?>><a href="./">SERVER</a></li>
            <li<?php echo (basename($_SERVER['PHP_SELF'], '.php') == 'stats') ? " class='active'" : ""; ?>><a href="./stats.php">PLAYER STATS</a></li>
            <li<?php echo (basename($_SERVER['PHP_SELF'], '.php') == 'banlist') ? " class='active'" : ""; ?>><a href="./banlist.php">BANLIST</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" role="button" href="#" data-toggle="dropdown">ABOUT <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Team</li>
                <li><a href="./about.php">ABOUT US</a></li>
                <li><a href="./staff.php">STAFF</a></li>
                <li class="divider" role="separator"></li>
                <li class="dropdown-header">Server</li>
                <li><a href="./commands.php">COMMANDS</a></li>
                <li><a href="./rules.php">RULES</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">