
        <div class="page-header">
            <h1>Admin Levels and Bot Commands</h1>
        </div>
        <div>
            <h3>Guest [0]</h3>
            <ul>
                <li><strong>help</strong> - display all available commands
                    <ul>
                        <li>Usage: <code>!help</code></li>
                        <li>Short: <code>!h</code></li>
                    </ul>
                </li>
                <li><strong>forgiveall</strong> - forgive all team kills
                    <ul>
                        <li>Usage: <code>!forgiveall</code></li>
                        <li>Short: <code>!fa</code></li>
                    </ul>
                </li>
                <li><strong>forgiveprev</strong> - forgive last team kill
                    <ul>
                        <li>Usage: <code>!forgiveprev</code></li>
                        <li>Short: <code>!fp</code></li>
                    </ul>
                </li>
                <li><strong>bombstats</strong> - display Bomb mode stats
                    <ul>
                        <li>Usage: <code>!bombstats</code></li>
                    </ul>
                </li>
                <li><strong>ctfstats</strong> - display Capture the Flag stats
                    <ul>
                        <li>Usage: <code>!ctfstats</code></li>
                    </ul>
                </li>
                <li><strong>freezestats</strong> - display freeze/thawout stats
                    <ul>
                        <li>Usage: <code>!freezestats</code></li>
                    </ul>
                </li>
                <li><strong>hestats</strong> - display HE grenade kill stats
                    <ul>
                        <li>Usage: <code>!hestats</code></li>
                    </ul>
                </li>
                <li><strong>hits</strong> - display hit stats
                    <ul>
                        <li>Usage: <code>!hits</code></li>
                    </ul>
                </li>
                <li><strong>hs</strong> - display headshot counter
                    <ul>
                        <li>Usage: <code>!hs</code></li>
                    </ul>
                </li>
                <li><strong>knife</strong> - display knife kill stats
                    <ul>
                        <li>Usage: <code>!knife</code></li>
                    </ul>
                </li>
                <li><strong>register</strong> - register yourself as a basic user
                    <ul>
                        <li>Usage: <code>!register</code></li>
                    </ul>
                </li>
                <li><strong>spree</strong> - display current kill streak
                    <ul>
                        <li>Usage: <code>!spree</code></li>
                    </ul>
                </li>
                <li><strong>stats</strong> - display current map stats
                    <ul>
                        <li>Usage: <code>!stats</code></li>
                    </ul>
                </li>
                <li><strong>teams</strong> - balance teams
                    <ul>
                        <li>Usage: <code>!teams</code></li>
                    </ul>
                </li>
                <li><strong>time</strong> - display the current server time
                    <ul>
                        <li>Usage: <code>!time</code></li>
                    </ul>
                </li>
            </ul>
            <h3>User [1]</h3>
            <ul>
                <li><strong>regtest</strong> - display current user status
                    <ul>
                        <li>Usage: <code>!regtest</code></li>
                    </ul>
                </li>
                <li><strong>xlrstats</strong> - display full player statistics
                    <ul>
                        <li>Usage: <code>!xlrstats [&lt;name|id&gt;]</code></li>
                    </ul>
                </li>
                <li><strong>xlrtopstats</strong> - display the top players
                    <ul>
                        <li>Usage: <code>!xlrtopstats</code></li>
                        <li>Short: <code>!topstats</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Moderator [20]</h3>
            <ul>
                <li><strong>admintest</strong> - display current admin status
                    <ul>
                        <li>Usage: <code>!admintest</code></li>
                    </ul>
                </li>
                <li><strong>country</strong> - get the country of a player
                    <ul>
                        <li>Usage: <code>!country &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>lastmaps</strong> - list the last played maps
                    <ul>
                        <li>Usage: <code>!lastmaps</code></li>
                    </ul>
                </li>
                <li><strong>leveltest</strong> - get the admin level for a given player or myself
                    <ul>
                        <li>Usage: <code>!leveltest [&lt;name|id&gt;]</code></li>
                        <li>Short: <code>!lt [&lt;name|id&gt;]</code></li>
                    </ul>
                </li>
                <li><strong>list</strong> - list all connected players
                    <ul>
                        <li>Usage: <code>!list</code></li>
                    </ul>
                </li>
                <li><strong>locate</strong> - display geolocation info of a player
                    <ul>
                        <li>Usage: <code>!locate &lt;name|id&gt;</code></li>
                        <li>Short: <code>!lc &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>nextmap</strong> - display the next map in rotation
                    <ul>
                        <li>Usage: <code>!nextmap</code></li>
                    </ul>
                </li>
                <li><strong>mute</strong> - mute or unmute a player
                    <ul>
                        <li>Usage: <code>!mute &lt;name|id&gt; [&lt;seconds&gt;]</code></li>
                    </ul>
                </li>
                <li><strong>poke</strong> - notify a player that he needs to move
                    <ul>
                        <li>Usage: <code>!poke &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>seen</strong> - display when a player was last seen
                    <ul>
                        <li>Usage: <code>!seen &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>shuffleteams</strong> - shuffle the teams
                    <ul>
                        <li>Usage: <code>!shuffleteams</code></li>
                        <li>Short: <code>!shuffle</code></li>
                    </ul>
                </li>
                <li><strong>spec</strong> - move yourself to spectator
                    <ul>
                        <li>Usage: <code>!spec</code></li>
                    </ul>
                </li>
                <li><strong>warn</strong> - warn user
                    <ul>
                        <li>Usage: <code>!warn &lt;name|id&gt; [&lt;reason&gt;]</code></li>
                        <li>Short: <code>!w &lt;name|id&gt; [&lt;reason&gt;]</code></li>
                        <li>Available short form reasons: <em>tk</em>, <em>obj</em>, <em>spec</em>, <em>ping</em>, <em>spam</em>, <em>camp</em>, <em>lang</em>, <em>racism</em>, <em>name</em>, <em>skill</em>, <em>whiner</em></li>
                    </ul>
                </li>
                <li><strong>warninfo</strong> - display how many warnings a player has
                    <ul>
                        <li>Usage: <code>!warninfo &lt;name|id&gt;</code></li>
                        <li>Short: <code>!wi &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>warnremove</strong> - remove a users last warning
                    <ul>
                        <li>Usage: <code>!warnremove &lt;name|id&gt;</code></li>
                        <li>Short: <code>!wr &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>warns</strong> - list the warnings
                    <ul>
                        <li>Usage: <code>!warns</code></li>
                    </ul>
                </li>
                <li><strong>warntest</strong> - test a warning
                    <ul>
                        <li>Usage: <code>!warntest &lt;warning&gt;</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Admin [40]</h3>
            <ul>
                <li><strong>admins</strong> - list all the online admins
                    <ul>
                        <li>Usage: <code>!admins</code></li>
                    </ul>
                </li>
                <li><strong>afk</strong> - force a player to spec, because he is away from keyboard
                    <ul>
                        <li>Usage: <code>!afk &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>aliases</strong> - list the aliases of a player
                    <ul>
                        <li>Usage: <code>!aliases &lt;name|id&gt;</code></li>
                        <li>Short: <code>!alias &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>bigtext</strong> - display big message on screen
                    <ul>
                        <li>Usage: <code>!bigtext &lt;text&gt;</code></li>
                    </ul>
                </li>
                <li><strong>exit</strong> - display last disconnected player
                    <ul>
                        <li>Usage: <code>!exit</code></li>
                    </ul>
                </li>
                <li><strong>find</strong> - display the slot number of a player
                    <ul>
                        <li>Usage: <code>!find &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>force</strong> - force a player to the given team or release the player from a forced team (free)
                    <ul>
                        <li>Usage: <code>!force &lt;name|id&gt; &lt;blue/red/spec/free&gt; [&lt;lock&gt;]</code></li>
                        <li>Adding <code>lock</code> will lock the player where it is forced to.</li>
                    </ul>
                </li>
                <li><strong>kick</strong> - kick a player
                    <ul>
                        <li>Usage: <code>!kick &lt;name|id&gt; &lt;reason&gt;</code></li>
                        <li>Short: <code>!k &lt;name|id&gt; &lt;reason&gt;</code></li>
                    </ul>
                </li>
                <li><strong>nuke</strong> - nuke a player
                    <ul>
                        <li>Usage: <code>!nuke &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>say</strong> - say a message to all players (allow spectator to say a message to players in-game)
                    <ul>
                        <li>Usage: <code>!say &lt;text&gt;</code></li>
                        <li>Short: <code>!!&lt;text&gt;</code></li>
                    </ul>
                </li>
                <li><strong>tell</strong> - tell a message to a specific player
                    <ul>
                        <li>Usage: <code>!tell &lt;name|id&gt; &lt;text&gt;</code></li>
                    </ul>
                </li>
                <li><strong>tempban</strong> - ban a player temporary for the given period (1 min to 24 hrs)
                    <ul>
                        <li>Usage: <code>!tempban &lt;name|id&gt; &lt;duration&gt; [&lt;reason&gt;]</code></li>
                        <li>Short: <code>!tb &lt;name|id&gt; &lt;duration&gt; [&lt;reason&gt;]</code></li>
                        <li>Max ban duration: 24 hours</li>
                    </ul>
                </li>
                <li><strong>warnclear</strong> - clear the user warnings
                    <ul>
                        <li>Usage: <code>!warnclear &lt;name|id&gt;</code></li>
                        <li>Short: <code>!wc &lt;name|id&gt;</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Full Admin [60]</h3>
            <ul>
                <li><strong>ban</strong> - ban a player for 7 days
                    <ul>
                        <li>Usage: <code>!ban &lt;name|id&gt; &lt;reason&gt;</code></li>
                        <li>Short: <code>!b &lt;name|id&gt; &lt;reason&gt;</code></li>
                    </ul>
                </li>
                <li><strong>baninfo</strong> - display active bans of a player
                    <ul>
                        <li>Usage: <code>!baninfo &lt;name|id&gt;</code></li>
                        <li>Short: <code>!bi &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>ci</strong> - kick player with connection interrupt
                    <ul>
                        <li>Usage: <code>!ci &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>id</strong> - show the IP, guid and authname of a player
                    <ul>
                        <li>Usage: <code>!id &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>kickbots</strong> kick all bots
                    <ul>
                        <li>Usage: <code>!kickbots</code></li>
                        <li>Short: <code>!kb</code></li>
                    </ul>
                </li>
                <li><strong>rain</strong> - enables or disables rain
                    <ul>
                        <li>Usage: <code>!rain &lt;on/off&gt;</code></li>
                    </ul>
                </li>
                <li><strong>scream</strong> - scream a message in different colors to all players
                    <ul>
                        <li>Usage: <code>!scream &lt;text&gt;</code></li>
                    </ul>
                </li>
                <li><strong>slap</strong> - slap a player (a number of times)
                    <ul>
                        <li>Usage: <code>!slap &lt;name|id&gt; [&lt;amount&gt;]</code></li>
                        <li>Default amount: 1</li>
                        <li>Max amount: 15</li>
                    </ul>
                </li>
                <li><strong>status</strong> - report the status of the bot
                    <ul>
                        <li>Usage: <code>!status</code></li>
                    </ul>
                </li>
                <li><strong>swap</strong> - swap teams for player A and B (if in different teams)
                    <ul>
                        <li>Usage: <code>!swap &lt;playerA&gt; &lt;playerB&gt;</code></li>
                    </ul>
                </li>
                <li><strong>version</strong> - display the version of the bot
                    <ul>
                        <li>Usage: <code>!version</code></li>
                    </ul>
                </li>
                <li><strong>veto</strong> - stop voting process
                    <ul>
                        <li>Usage: <code>!veto</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Senior Admin [80]</h3>
            <ul>
                <li><strong>addbots</strong> - add bots to the game
                    <ul>
                        <li>Usage: <code>!addbots</code></li>
                    </ul>
                </li>
                <li><strong>banlist</strong> - display the last active 10 bans
                    <ul>
                        <li>Usage: <code>!banlist</code></li>
                    </ul>
                </li>
                <li><strong>bots</strong> - enables or disables bot support
                    <ul>
                        <li>Usage: <code>!bots &lt;on/off&gt;</code></li>
                    </ul>
                </li>
                <li><strong>cyclemap</strong> - cycle to the next map
                    <ul>
                        <li>Usage: <code>!cyclemap</code></li>
                    </ul>
                </li>
                <li><strong>exec</strong> - execute given config file
                    <ul>
                        <li>Usage: <code>!exec &lt;filename&gt;</code></li>
                    </ul>
                </li>
                <li><strong>instagib</strong> - set Instagib mode
                    <ul>
                        <li>Usage: <code>!instagib &lt;on/off&gt;</code></li>
                    </ul>
                </li>
                <li><strong>kickall</strong> - kick all players matching pattern
                    <ul>
                        <li>Usage: <code>!kickall &lt;pattern&gt; [&lt;reason&gt;]</code></li>
                        <li>Short: <code>!kall</code></li>
                    </ul>
                </li>
                <li><strong>kiss</strong> - clear all player warnings
                    <ul>
                        <li>Usage: <code>!kiss</code></li>
                        <li>Short: <code>!clear</code></li>
                    </ul>
                </li>
                <li><strong>kill</strong> - kill a player
                    <ul>
                        <li>Usage: <code>!kill &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>lastbans</strong> - list the last 4 bans
                    <ul>
                        <li>Usage: <code>!lastbans</code></li>
                        <li>Short: <code>!bans</code></li>
                    </ul>
                </li>
                <li><strong>lookup</strong> - search for player in the database
                    <ul>
                        <li>Usage: <code>!lookup &lt;name|id&gt;</code></li>
                        <li>Short: <code>!l &lt;name|id&gt;</code></li>
                    </ul>
                </li>
                <li><strong>makereg</strong> - make a player a regular (Level 2) user
                    <ul>
                        <li>Usage: <code>!makereg &lt;name|id&gt;</code></li>
                        <li>Short: <code>!mr &lt;name&gt;</code></li>
                    </ul>
                </li>
                <li><strong>map</strong> - load given map
                    <ul>
                        <li>Usage: <code>!map &lt;ut4_name&gt;</code></li>
                    </ul>
                </li>
                <li><strong>maps</strong> - display all available maps
                    <ul>
                        <li>Usage: `!maps</li>
                    </ul>
                </li>
                <li><strong>maprestart</strong> - restart the map
                    <ul>
                        <li>Usage: <code>!maprestart</code></li>
                        <li>Short: <code>!restart</code></li>
                    </ul>
                </li>
                <li><strong>moon</strong> - activate Moon mode (low gravity)
                    <ul>
                        <li>Usage: <code>!moon &lt;on/off&gt;</code></li>
                    </ul>
                </li>
                <li><strong>permban</strong> - ban a player permanent
                    <ul>
                        <li>Usage: <code>!permban &lt;name|id&gt; &lt;reason&gt;</code></li>
                        <li>Short: <code>!pb &lt;name|id&gt; &lt;reason&gt;</code></li>
                    </ul>
                </li>
                <li><strong>putgroup</strong> - add a client to a group
                    <ul>
                        <li>Usage: <code>!putgroup &lt;name|id&gt; &lt;group&gt;</code></li>
                        <li>Available Groups: <em>user</em>, <em>regular</em>, <em>mod</em>, <em>admin</em>, <em>fulladmin</em></li>
                    </ul>
                </li>
                <li><strong>setnextmap</strong> - set the next map
                    <ul>
                        <li>Usage: <code>!setnextmap &lt;ut4_name&gt;</code></li>
                    </ul>
                </li>
                <li><strong>swapteams</strong> - swap the current teams
                    <ul>
                        <li>Usage: <code>!swapteams</code></li>
                    </ul>
                </li>
                <li><strong>unban</strong> - unban a player from the database
                    <ul>
                        <li>Usage: <code>!unban &lt;ID&gt;</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Super Admin [90]</h3>
            <ul>
                <li><strong>password</strong> - set private server password
                    <ul>
                        <li>Usage: <code>!password [&lt;password&gt;]</code></li>
                        <li>Set an empty string to remove a password</li>
                    </ul>
                </li>
                <li><strong>putgroup</strong> - add a client to a group
                    <ul>
                        <li>Usage: <code>!putgroup &lt;name|id&gt; &lt;group&gt;</code></li>
                        <li>Available Groups: <em>user</em>, <em>regular</em>, <em>mod</em>, <em>admin</em>, <em>fulladmin</em>, <em>senioradmin</em></li>
                    </ul>
                </li>
                <li><strong>reload</strong> - reload map
                    <ul>
                        <li>Usage: <code>!reload</code></li>
                    </ul>
                </li>
                <li><strong>ungroup</strong> - remove admin level from a player
                    <ul>
                        <li>Usage: <code>!ungroup &lt;name|id&gt;</code></li>
                    </ul>
                </li>
            </ul>
            <h3>Head Admin [100]</h3>
            <ul>
                <li><strong>putgroup</strong> - add a client to a group
                    <ul>
                        <li>Usage: <code>!putgroup &lt;name|id&gt; &lt;group&gt;</code></li>
                        <li>Available Groups: <em>user</em>, <em>regular</em>, <em>mod</em>, <em>admin</em>, <em>fulladmin</em>, <em>senioradmin</em>, <em>superadmin</em></li>
                    </ul>
                </li>
            </ul>
        </div>
