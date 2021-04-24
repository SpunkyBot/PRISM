<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRISM - Web frontend for Spunky Bot</title>
    <meta name="description" content="PRISM - Web frontend for Spunky Bot, a free game server administration bot and RCON tool for Urban Terror">
    <meta name="keywords" content="Spunky Bot, PRISM, Player, Related, Information, Statistic, Monitor, web, frontend, Urban, Terror">
    <meta name="apple-mobile-web-app-title" content="PRISM">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="Alexander Kress">
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
    <link rel="icon" sizes="16x16 32x32" href="./favicon.ico">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/yeti/bootstrap.min.css" integrity="sha512-3/E8oqUZ6mBL4RsSxlmAIOgDo3R6zFUiXC62Eo9YLHDwlAIzZ3HOKzDUTYMgU1PiWYc34gvAt21DmNesc16jrw==" crossorigin="anonymous" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha512-Cv93isQdFwaKBV+Z4X8kaVBYWHST58Xb/jVOcV9aRsGSArZsgAnFIhMpDoMDcFNoUtday1hdjn0nGp3+KZyyFw==" crossorigin="anonymous">
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
            <li<?php echo (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'home') ? " class='active'" : ""; ?>><a href="./">SERVER</a></li>
            <li<?php echo (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'player-stats') ? " class='active'" : ""; ?>><a href="./?view=player-stats">PLAYER STATS</a></li>
            <li<?php echo (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'banlist') ? " class='active'" : ""; ?>><a href="./?view=banlist">BANLIST</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" role="button" href="#" data-toggle="dropdown">ABOUT <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Team</li>
                <li><a href="./?view=about">ABOUT US</a></li>
                <li><a href="./?view=staff">STAFF</a></li>
                <li class="divider" role="separator"></li>
                <li class="dropdown-header">Server</li>
                <li><a href="./?view=commands">COMMANDS</a></li>
                <li><a href="./?view=rules">RULES</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">