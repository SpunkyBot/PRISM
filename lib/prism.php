<?php
// PRISM - Web frontend for Spunky Bot
// Author: Alexander Kress
$version = "0.9.12";

// define error level
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// include the GeoIP PHP script - created by MaxMind
include('geoip.inc');

class Prism
{
    private $_db_path;
    private $_host;
    private $_port;
    private $_offline;
    private $_params;
    private $_players;

    // Constructor takes the full path of the SQLite database, the server IPv4 address and port
    public function __construct($dbPath, $host = "127.0.0.1", $port = 27960)
    {
        $this->_db_path = strval($dbPath);
        $this->_host = strval($host);
        $this->_port = intval($port);
        $this->_offline = false;
        $this->_params = array();
        $this->_players = array();
        $this->_db_errorcount = 0;
    }

    private function dbQuery($query, $params=array(), $liste=false)
    {
        try {
            $conn = new PDO('sqlite:' . $this->_db_path);
            $stmt = $conn->prepare(strval($query), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            if ($stmt === false) { ++$this->_db_errorcount; throw new PDOException("Database file '" . $this->_db_path . "' not found"); }
            $stmt->execute($params);
            $result = ($liste ? $stmt->fetchAll() : $stmt->fetch());
            $conn = null;
        } catch (PDOException $e) {
            if ($this->_db_errorcount < 2) echo '<div class="alert alert-danger"><strong>Exception:</strong> ' . $e->getMessage() . '</div>';
        }
        return $result;
    }

    private function queryServer()
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if ($socket) {
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));
            socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 3, 'usec' => 0));
            if (socket_connect($socket, $this->_host, $this->_port)) {
                socket_write($socket, "\xFF\xFF\xFF\xFFgetstatus\n");
                $out = socket_read($socket, 2048, PHP_BINARY_READ);
                if (!$out) {
                    $this->_offline = true;
                    socket_close($socket);
                    throw new Exception("Unable to connect to server.");
                }
                socket_close($socket);
                $out = preg_replace("/\xFF\xFF\xFF\xFFstatusResponse\n/", "", $out);
                $all = explode("\n", $out);
                $this->_params = explode("\\", $all[0]);
                array_shift($this->_params);
                $temp = count($this->_params);
                for ($i = 0; $i < $temp; $i++) {
                    $this->_params[strtolower($this->_params[$i])] = $this->_params[++$i];
                }
                $temp = count($all);
                for ($i = 1; $i < $temp - 1; $i++) {
                    $pos = strpos($all[$i], " ");
                    $score = substr($all[$i], 0, $pos);
                    $pos2 = strpos($all[$i], " ", $pos + 1);
                    $ping = substr($all[$i], $pos + 1, $pos2 - $pos - 1);
                    $name = substr($all[$i], $pos2 + 2);
                    $name = substr($name, 0, strlen($name) - 1);
                    $player = array("name" => $name, "score" => intval($score), "ping" => intval($ping));
                    $this->_players[] = $player;
                }
            } else throw new Exception("Unable to connect to server.");
        } else throw new Exception("The server is DOWN!");
    }

    private function prettyName($name)
    {
        $prettyname = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        for ($i = 0; $i < 10; $i++) {
            $prettyname = str_replace('^' . $i . '', '', $prettyname);
        }
        return $prettyname;
    }

    private function getRoleName($role)
    {
        $role_name = 'User';
        if ($role == 2) $role_name = 'Regular';
        elseif ($role == 20) $role_name = 'Moderator';
        elseif ($role == 40) $role_name = 'Admin';
        elseif ($role == 60) $role_name = 'Full Admin';
        elseif ($role == 80) $role_name = 'Senior Admin';
        elseif ($role == 90) $role_name = 'Super Admin';
        elseif ($role == 100) $role_name = 'Head Admin';
        return $role_name;
    }

    private function getRank($kills)
    {
      if ($kills < 20) { $icon = 'rank-03-e2'; $player_rank = 'Private'; $kills_needed = 20 - $kills; $percent = $kills_needed / 20; }
      elseif ($kills < 50) { $icon = 'rank-03-e3'; $player_rank = 'Private First Class'; $kills_needed = 50 - $kills; $percent = $kills_needed / (50-20); }
      elseif ($kills < 150) { $icon = 'rank-03-e4-2'; $player_rank = 'Specialist'; $kills_needed = 150 - $kills; $percent = $kills_needed / (150-50); }
      elseif ($kills < 300) { $icon = 'rank-01-e3'; $player_rank = 'Lance Corporal'; $kills_needed = 300 - $kills; $percent = $kills_needed / (300-150); }
      elseif ($kills < 500) { $icon = 'rank-01-e4'; $player_rank = 'Corporal'; $kills_needed = 500 - $kills; $percent = $kills_needed / (500-300); }
      elseif ($kills < 750) { $icon = 'rank-01-e5'; $player_rank = 'Sergeant'; $kills_needed = 750 - $kills; $percent = $kills_needed / (750-500); }
      elseif ($kills < 1000) { $icon = 'rank-01-e6'; $player_rank = 'Staff Sergeant'; $kills_needed = 1000 - $kills; $percent = $kills_needed / (1000-750); }
      elseif ($kills < 1500) { $icon = 'rank-03-e7'; $player_rank = 'Sergeant First Class'; $kills_needed = 1500 - $kills; $percent = $kills_needed / (1500-1000); }
      elseif ($kills < 2000) { $icon = 'rank-01-e7'; $player_rank = 'Gunnery Sergeant'; $kills_needed = 2000 - $kills; $percent = $kills_needed / (2000-1500); }
      elseif ($kills < 2500) { $icon = 'rank-01-e8-1'; $player_rank = 'Master Sergeant'; $kills_needed = 2500 - $kills; $percent = $kills_needed / (2500-2000); }
      elseif ($kills < 3000) { $icon = 'rank-01-e8-2'; $player_rank = 'First Sergeant'; $kills_needed = 3000 - $kills; $percent = $kills_needed / (3000-2500); }
      elseif ($kills < 3500) { $icon = 'rank-01-e9-1'; $player_rank = 'Master Gunnery Sgt'; $kills_needed = 3500 - $kills; $percent = $kills_needed / (3500-3000); }
      elseif ($kills < 4000) { $icon = 'rank-01-e9-2'; $player_rank = 'Sergeant Major'; $kills_needed = 4000 - $kills; $percent = $kills_needed / (4000-3500); }
      elseif ($kills < 5000) { $icon = 'rank-01-o1'; $player_rank = 'Second Lieutenant'; $kills_needed = 5000 - $kills; $percent = $kills_needed / (5000-4000); }
      elseif ($kills < 6000) { $icon = 'rank-01-o2'; $player_rank = 'First Lieutenant'; $kills_needed = 6000 - $kills; $percent = $kills_needed / (6000-5000); }
      elseif ($kills < 7000) { $icon = 'rank-01-o3'; $player_rank = 'Captain'; $kills_needed = 7000 - $kills; $percent = $kills_needed / (7000-6000); }
      elseif ($kills < 8000) { $icon = 'rank-01-o4'; $player_rank = 'Major'; $kills_needed = 8000 - $kills; $percent = $kills_needed / (8000-7000); }
      elseif ($kills < 9000) { $icon = 'rank-01-o5'; $player_rank = 'Lieutenant Colonel'; $kills_needed = 9000 - $kills; $percent = $kills_needed / (9000-8000); }
      elseif ($kills < 10000) { $icon = 'rank-01-o6'; $player_rank = 'Colonel'; $kills_needed = 10000 - $kills; $percent = $kills_needed / (10000-9000); }
      elseif ($kills < 12500) { $icon = 'rank-01-o7'; $player_rank = 'Brigadier General'; $kills_needed = 12500 - $kills; $percent = $kills_needed / (12500-10000); }
      elseif ($kills < 15000) { $icon = 'rank-01-o8'; $player_rank = 'Major General'; $kills_needed = 15000 - $kills; $percent = $kills_needed / (15000-12500); }
      elseif ($kills < 17500) { $icon = 'rank-01-o9'; $player_rank = 'Lieutenant General'; $kills_needed = 17500 - $kills; $percent = $kills_needed / (17500-15000); }
      elseif ($kills < 20000) { $icon = 'rank-01-o10'; $player_rank = 'General'; $kills_needed = 20000 - $kills; $percent = $kills_needed / (20000-17500); }
      elseif ($kills >= 20000) { $icon = 'rank-01-o10'; $player_rank = 'Field Marshal'; $kills_needed = 0; $percent = 0; }
      else { $icon = 'rank-03-e1'; $player_rank = 'Private'; $kills_needed = 20; $percent = 100; }
      $progress = number_format((1 - $percent) * 100) . '%';
      return array($player_rank, $kills_needed, $progress, $icon);
    }

    private function getGameParams($value)
    {
        return ($this->_offline ? '' : $this->_params[$value]);
    }

    private function gameType()
    {
        $out = '';
        if ($this->_offline === false) {
            if ($this->_params['g_gametype'] == 0 || $this->_params['g_gametype'] == 2) $out = "Free For All";
            elseif ($this->_params['g_gametype'] == 1) $out = "Last Man Standing";
            elseif ($this->_params['g_gametype'] == 3) $out = "Team Death Match";
            elseif ($this->_params['g_gametype'] == 4) $out = "Team Survivor";
            elseif ($this->_params['g_gametype'] == 5) $out = "Follow The Leader";
            elseif ($this->_params['g_gametype'] == 6) $out = "Capture And Hold";
            elseif ($this->_params['g_gametype'] == 7) $out = "Capture The Flag";
            elseif ($this->_params['g_gametype'] == 8) $out = "Bomb & Defuse";
            elseif ($this->_params['g_gametype'] == 9) $out = "Jump";
            elseif ($this->_params['g_gametype'] == 10) $out = "Freeze Tag";
            elseif ($this->_params['g_gametype'] == 11) $out = "Gun Game";
        }
        return $out;
    }

    private function onlinePlayers($players, $maxvalue)
    {
        $count = count($players);
        if ($count > 0) 
        {
          $online_players = '<ul>';
          for ($i = 0; $i < $count; $i++) {
              $online_players .= '<li>[' . ($i+1) . '] ' . $this->prettyName($players[$i]['name']) . '</li>';
          }
          $online_players .= '</ul>';
        }
        else $online_players = 'Server is empty - no players online';
        if ($count == 0) $out = '<span class="label label-primary label-as-badge">0</span> / ' . $maxvalue;
        elseif ($count >= $maxvalue) $out = '<span class="label label-danger label-as-badge cursor-pointer" data-toggle="popover" title="Online Players" data-content="' . $online_players . '" data-html="true" data-placement="left" data-trigger="hover">' . $count . '</span> / ' . $maxvalue;
        else $out = '<span class="label label-success label-as-badge cursor-default" data-toggle="popover" title="Online Players" data-content="' . $online_players . '" data-html="true" data-placement="left" data-trigger="hover">' . $count . '</span> / '. $maxvalue;
        return $out;
    }

    public function renderDashboard()
    {
        $out = '';
        try {
            $this->queryServer();
        } catch (Exception $ex) {
            $out .= '<div class="alert alert-danger"><strong>Error!</strong> ' . $ex->getMessage() . '</div>';
        }
        $totalkills = $this->dbQuery('SELECT sum(kills) as sum FROM `xlrstats`;');
        $unique = $this->dbQuery('SELECT COUNT(*) as count FROM `player`;');
        $publicslots = (int)$this->getGameParams('sv_maxclients') - (int)$this->getGameParams('sv_privateclients');
        $players = $this->_players;
        $out .= '
        <div class="well well-sm text-center">
          <h1>' . $this->prettyName($this->getGameParams('sv_hostname')) . '</h1>
          <p class="small">' . $this->getGameParams('g_modversion') . '</p>
        </div>
        <div class="row small">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-globe fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>SERVER IP</strong><br/>' . $this->_host . ':' . $this->_port . '</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-map-marker fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>CURRENT MAP</strong><br/>' . $this->getGameParams('mapname') . '</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-users fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>PLAYERS</strong><br/>' . $this->onlinePlayers($players, $publicslots) . '</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-user fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>TOTAL UNIQUE PLAYERS</strong><br/>' . $this->numMajorZero($unique[0]) . '</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-dot-circle-o fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>KILLED</strong><br/>' . $this->numMajorZero($totalkills[0]) . '</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-xs-2"><i class="fa fa-trophy fa-3x"></i></div>
                <div class="col-xs-10 text-right"><strong>GAMETYPE</strong><br/>' . $this->gameType() . '</div>
              </div>
            </div>
          </div>
        </div>

        <div class="online-players">
          <h3>Online players</h3>
          <table class="table table-hover">
            <thead>
            <tr>
              <th>RANK</th><th>NAME</th><th>SCORE</th><th>PING</th>
            </tr>
            </thead>
            <tbody>';
        usort($players, function($b, $a) {
            return $a['score'] - $b['score'];
        });
        $total = count($players);
        if ($total > 0) {
            $last_connect = date('Y-m-d H:i:s', (time() - 7200));
            for ($i = 0; $i < $total; $i++) {
                $rank = $i + 1;
                $prettyname = $this->prettyName($players[$i]['name']);
                $query = $this->dbQuery('SELECT id FROM `xlrstats` WHERE name = ? AND last_played > ?;', array($prettyname, $last_connect));
                $out .= ($query[0] ? '<tr><td>' . $rank . '</td><td><a href="./?view=player-stats&id=' . $query[0] . '">' . $prettyname . '</a></td><td>' . $players[$i]['score'] . '</td>' : '<tr><td>' . $rank . '</td><td>' . $prettyname . '</td><td>' . $players[$i]['score'] . '</td>');
                $out .= ($players[$i]['ping'] == 999 ? '<td>Connecting...</td></tr>' : '<td>' . $players[$i]['ping'] . '</td></tr>');
            }
        }
        else $out .= '<tr><td></td><td>SERVER IS EMPTY - NO PLAYERS ONLINE</td><td></td><td></td></tr>';
        $out .= '</tbody>
          </table>
        </div>';
        return $out;
    }

    private function renderAllPlayerOverview()
    {
        $league = (isset($_GET['league']) ? htmlspecialchars($_GET['league'], ENT_QUOTES, 'UTF-8') : "all");
        $last_played = date('Y-m-d H:i:s', (time() - 12960000));
        $missing = date('Y-m-d H:i:s', (time() - 2678400));
        $most_rounds = array("","",0);
        $most_kills = array("","",0);
        $best_ratio = array("","",0);
        $highest_streak = array("","",0);

        if ($league == "admin") {
            $table_foot_text = 'You need at least the Admin Level 40 to appear on this list.';
            $result = $this->dbQuery('SELECT * FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC;', array($last_played), true);
            $last_seen = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY last_played DESC LIMIT 5;', array($last_played), true);
            $mia = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) AND last_played < ? ORDER BY last_played DESC LIMIT 5;', array($last_played, $missing), true);
            $most_kills = $this->dbQuery('SELECT id,name,kills FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC LIMIT 1;', array($last_played));
            $best_ratio = $this->dbQuery('SELECT id,name,ratio FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY ratio DESC LIMIT 1;', array($last_played));
            $highest_streak = $this->dbQuery('SELECT id,name,max_kill_streak FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY max_kill_streak DESC LIMIT 1;', array($last_played));
            $most_rounds = $this->dbQuery('SELECT id,name,rounds FROM `xlrstats` WHERE admin_role >= 40 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY rounds DESC LIMIT 1;', array($last_played));
        }
        elseif ($league == "newby") {
            $table_foot_text = 'Showing players with 0 to 20 connections.';
            $result = $this->dbQuery('SELECT * FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC;', array($last_played), true);
            $last_seen = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY last_played DESC LIMIT 5;', array($last_played), true);
            $mia = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) AND last_played < ? ORDER BY last_played DESC LIMIT 5;', array($last_played, $missing), true);
            $most_kills = $this->dbQuery('SELECT id,name,kills FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC LIMIT 1;', array($last_played));
            $best_ratio = $this->dbQuery('SELECT id,name,ratio FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY ratio DESC LIMIT 1;', array($last_played));
            $highest_streak = $this->dbQuery('SELECT id,name,max_kill_streak FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY max_kill_streak DESC LIMIT 1;', array($last_played));
            $most_rounds = $this->dbQuery('SELECT id,name,rounds FROM `xlrstats` WHERE num_played <= 20 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY rounds DESC LIMIT 1;', array($last_played));
        }
        elseif ($league == "veteran") {
            $table_foot_text = 'Showing players with at least 200 connections.';
            $result = $this->dbQuery('SELECT * FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC;', array($last_played), true);
            $last_seen = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY last_played DESC LIMIT 5;', array($last_played), true);
            $mia = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) AND last_played < ? ORDER BY last_played DESC LIMIT 5;', array($last_played, $missing), true);
            $most_kills = $this->dbQuery('SELECT id,name,kills FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC LIMIT 1;', array($last_played));
            $best_ratio = $this->dbQuery('SELECT id,name,ratio FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY ratio DESC LIMIT 1;', array($last_played));
            $highest_streak = $this->dbQuery('SELECT id,name,max_kill_streak FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY max_kill_streak DESC LIMIT 1;', array($last_played));
            $most_rounds = $this->dbQuery('SELECT id,name,rounds FROM `xlrstats` WHERE num_played > 200 AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY rounds DESC LIMIT 1;', array($last_played));
        }
        else {
            $table_foot_text = 'You need at least 15 rounds or 300 kills to appear on this list.';
            $result = $this->dbQuery('SELECT * FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC;', array($last_played), true);
            $last_seen = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY last_played DESC LIMIT 5;', array($last_played), true);
            $mia = $this->dbQuery('SELECT id,name,last_played FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) AND last_played < ? ORDER BY last_played DESC LIMIT 5;', array($last_played, $missing), true);
            $most_kills = $this->dbQuery('SELECT id,name,kills FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY kills DESC LIMIT 1;', array($last_played));
            $best_ratio = $this->dbQuery('SELECT id,name,ratio FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY ratio DESC LIMIT 1;', array($last_played));
            $highest_streak = $this->dbQuery('SELECT id,name,max_kill_streak FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY max_kill_streak DESC LIMIT 1;', array($last_played));
            $most_rounds = $this->dbQuery('SELECT id,name,rounds FROM `xlrstats` WHERE (rounds > 15 OR kills > 300) AND last_played > ? AND guid NOT IN (SELECT guid FROM `ban_list`) ORDER BY rounds DESC LIMIT 1;', array($last_played));
        }
        $out ='
      <div class="page-header">
        <h1>Player Statistics</h1>
      </div>
      <ul class="nav nav-pills">
        <li role="presentation" ' . (($league == "all") ? "class='active'>" : ">") . '<a href="?view=player-stats&league=all">All Players</a></li>
        <li role="presentation" ' . (($league == "admin") ? "class='active'>" : ">") . '<a href="?view=player-stats&league=admin">Admin Leaderboard</a></li>
        <li role="presentation" ' . (($league == "newby") ? "class='active'>" : ">") . '<a href="?view=player-stats&league=newby">Newby Leaderboard</a></li>
        <li role="presentation" ' . (($league == "veteran") ? "class='active'>" : ">") . '<a href="?view=player-stats&league=veteran">Veteran Leaderboard</a></li>
      </ul>
      <div class="row">
        <div class="col-md-10">
          <table id="playerstats" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>Pos</th>
            <th>Name</th>
            <th>Skill</th>
            <th>Ratio</th>
            <th>Kills / Deaths (Suicides)</th>
            <th>Team Kills / Deaths</th>
            <th>Rounds / Connections</th>
            <th>Win Streak</th>
          </tr>
          </thead>
          <tbody>';
        $rank = 0;
        $highest_skill = 300;
        $highest_skill_id = "";
        $highest_skill_name = "";
        $best_efficiency = 0;
        $best_efficiency_id = "";
        $best_efficiency_name = "";

        if (is_array($result) || is_object($result)) {
        foreach($result as $row)
        {
          $prettyname = $this->prettyName($row['name']);
          $skill = $this->skillCalculation($row);
          $rankarray = $this->getRank($row['kills']);
          $icon = "fa-user-o";
          if ($row['admin_role'] > 20) $icon = "fa-user-circle";
          elseif ($row['admin_role'] == 2) $icon = "fa-user";
          elseif ($row['admin_role'] == 20) $icon = "fa-user-circle-o";
          if ($skill > $highest_skill) { $highest_skill = $skill; $highest_skill_name = $prettyname; $highest_skill_id = $row['id']; }
          if ($row['rounds'] > 0) { $efficiency = $row['kills'] / $row['rounds']; } else { $efficiency = 0; }
          if ($efficiency > $best_efficiency) { $best_efficiency = $efficiency; $best_efficiency_name = $prettyname; $best_efficiency_id = $row['id']; }
          $rank++;
          $out .= '
          <tr>
            <td>' . $rank . '</td>
            <td><i class="cursor-default fa fa-fw ' . $icon . '" data-toggle="tooltip" data-placement="top" title="' . $this->getRoleName($row['admin_role']) . '"></i> <i class="cursor-default rank rank-fw rank-stack ' . $rankarray[3] . '" data-toggle="tooltip" data-placement="top" title="' . $rankarray[0] . '"></i> <a href="?view=player-stats&id=' . $row['id'] . '">' . $prettyname . '</a></td>
            <td>' . $skill . '</td>
            <td>' . $row['ratio'] . '</td>
            <td>' . $row['kills'] . ' / ' . $row['deaths'] . ' (' . $row['suicides'] . ')</td>
            <td>' . $row['team_kills'] . ' / ' . $row['team_death'] . '</td>
            <td>' . $row['rounds'] . ' / ' . $row['num_played'] . '</td>
            <td>' . $row['max_kill_streak'] . '</td>
          </tr>';
        }
        $out .= '
          </tbody>
          <tfoot>
            <tr class="active">
              <td colspan="8">Click client name to see details.<span class="pull-right">' . $table_foot_text . ' </span></td>
            </tr>
          </tfoot>
          </table>
        </div>
        <div class="col-md-2">
          <div class="row side-tables">
            <div class="col-md-12 col-xs-6">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <th class="lead">Last Seen</th>
              </tr>
              </thead>
              <tbody>';

            foreach($last_seen as $row)
            {
              $out .= '
              <tr>
                <td><a href="?view=player-stats&id=' . $row['id'] . '" data-toggle="tooltip" data-placement="top" title="' . date_format(date_create($row['last_played']), 'F jS, Y G:i') . '">' . $this->prettyName($row['name']) . '</a></td>
              </tr>';
            }
            $out .= '
              </tbody>
              <tfoot>
                <tr class="active">
                  <td class="small">The 5 last seen players.</td>
                </tr>
              </tfoot>
            </table>
            </div>
            <div class="col-md-12 col-xs-6">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <th class="lead">M.I.A.</th>
              </tr>
              </thead>
              <tbody>';

            $now = date('Y-m-d H:i:s', time());
            foreach($mia as $row)
            {
              $out .= '
              <tr>
                <td><a href="?view=player-stats&id=' . $row['id'] . '" data-toggle="tooltip" data-placement="top" title="' . date_diff(date_create($now), date_create($row['last_played']))->format('%r%a days') . '">' . $this->prettyName($row['name']) . '</a></td>
              </tr>';
            }
            $out .= '
              </tbody>
              <tfoot>
                <tr class="active">
                  <td class="small">These players have been missing for more than 30 days.</td>
                </tr>
              </tfoot>
            </table>
            </div>
          </div>
        </div>
      </div>';

        $out .= '
      <hr>
        <div>
          <div class="row text-center small">
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Skill<br/>Award</h3>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $highest_skill_id . '">' . $highest_skill_name . '</a></strong><br/><small>Best skill: ' . $highest_skill . '</small>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Kills<br/>Award</h3>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $most_kills[0] . '">' . $this->prettyName($most_kills[1]) . '</a></strong><br/><small>Most kills: ' . $most_kills[2] . '</small>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Ratio<br/>Award</h3>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $best_ratio[0] . '">' . $this->prettyName($best_ratio[1]) . '</a></strong><br/><small>Best Ratio: ' . $best_ratio[2] . '</small>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">Winstreak<br/>Award</h4>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $highest_streak[0] . '">' . $this->prettyName($highest_streak[1]) . '</a></strong><br/><small>Highest streak: ' . $highest_streak[2] . '</small>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Rounds<br/>Award</h3>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $most_rounds[0] . '">' . $this->prettyName($most_rounds[1]) . '</a></strong><br/><small>Most rounds played: ' . $most_rounds[2] . '</small>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">Efficiency<br/>Award</h4>
                </div>
                <div class="panel-body">
                  <i class="fa fa-trophy fa-3x fa-border"></i>
                </div>
                <div class="panel-footer">
                  <strong><a href="?view=player-stats&id=' . $best_efficiency_id . '">' . $best_efficiency_name . '</a></strong><br/><small>Most kills per round: ' . number_format($best_efficiency) . '</small>
                </div>
              </div>
            </div>
          </div>
        </div>';
        return $out;
    }
    else
        {
           $out .= '
          </tbody>
          </table>
        </div>
      </div>';
        return $out;
        }
    }

    private function numMajorZero($val)
    {
        if ($val > 0) { return number_format((int)$val, 0, '', '.'); } else { return 0; }
    }

    private function trophyCalculation($kills)
    {
        // 120 modulo 50 = 20      121 - (121 modulo 100) / 100 = 1
        $pins = ($kills - ($kills % 25)) / 25;
        $stars = ($kills - ($kills % 100)) / 100;
        $trophy = ($kills - ($kills % 500)) / 500;
        $progress = number_format((($kills - ($trophy * 500)) / 500) * 100). '%';
        return array($pins, $stars, $trophy, $progress);
    }

    private function skillCalculation($result)
    {
        $bonus = 0;
        if ($result['kills'] > 1000 && $result['kills'] <= 20000) $bonus += $result['kills'] / 200;
        if ($result['kills'] > 20000) $bonus += 150;
        if ($result['kills'] < 300) $bonus -= 500 - $result['kills'];
        if ($result['rounds'] > 100 && $result['rounds'] <= 3000) $bonus += $result['rounds'] / 50;
        if ($result['rounds'] > 3000) $bonus += 80;
        if ($result['rounds'] < 30) $bonus -= 201 - $result['rounds'];
        if ($result['ratio'] > 1.6 && $result['ratio'] <= 5.0 ) $bonus += $result['ratio'] * 15;
        if ($result['ratio'] > 5.0) $bonus += 100;
        if ($result['ratio'] < 0.7) $bonus -= $result['ratio'] * 30;
        return ($result['kills'] == 0 ? 300 : round((((($result['kills'] - $result['team_kills'] - $result['suicides'])/($result['rounds'])/20*0.75) + ((($result['kills'] - $result['team_kills'])/($result['deaths'] + $result['suicides'] - $result['team_death']))/5*0.75) + ($result['headshots']/($result['rounds'])/10*0.5) + ($result['max_kill_streak']/30*0.5)) * 216) + 1000 + $bonus));
    }

    private function renderPlayerDetailStats($player_id)
    {
        $geo = geoip_open('./lib/GeoIP.dat',GEOIP_STANDARD);
        $result = $this->dbQuery('SELECT * FROM `xlrstats` WHERE id = ?;', array($player_id));
        $prettyname = $this->prettyName($result['name']);
        $rankarray = $this->getRank($result['kills']);
        $trophyarray = $this->trophyCalculation($result['kills']);
        $guid = $result['guid'];
        $player_detail = $this->dbQuery('SELECT id,aliases FROM `player` WHERE guid = ?;', array($guid));
        $aliaslist = $this->prettyName($player_detail['aliases']);
        $today = date('Y-m-d H:i:s', time());
        $ban_count = $this->dbQuery('SELECT COUNT(*) as count FROM `ban_list` WHERE guid = ? AND expires > ?;', array($guid, $today));
        $out = '
      <div class="page-header">
        <div>
          <i class="fa fa-user fa-4x fa-border fa-pull-left" data-toggle="tooltip" data-placement="bottom" title="Player ID: ' . $player_detail['id'] . ' | Stats ID: ' . $result['id'] . '"></i>
          <h2>' . $prettyname . '
          <small class="flag-icon flag-icon-' . strtolower(geoip_country_code_by_addr($geo, $result['ip_address'])) . '" data-toggle="tooltip" data-placement="right" title="' . geoip_country_name_by_addr($geo, $result['ip_address']) . '"></small></h2>
          <p>' . ($ban_count[0] > 0 ? '<span class="label label-as-badge label-danger">Player is banned</span>' : '<strong>' . $this->getRoleName($result['admin_role']) . '</strong>' . ($result['last_played'] < date('Y-m-d H:i:s', (time() - 2678400)) ? ' <span class="label label-as-badge label-danger cursor-default" data-toggle="tooltip" data-placement="right" title="Last game: ' . date_diff(date_create($today), date_create($result['last_played']))->format('%a days ago') . '">Missing In Action</span>' : '')) . '</p>
          <p class="small">Registered on ' . date_format(date_create($result['first_seen']), 'F jS, Y G:i A') . '<span class="pull-right">Last seen: ' . date_format(date_create($result['last_played']), 'F jS, G:i') . '</span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-line-chart"></i> Rank
                </div>
                <div class="card-body text-center">
                    <h4><i style="vertical-align: middle;" class="rank rank-3x rank-lg ' . $rankarray[3] . '"></i> ' . $rankarray[0] . '</h4>
                    <p>Progress: ' . $rankarray[2] . ' | Kills needed: ' . $rankarray[1] . '</p>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped active" style="width: ' . $rankarray[2] . '"></div>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-md-8">
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-trophy"></i> Achievements
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <h4><i class="fa fa-trophy fa-3x"></i> ' . $trophyarray[2] . ' trophies</h4>
                      <h5><i class="fa fa-star"></i> ' . $trophyarray[1] . ' stars &nbsp;&nbsp;&nbsp;<i class="fa fa-thumb-tack"></i> ' . $trophyarray[0] . ' pins</h5>
                    </div>
                    <div class="col-sm-8">
                      <p>'. $result['kills'] . ' total kills made.</p><p>' . $trophyarray[3] . ' progress to the next main trophy.</p>
                      <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: ' . $trophyarray[3] . '"></div>
                      </div>
                      <p><small>Info: You receive a pin for every 25 kills, a star for every 100 kills and a trophy per 500 kills.</small></p>
                    </div>
                  </div>
                </div>
             </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-pie-chart"></i> Score
                </div>
                <div class="card-body text-center">
                    <div class="row">
                      <div class="col-sm-4">
                          <div class="list-group">
                            <div class="list-group-item list-group-item-info">
                              <h3 class="list-group-item-heading">' . $this->skillCalculation($result) . '</h3>
                            </div>
                            <div class="list-group-item">
                             <p class="list-group-item-text lead">Skill</p>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="list-group">
                          <div class="list-group-item active">
                            <h3 class="list-group-item-heading">' . $result['kills'] . '</h3>
                          </div>
                          <div class="list-group-item">
                           <p class="list-group-item-text lead">Kills</p>
                          </div>
                      </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="list-group">
                          <div class="list-group-item list-group-item-' . ($result['ratio'] < 1.0 ? 'danger' : 'success') . '">
                            <h3 class="list-group-item-heading">' . $result['ratio'] . '</h3>
                          </div>
                          <div class="list-group-item">
                           <p class="list-group-item-text lead">K/D Ratio</p>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
             </div>
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-history"></i> Activity
                </div>
                <div class="card-body">
                  <div>' . $prettyname . ' connected ' . $result['num_played'] . ' times and was last seen playing on ' . $result['last_played'] . '</div>
                </div>
             </div>
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-list-alt"></i> Known Aliases
                </div>
                <div class="card-body">
                    ' . $aliaslist . '
                </div>
             </div>
        </div>
        <div class="col-sm-4">
             <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-bar-chart"></i> Statistics
                </div>
                <div class="card-body">
                    <p>Kills<kbd class="pull-right">' . number_format($result['kills']) . '</kbd></p>
                    <p>Deaths<kbd class="pull-right">' . number_format($result['deaths']) . '</kbd></p>
                    <p>Headshots<kbd class="pull-right">' . number_format($result['headshots']) . '</kbd></p>
                    <p>Skill<kbd class="pull-right">' . number_format($this->skillCalculation($result)) . '</kbd></p>
                    <p>Kill / Death Ratio<kbd class="pull-right">' . $result['ratio'] . '</kbd></p>
                    <p>Team Kills<kbd class="pull-right">' . number_format($result['team_kills']) . '</kbd></p>
                    <p>Team Deaths<kbd class="pull-right">' . number_format($result['team_death']) . '</kbd></p>
                    <p>Suicides<kbd class="pull-right">' . number_format($result['suicides']) . '</kbd></p>
                    <p>Win Streaks<kbd class="pull-right">' . number_format($result['max_kill_streak']) . '</kbd></p>
                    <p>Rounds<kbd class="pull-right">' . number_format($result['rounds']) . '</kbd></p>
                    <p>Connections<kbd class="pull-right">' . number_format($result['num_played']) . '</kbd></p>
                </div>
             </div>
        </div>
      </div>';
        geoip_close($geo);
        return $out;
    }

    public function renderPlayerStats()
    {
        return (isset($_GET['id']) ? $this->renderPlayerDetailStats(htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8')) : $this->renderAllPlayerOverview());
    }

    public function renderBanlist()
    {
        $out = '
      <div class="page-header">
        <h1>Banlist</h1>
      </div>
      <p>If you are on this list, you will not be able reconnect until the temporary ban has expired, or never if the ban is permanent.</p>
      <table id="banlist" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>Info</th>
        <th>ID</th>
        <th>Client</th>
        <th>Added</th>
        <th>Expires</th>
        <th>Reason</th>
      </tr>
      </thead>
      <tbody>';
        $result = $this->dbQuery('SELECT * FROM `ban_list` ORDER BY timestamp DESC;', array(), true);
        if (is_array($result) || is_object($result)) {
            foreach($result as $row)
            {
                $prettyname = $this->prettyName($row['name']);
                $expiration = $row['expires'];
                $type = "TempBan";
                $duration = $this->timeDiff($row['timestamp'], $row['expires']) . ' seconds';
                $exp_format = date_format(date_create($row['expires']), 'F jS, Y G:i A');
                if ((strtotime($expiration) - strtotime($row['timestamp'])) >= 630720000) { $expiration = "<span class='label label-danger'>never</span>"; $type = "PermBan"; $duration = 'permanent'; $exp_format = 'never'; }
                list ($reason, $admin) = array_pad(explode((", ban by " ?: ", autokick"), $row['reason']), 2, null);
                $rdic = array('tk' => 'stop team killing!', 'wh' => 'wallhack', 'wallhack' => 'wallhack', 'aim' => 'aimbot', 'aimbot' => 'aimbot', 'sk' => 'stop spawn killing!', 'tempban' => 'temporary ban');
                if (in_array($reason, $rdic)) { $retval = $rdic[$reason]; $keyword = $reason; } else { $retval = $reason; $keyword = 'None'; }
                $ban_details = '<p>Penalty issued to <strong>' . $row['name'] . '</strong></br>on ' . date_format(date_create($row['timestamp']), 'F jS, Y G:i A') . '</p>
                <ul>
                  <li>Ban ID: ' . $row['id'] . '</li>
                  <li>Type: ' . $type . '</li>
                  <li>Reason: ' . $retval . '</li>
                  <li>Duration: ' . $duration . '</li>
                  <li>Admin: ' . ($admin ?: 'Bot') . '</li>
                  <li>Keyword: ' . $keyword . '</li>
                  <li>Expiration: ' . $exp_format . '</li>
                </ul>';
                $out .= '
                <tr>
                  <td class="text-center"><a tabindex="0" data-toggle="popover" title="Ban Details" data-content="' . $ban_details . '" data-html="true" data-placement="right" data-trigger="focus"><i class="fa fa-info-circle cursor-pointer"></i></a></td>
                  <td>' . $row['id'] . '</td>
                  <td>' . $prettyname . '</td>
                  <td>' . $row['timestamp'] . '</td>
                  <td>' . $expiration . '</td>
                  <td>' . htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8') . '</td>
                </tr>';
            }
        }
        $out .= '
      </tbody>
      </table>';
        return $out;
    }

    public function timeDiff($firstTime,$lastTime)
    {
      // convert to unix timestamps
      $firstTime=strtotime($firstTime);
      $lastTime=strtotime($lastTime);
      // perform subtraction to get the difference (in seconds) between times
      $timeDiff=$lastTime-$firstTime;
      return $timeDiff;
    }

    public function renderStaff()
    {
        $out = '
      <div class="page-header">
        <h1>Staff</h1>
      </div>
      <div>
        <h3>Admins</h3>
        <ul>';
        $result = $this->dbQuery('SELECT id,name FROM `xlrstats` WHERE admin_role > 20 ORDER BY admin_role DESC, name DESC;', array(), true);
        if (is_array($result) || is_object($result)) {
            foreach($result as $row)
            {
                $prettyname = $this->prettyName($row['name']);
                $out .= '<li><a href="./?view=player-stats&id=' . $row['id'] . '">' . $prettyname . '</a></li>';
            }
        }
        $out .= '
        </ul>';
        $mout = '
        <h3>Moderators</h3>
        <ul>';
        $result = $this->dbQuery('SELECT id,name FROM `xlrstats` WHERE admin_role = 20 ORDER BY name DESC;', array(), true);
        $mod_count = 0;
        if (is_array($result) || is_object($result)) {
            foreach($result as $row)
            {
                $prettyname = $this->prettyName($row['name']);
                $mout .= '<li><a href="./?view=player-stats&id=' . $row['id'] . '">' . $prettyname . '</a></li>';
                $mod_count++;
            }
        }
        $mout .= '
        </ul>';
        if ($mod_count > 0) $out .= $mout;
        $out .= '
      </div>';
        return $out;
    }
}
?>
