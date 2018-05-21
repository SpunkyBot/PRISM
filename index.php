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
elseif (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'banlist') echo $page_render->renderBanlist();
elseif (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'staff') echo $page_render->renderStaff();
elseif (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'about') require_once("about.php");
elseif (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'commands') require_once("commands.php");
elseif (htmlspecialchars($page, ENT_QUOTES, 'UTF-8') == 'rules') require_once("rules.php");
else echo $page_render->renderDashboard();

// HTML Footer
require('./tpl/footer.php');

?>
