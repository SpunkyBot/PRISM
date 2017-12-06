<?php

$page = (isset($_GET['view']) ? htmlspecialchars($_GET['view'], ENT_QUOTES, 'UTF-8') : "home");

// Config file
require('./conf/settings.php');

// HTML Header
require('./tpl/header.php');

// PRISM
require('./lib/prism.php');
$page_render = new Prism($dbPath, $ip, $port);

if ($page == 'player-stats') echo $page_render->renderPlayerStats();
elseif ($page == 'banlist') echo $page_render->renderBanlist();
elseif ($page == 'staff') echo $page_render->renderStaff();
elseif ($page == 'about') require_once("about.php");
elseif ($page == 'commands') require_once("commands.php");
elseif ($page == 'rules') require_once("rules.php");
else echo $page_render->renderDashboard();

// HTML Footer
require('./tpl/footer.php');

?>
