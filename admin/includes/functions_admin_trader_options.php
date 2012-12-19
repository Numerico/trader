<?php
/** 
* WP-Trader Main Admin Functions. 
* @package WP-Trader 
* @subpackage Administration 
**/	
function donate_header(){
	?>
	<div data-role="collapsible" data-collapsed="false" data-theme="a">
		<h3>Donate</h3>
		<div data-role="fieldcontain">
			If you like this plugin then please consider donating to me. All donations are welcome thanks.
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input name="cmd" type="hidden" value="_donations" />
				<input name="business" type="hidden" value="youtor2008@gmail.com" />
				<input name="item_name" type="hidden" value="Tsocialmedia" />
				<input name="no_shipping" type="hidden" value="0" />
				<input name="no_note" type="hidden" value="1" />
				<input name="tax" type="hidden" value="0" />
				<input name="lc" type="hidden" value="GB" />
				<input name="bn" type="hidden" value="PP-DonationsBF" />
				<div class="ui-grid-a">
				<div class="ui-block-a">
					<select name="currency_code" size="1">
						<option value="GBP">GB pound</option>
						<option value="USD">US dollar</option>
						<option value="EUR">Euro</option>
						<option value="JPY">Yen</option>
						<option value="CAD">Canadian $</option>
						<option value="AUD">Australian $</option>
					</select>
				</div>
				<div class="ui-block-b">
					<label for="amount"><b>Amount</b></label>
					<input name="amount" size="10" type="text" value="" />
				</div>
				</div>
				<p class="paypal" align="center">
					<input data-role="none" alt="PayPal - The safer, easier way to pay online!" border="0" name="submit" src="https://www.paypal.com/en_US/AT/i/btn/btn_donateCC_LG.gif" type="image" /> <img alt="" border="0" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" />
				</p>
				
			</form>
		</div>
	</div>
<?php
}
function wptrader_header() {
	global $wptrader_main_menu, $wptrader_main, $wptrader_main_options, $wptrader_torrent_options, $wptrader_widgets_options, $wptrader_peers_list, $wptrader_free_leech_list;
	$screen_wptrader_header = get_current_screen();
		if ($screen_wptrader_header->id == $wptrader_main_menu){
			$wptrader_page_title = esc_attr("WP-Trader Main Menu");
		}elseif ($screen_wptrader_header->id == $wptrader_main){
			$wptrader_page_title = esc_attr("WP-Trader Main Menu");
		}elseif ($screen_wptrader_header->id == $wptrader_main_options){
			$wptrader_page_title = esc_attr("WP-Trader Main Options");
		}elseif ($screen_wptrader_header->id == $wptrader_torrent_options){
			$wptrader_page_title = esc_attr("WP-Trader Torrent Options");
		}elseif ($screen_wptrader_header->id == $wptrader_widgets_options){
			$wptrader_page_title = esc_attr("WP-Trader Options Widgets");
		}elseif ($screen_wptrader_header->id == $wptrader_peers_list){
			$wptrader_page_title = esc_attr("WP-Trader Peers List");
		}elseif ($screen_wptrader_header->id == $wptrader_free_leech_list){
			$wptrader_page_title = esc_attr("WP-Trader Free Leech List");
		}
	?>
	<div data-role="header" data-position="inline">
		<h1><? echo $wptrader_page_title; ?></h1>
		<a data-transition="pop" data-rel="dialog" data-inline="true" data-role="button" href="<?php echo 'http://www.wp-trader.tsocialmedia.com/wp-admin/admin.php?page=wptrader-help'; ?>" class="ui-btn-right" data-icon="info">Help</a>
	</div>
	<?php
}
function wptrader_update($errorheader, $errormessage) {
	$return_update = new WP_Error('broke', __("<strong><font color='red'>".$errorheader."</font></strong><br /> ".$errormessage."<br /><br />"));
	echo "<div id='message' class='updated'><center>".$return_update->get_error_message()."</center></div>";
}
function wptrader_missing_announce() {
	$source = get_stylesheet_directory() . '/announce.php';
	if (!file_exists($source)){
		?>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Missing Announce</h3>
			<div data-role="fieldcontain">
				Sorry but the announce.php is missing from your current theme folder.<br />
				If you see this error again please move the file from the WP-Trader plugin folder to your theme folder which is located in the<br />
				<?php echo get_stylesheet_directory(); ?> folder.<br />
				The scrape file can be located at the<br />
				/wp-content/plugins/wp-trader/template folder.<br /><br />
				<form action='<?php echo $_SERVER['REQUEST_URI']; ?>' method='post'><?php echo wp_nonce_field('wptrader-missing-announce'); ?>
					<p class="move_announce">
						<button type="submit" name="move_announce" data-role="button" data-theme="b"><?php esc_attr_e( 'Please Click To Move Announce' ) ?></button>
					</p>
				</form>
			</div>
		</div>
		<?php
	}
}
function wptrader_missing_scrape() {
	$scrape_source = get_stylesheet_directory() . '/scrape.php';
	if (!file_exists($scrape_source)){
		?>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Missing Scrape</h3>
			<div data-role="fieldcontain">
				Sorry but the scrape.php is missing from your current theme folder.<br />
				If you see this error again please move the file from the WP-Trader plugin folder to your theme folder which is located in the<br />
				<?php echo get_stylesheet_directory(); ?> folder.<br />
				The scrape file can be located at the<br />
				/wp-content/plugins/wp-trader/template folder.<br /><br />
				<form action='<?php echo $_SERVER['REQUEST_URI']; ?>' method='post'><?php echo wp_nonce_field('wptrader-missing-scrape'); ?>
					<p class="move_scrape">
						<button type="submit" name="move_scrape" data-role="button" data-theme="b"><?php esc_attr_e( 'Please Click To Move Scrape' ) ?></button>
					</p>
				</form>
			</div>
		</div>
		<?php
	}
}
function wptrader_do_cleanup() {
	?>
	<div data-role="collapsible" data-collapsed="true" data-theme="a">
		<h3>Cleanup</h3>
		<div data-role="fieldcontain">
			<form action='<?php echo $_SERVER['REQUEST_URI']; ?>' method='post'><?php echo wp_nonce_field('wptrader-do-cleanup'); ?>
				<p class="do_cleanup">
					<button type="submit" name="do_cleanup" data-role="button" data-theme="b"><?php esc_attr_e( 'Please Click Do Cleanup' ) ?></button>
				</p>
			</form>
		</div>
	</div>
	<?php
}
function mksize($a_bytes) {
	if ($a_bytes < 1024) {
		return $a_bytes .' B';
	} elseif ($a_bytes < 1048576) {
		return round($a_bytes / 1024, 2) .' kB';
	} elseif ($a_bytes < 1073741824) {
		return round($a_bytes / 1048576, 2) . ' MB';
	} elseif ($a_bytes < 1099511627776) {
		return round($a_bytes / 1073741824, 2) . ' GB';
	} elseif ($a_bytes < 1125899906842624) {
		return round($a_bytes / 1099511627776, 2) .' TB';
	} elseif ($a_bytes < 1152921504606846976) {	
		return round($a_bytes / 1125899906842624, 2) .' PB';
	} elseif ($a_bytes < 1180591620717411303424) {
		return round($a_bytes / 1152921504606846976, 2) .' EB';
	} elseif ($a_bytes < 1208925819614629174706176) {
		return round($a_bytes / 1180591620717411303424, 2) .' ZB';
	} else {
		return round($a_bytes / 1208925819614629174706176, 2) .' YB';
	}	
}
function CutName ($vTxt, $Car) {
	if (strlen($vTxt) > $Car) {	
		return substr($vTxt, 0, $Car) . "...";
	}
	return $vTxt;
}	
function get_row_count($table, $suffix = "") {
	$res = mysql_query("SELECT COUNT(*) FROM $table $suffix");
	$row = mysql_fetch_row($res);
	return $row[0];
}
function wptrader_submit() {
	?>
	<p class="submit_wp_trader">
				<button type="submit" name="submit" data-role="button" data-theme="b"><?php esc_attr_e( 'Save Changes' ) ?></button>
	</p>
	<?php
}
function wptrader_footer() {
	global $wp_trader_plugin_version, $wp_trader_plugin_author;
	?>
	<div data-role="footer"><h4>* Sponsored by <a href="http://www.admin-hosting.com/securex/aff.php?aff=042" target="_blank">Admin Hosting</a><br /><br /><?php echo 'WP-Trader&nbsp;&nbsp;' .$wp_trader_plugin_version. '&nbsp;&nbsp;Brought To You By&nbsp;&nbsp;' .$wp_trader_plugin_author; ?></h4><center>* The sponsored by link is an affiliate link.</center></div>
	<?php
}
function wptrader_help_file($option, $table){
	switch ($option){
		case mains:
									switch ($table){				case mainsms:				
					$settings .= "<span>Most settings are already set default but may need some fine tuning for your needs.</span><br /><br />";								break;								case mainsiy:				
					$settings .= "<span>If you see an error about the announce.php or scrape.php please click the button to move it to the theme folder. If it cannot be moved then please locat it in the /wp-content/plugins/wp-trader/templates/ and move it to your current theme folder.</span><br /><br />";				break;								case mainsym:
					$settings .= "<span>You must update your permalinks to use either \"Month and name\" option or \"Day and name\" option or \"Custom Structure\" or if your using Wordpress 3.3 and above you can use the \"Post name\" option just as long as you have /%postname%/ at the end of the url in order for the announce and scrape to work. Make sure that the post which is made for the announce and scrape keep the names they have because of the limitations of the bittorrent protocol.</span><br /><br />";				break;								case mainsiyh:
					$settings .= "<span>If you have any questions please check the <a href='http://wordpress.org/extend/plugins/wp-trader/faq/' target='_blank'>F.A.Q.</a>.</span><br /><br />";								break;				break;								case mainsatm:
					$settings .= "<span>At the moment until a css option is added for the wordpress editor in torrent upload the editor will only show up correctly on light color themes, so if it does not show correctly then please disable it on the settings page.</span><br /><br />";								break;								case mainsa:					return wptrader_help_file('mains', 'mainsms').wptrader_help_file('mains', 'mainsiy').wptrader_help_file('mains', 'mainsym').wptrader_help_file('mains', 'mainsiyh').wptrader_help_file('mains', 'mainsatm');				break;			}			
			
			return $settings;
		break;
		case mfaq:
			$faq .= "<dl>";						switch ($table){				case mfaqwwp:				
					$faq .= "<dt><b>Will WP-Trader work with a 'standard' WordPress theme?</b></dt>";
					$faq .= "<dd>Yes, the plugin has been tested on a few themes to see if there is any problems so I would not see why it would not work on any standard theme.</dd>";								break;								case mfaqciu:				
					$faq .= "<dt><b>Can I use WP-Trader on an existing WordPress Blog?</b></dt>";
					$faq .= "<dd>Yes</dd>";				break;								case mfaqdwp:				
				$faq .= "<dt><b>Does WP-Trader use any shortcodes?</b></dt>";
				$faq .= "<dd>Yes you can find the list of shortcode by click on \"Shortcodes\" on the left hand side.</dd>";				break;								case mfaqa:					return wptrader_help_file('mfaq', 'mfaqwwp').wptrader_help_file('mfaq', 'mfaqciu').wptrader_help_file('mfaq', 'mfaqdwp');				break;			}
				$faq .= "</dl>";			
			return $faq;
		break;
		case msc:
			$shortcodes .= "<dl>";						switch ($table){				case mscmat:
					$shortcodes .= "<dt><b>Most Active Torrents</b></dt>";
					$shortcodes .= "<dd>[most_active mostactive=\"most_active_template\"] [/most_active]</dd>";								break;								case msclu:				
					$shortcodes .= "<dt><b>Latest Uploads</b></dt>";
					$shortcodes .= "<dd>[latest_uploaded_torrents latestuploads=\"latest_uploads_template\"] [/latest_uploaded_torrents]</dd>";								break;								case mscsw:
					$shortcodes .= "<dt><b>Seed Wanted</b></dt>";
					$shortcodes .= "<dd>[seed_wanted_torrents seedwanted=\"seed_wanted_template\"] [/seed_wanted_torrents]</dd>";								break;								case msctb:				
					$shortcodes .= "<dt><b>Torrent Browse</b></dt>";
					$shortcodes .= "<dd>[torrentbrowse torrent=\"torrent_browse\"] [/torrentbrowse]</dd>";				break;				case msctu:
					$shortcodes .= "<dt><b>Torrent Upload</b></dt>";
					$shortcodes .= "<dd>[torrentupload torrent_up=\"upload\"] [/torrentupload]</dd>";								break;								case mscta:
					$shortcodes .= "<dt><b>Torrent Announce</b></dt>";
					$shortcodes .= "<dd>[torrent_announce announce=\"announce_template\"] [/torrent_announce]</dd>";								break;								case mscts:
					$shortcodes .= "<dt><b>Torrent Scrape</b></dt>";
					$shortcodes .= "<dd>[torrent_scrape scrape=\"scrape_template\"] [/torrent_scrape]</dd>";								break;								case mscdb:				
					$shortcodes .= "<dt><b>Download Box Of Torrent Post (Needs ID Of Torrent)</b></dt>";
					$shortcodes .= "<dd>[torrentdescription torrent_descr=\"download-box\" torrent_post_id=\"torrent id goes here\"] [/torrentdescription]</dd>";								break;				case mscdp:
					$shortcodes .= "<dt><b>Description Part Which Consist Of Tabbed Data (Needs ID Of Torrent Post)</b></dt>";
					$shortcodes .= "<dd>[torrentdescription torrent_descr=\"container\" torrent_post_id=\"torrent post id goes here\"] [/torrentdescription]</dd>";								break;								case msca:					return wptrader_help_file('msc', 'mscmat').wptrader_help_file('msc', 'msclu').wptrader_help_file('msc', 'mscsw').wptrader_help_file('msc', 'msctb').wptrader_help_file('msc', 'msctu').wptrader_help_file('msc', 'mscta').wptrader_help_file('msc', 'mscts').wptrader_help_file('msc', 'mscdb').wptrader_help_file('msc', 'mscdp');				break;			}
			$shortcodes .= "</dl>";
			return $shortcodes;
		break;
		case skd:
			$skd .= "<dl>";
			switch ($table){
				case skda:
					$skd .= "<dt><b>Keep All Settings</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep settings when plugin is disabled or deleted. If you choose no then you will lose all your torrent posts, admin settings, pages for the plugin and anything else which deals with this plugin.</span></dd>";
				break;
				case skdt:
					$skd .= "<dt><b>Keep All Databank Tables</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep all database tables created by the plugin when the plugin is disabled or deleted. If you choose no then you will lose all your torrents, peers, torrent languages, torrents completed for the plugin and any other tables added by the plugin.</span></dd>";
				break;
				case skdap:
					$skd .= "<dt><b>Keep All Pages</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep all pages created by the plugin when the plugin is disabled or deleted. If you choose no then you will lose the torrent browse page, announce page and torrent upload page also if the option no is chosen then the announce url will change but you should be able to change the new link to the old link by editing the page.</span></dd>";
				break;
				case skdui:
					$skd .= "<dt><b>Keep All User Info</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep all user's info created by the plugin when the plugin is disabled or deleted. If you choose no then you will lose the passkey, secret and a few other things for each user.</span></dd>";
				break;
				case skdus:
					$skd .= "<dt><b>Keep System User</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep the system user created by the plugin when the plugin is disabled or deleted. If you choose no then the system user will be deleted and all torrents with uploaded anon will probably be changed to reflect the admin as the uploader.</span></dd>";
				break;
				case skdp:
					$skd .= "<dt><b>Keep Posts</b></dt>";
					$skd .= "<dd><span class=\"description\">Keep all posts created by the plugin when the plugin is disabled or deleted. If you choose no then you will lose all your torrent posts, torrent comments for the plugin and anything else created by the plugin for the posts.</span></dd>";
				break;
				case skde:
					return wptrader_help_file('skd', 'skda').wptrader_help_file('skd', 'skdt').wptrader_help_file('skd', 'skdap').wptrader_help_file('skd', 'skdui').wptrader_help_file('skd', 'skdus').wptrader_help_file('skd', 'skdp');
				break;
			}
			$skd .= "</dl>";
			return $skd;
		break;
		case susers:
			$susers .= "<dl>";
			switch ($table){
				case susersmo:
					$susers .= "<dt><b>Members Only</b></dt>";
					$susers .= "<dd><span class=\"description\">If set to yes users will have to be signed in to use some features.</span></dd>";
				break;
				case susersmoe:
					$susers .= "<dt><b>Members Only Page Exclude</b></dt>";
					$susers .= "<dd><span class=\"description\">Pages which should be excluded from the members only. By excluding a page here then guest will be able to see that page. The announce and scrape page should always be excluded.</span></dd>";
				break;
				case susersmow:
					$susers .= "<dt><b>Members Only Wait</b></dt>";
					$susers .= "<dd><span class=\"description\">Enable wait times for bad ratio for members only.</span></dd>";
				break;
				case susersma:
					return wptrader_help_file('susers', 'susersmo').wptrader_help_file('susers', 'susersmoe').wptrader_help_file('susers', 'susersmow');
				break;
			}
			$susers .= "</dl>";
			return $susers;
		break;
		case sca:
			$sca .= "<dl>";
			switch ($table){
				case scapl:
					$sca .= "<dt><b>Peer Limit</b></dt>";
					$sca .= "<dd><span class=\"description\">Limit number of peers given in each announce.</span></dd>";
				break;
				case scaai:
					$sca .= "<dt><b>Autoclean Interval</b></dt>";
					$sca .= "<dd><span class=\"description\">How often to do each auto cleanup.</span></dd>";
				break;
				case scalc:
					$sca .= "<dt><b>Log Clean</b></dt>";
					$sca .= "<dd><span class=\"description\">How often to delete old entries. (Default: 28 days).</span></dd>";
				break;
				case scai:
					$sca .= "<dt><b>Announce Interval</b></dt>";
					$sca .= "<dd><span class=\"description\">Announce Interval (Seconds).</span></dd>";
				break;
				case scad:
					$sca .= "<dt><b>Max Dead Torrent Time</b></dt>";
					$sca .= "<dd><span class=\"description\">Time until torrents that are dead are set invisible (Seconds).</span></dd>";
				break;
				case scaa:
					return wptrader_help_file('sca', 'scapl').wptrader_help_file('sca', 'scaai').wptrader_help_file('sca', 'scalc').wptrader_help_file('sca', 'scai').wptrader_help_file('sca', 'scad');
				break;
			}
			$sca .= "</dl>";
			return $sca;
		break;
		case saw:
			$saw .= "<dl>";
			switch ($table){
				case sawre:
					$saw .= "<dt><b>Ratio Warning Enable</b></dt>";
					$saw .= "<dd><span class=\"description\">Enable/Disable auto ratio warning.</span></dd>";
				break;
				case sawrmr:
					$saw .= "<dt><b>Ratio Warning Min Ratio</b></dt>";
					$saw .= "<dd><span class=\"description\">Min Ratio before user is warned.</span></dd>";
				break;
				case sawrmg:
					$saw .= "<dt><b>Ratio Warning Min Gigs</b></dt>";
					$saw .= "<dd><span class=\"description\">Min GB Downloaded before user is warned.</span></dd>";
				break;
				case sawrd:
					$saw .= "<dt><b>Ratio Warning # Of Days</b></dt>";
					$saw .= "<dd><span class=\"description\">Number of days to warn member before they are banned.</span></dd>";
				break;
				case sawall:
					return wptrader_help_file('saw', 'sawre').wptrader_help_file('saw', 'sawrmr').wptrader_help_file('saw', 'sawrmg').wptrader_help_file('saw', 'sawrd');
				break;
			}
			$saw .= "</dl>";
			return $saw;
		break;
		case std:
			$std .= "<dl>";
			switch ($table){
				case stdu:
					$std .= "<dt><b>Torrent Upload Directory</b></dt>";
					$std .= "<dd><span class=\"description\">Torrent upload directory.</span></dd>";
				break;
				case stdi:
					$std .= "<dt><b>Image Upload Directory</b></dt>";
					$std .= "<dd><span class=\"description\">Image upload directory.</span></dd>";
				break;
				case stdn:
					$std .= "<dt><b>NFO Upload Directory</b></dt>";
					$std .= "<dd><span class=\"description\">NFO upload directory.</span></dd>";
				break;
				case stda:
					return wptrader_help_file('std', 'stdu').wptrader_help_file('std', 'stdi').wptrader_help_file('std', 'stdn');
			}
			$std .= "</dl>";
			return $std;
		break;
		case ste:
				$ste .= "<dl>";
				switch ($table){
					case steu:
						$ste .= "<dt><b>Use Wordpress Editor</b></dt>";
						$ste .= "<dd><span class=\"description\">Use the default torrent descriptions editor or the wordpress editor.</span></dd>";
					break;
					case stec:
						$ste .= "<dt><b>Css For Wordpress Editor</b></dt>";
						$ste .= "<dd><span class=\"description\">Add your own css for the Wordpress Editor used in the torrent upload page. Note: If using a dark theme which does not support the wordpress editor then it is best to use your own css file.</span></dd>";
					break;
					case stea:
						return wptrader_help_file('ste', 'steu').wptrader_help_file('ste', 'stec');
					break;
				}
				$ste .= "</dl>";
				return $ste;
		break;
		case st:
			$st .= "<dl>";
			switch ($table){
				case stip:
					$st .= "<dt><b>IP/Passkey Tracking</b></dt>";
					$st .= "<dd><span class=\"description\">Use IP or Passkey to track torrents. To use passkey then the plugin must be set to members only.</span></dd>";
				break;
				case stugp:
					$st .= "<dt><b>User Generate Passkey</b></dt>";
					$st .= "<dd><span class=\"description\">Allow user to generate passkey on their profile.</span></dd>";
				break;
				case stwsb:
					$st .= "<dt><b>Enable Seed Bonus</b></dt>";
					$st .= "<dd><span class=\"description\">Allow user to collect seed bonus for seeding torrents.</span></dd>";
				break;
				case stb:
					$st .= "<dt><b>Torrent Browse Page</b></dt>";
					$st .= "<dd><span class=\"description\">Use torrent browse page. By clicking no the torrent browse page will be deleted but your torrents will stay intact. If you decide to use the torrent browse page again just choose yes and it will be created again.</span></dd>";
				break;
				case ste:
					$st .= "<dt><b>Allow External</b></dt>";
					$st .= "<dd><span class=\"description\">Enable uploading of external tracked torrents.</span></dd>";
				break;
				case stun:
					$st .= "<dt><b>Allow NFO Upload</b></dt>";
					$st .= "<dd><span class=\"description\">Enable uploading of NFOs. If disabled NFO tab will not show up in description.</span></dd>";
				break;
				case stdn:
					$st .= "<dt><b>NFO Display PNG</b></dt>";
					$st .= "<dd><span class=\"description\">Display nfo as png format. (Option only shows if GD is installed)</span></dd>";
				break;
				case stpl:
					$st .= "<dt><b>Show Peers List</b></dt>";
					$st .= "<dd><span class=\"description\">Show peer list in torrent description. If disabled peer list tab will not show up in description.</span></dd>";
				break;
				case stfl:
					$st .= "<dt><b>Show Files List</b></dt>";
					$st .= "<dd><span class=\"description\">Show file list in torrent description. If disabled file list tab will not show up in description.</span></dd>";
				break;
				case stuo:
					$st .= "<dt><b>Uploaders Only</b></dt>";
					$st .= "<dd><span class=\"description\">Limit uploading to uploader group only.</span></dd>";
				break;
				case stuoc:
					$st .= "<dt><b>Uploader Only Classes</b></dt>";
					$st .= "<dd><span class=\"description\">The classes to limit uploaders only to.</span></dd>";
				break;
				case stau:
					$st .= "<dt><b>Anonymous Upload</b></dt>";
					$st .= "<dd><span class=\"description\">Enable / Disable anonymous uploads.</span></dd>";
				break;
				case stpu:
					$st .= "<dt><b>Passkey Url</b></dt>";
					$st .= "<dd><span class=\"description\">Announce URL to use for passkey.</span></dd>";
				break;
				case sts:
					$st .= "<dt><b>Upload Scrape</b></dt>";
					$st .= "<dd><span class=\"description\">Scrape external torrents on upload?</span></dd>";
				break;
				case stsf:
					$st .= "<dt><b>Upload Scrape Force</b></dt>";
					$st .= "<dd><span class=\"description\">Force scrape on upload it takes away the option for the uploader to choose.</span></dd>";
				break;
				case stur:
					$st .= "<dt><b>Upload Rules</b></dt>";
					$st .= "<dd><span class=\"description\">Rules people must follow to upload on your site.</span></dd>";
				break;
				case sta:
					return wptrader_help_file('st', 'stip').wptrader_help_file('st', 'stugp').wptrader_help_file('st', 'stb').wptrader_help_file('st', 'ste').wptrader_help_file('st', 'stun').wptrader_help_file('st', 'stdn').wptrader_help_file('st', 'stpl').wptrader_help_file('st', 'stfl').wptrader_help_file('st', 'stuo').wptrader_help_file('st', 'stuoc').wptrader_help_file('st', 'stau').wptrader_help_file('st', 'stpu').wptrader_help_file('st', 'sts').wptrader_help_file('st', 'stsf').wptrader_help_file('st', 'stur');
				break;
			}
			$st .= "</dl>";
			return $st;
		break;
		case sa:
			$sa .= "<dl>";
			switch ($table){
				case sal:
					$sa .= "<dt><b>Announce List</b></dt>";
					$sa .= "<dd><span class=\"description\">This the announce listing. To add more than one announce seperate via comma.</span></dd>";
				break;
				case sab:
					$sa .= "<dt><b>Agent Bans</b></dt>";
					$sa .= "<dd><span class=\"description\">Must be agent id, use full id for specific versions. Agent Bans should be sperated by a comma.</span></dd>";
				break;
				case saa:
					return wptrader_help_file('sa', 'sal').wptrader_help_file('sa', 'sab');
				break;
			}
			$sa .= "</dl>";
			return $sa;
		break;
		case stt:
			$stt .= "<dl>";
			switch ($table){
				case stthf:
					$stt .= "<dt><b>Torrent Table Header/Footer</b></dt>";
					$stt .= "<dd><span class=\"description\">Choose to show the header or footer or both on the torrent table.</span></dd>";
				break;
				case sttl:
					$stt .= "<dt><b>Torrent Table Limit</b></dt>";
					$stt .= "<dd><span class=\"description\">How many torrents to show on the torrent browse page.</span></dd>";
				break;
				case stts:
					$stt .= "<dt><b>Torrent Name Shortner</b></dt>";
					$stt .= "<dd><span class=\"description\">Number of letters for the torrent name in the seed torrent table.</span></dd>";
				break;
				case sttc:
					$stt .= "<center><h3><b>Table Columns</b></h3></center>";
					$stt .= "<dt><b>category</b></dt><span class=\"description\"><dd>The category image or name for the torrent.</dd></span>";
					$stt .= "<dt><b>name</b></dt><span class=\"description\"><dd>The torrent name.</dd></span>";
					$stt .= "<dt><b>dl</b></dt><span class=\"description\"><dd>The download link for the torrent, which shows as a download icon.</dd></span>";
					$stt .= "<dt><b>uploader</b></dt><span class=\"description\"><dd>The name of the uploader.</dd></span>";
					$stt .= "<dt><b>comments</b></dt><span class=\"description\"><dd>The number of comments the torrent has.</dd></span>";
					$stt .= "<dt><b>completed</b></dt><span class=\"description\"><dd>The number of times the torrent has been completed.</dd></span>";
					$stt .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$stt .= "<dt><b>seeders</b></dt><span class=\"description\"><dd>The number of seeders the torrent has.</dd></span>";
					$stt .= "<dt><b>leechers</b></dt><span class=\"description\"><dd>The number of leechers the torrent has.</dd></span>";
					$stt .= "<dt><b>health</b></dt><span class=\"description\"><dd>The health of the torrent which is caculated by the number of seeders and leechers.</dd></span>";
					$stt .= "<dt><b>external</b></dt><span class=\"description\"><dd>Shows if the torrent is external or internal.</dd></span>";
					$stt .= "<dt><b>wait</b></dt><span class=\"description\"><dd>Shows the wait times if that option is enabled.</dd></span>";
					$stt .= "<dt><b>rating</b></dt><span class=\"description\"><dd>The rating of the torrent. (a rating system is not in the source yet and this may be removed at a later date)</dd></span>";
					$stt .= "<dt><b>added</b></dt><span class=\"description\"><dd>The date the torrent was uploaded and added to the system.</dd></span>";
					$stt .= "<dt><b>nfo</b></dt><span class=\"description\"><dd>The link to the nfo if one exists.</dd></span>";
				break;
				case stte:
					$stt .= "<center><h3><b>Table Expand</b></h3></center>";
					$stt .= "<dt><b>completed</b></dt><span class=\"description\"><dd>The number of times the torrent has been completed.</dd></span>";
					$stt .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$stt .= "<dt><b>speed</b></dt><span class=\"description\"><dd>Speed for the torrent which is caculated by the seeders and leechers ratio.</dd></span>";
					$stt .= "<dt><b>added</b></dt><span class=\"description\"><dd>The date the torrent was uploaded and added to the system.</dd></span>";
					$stt .= "<dt><b>tracker</b></dt><span class=\"description\"><dd>The tracker announce url.</dd></span>";
				break;
				case sttp:
					$stt .= "<center><h3><b>Torrent Peers List</b></h3></center>";
					$stt .= "<dt><b>port</b></dt><span class=\"description\"><dd>The port number of the peer.</dd></span>";
					$stt .= "<dt><b>uploaded</b></dt><span class=\"description\"><dd>The amount uploaded by the peer.</dd></span>";
					$stt .= "<dt><b>downloaded</b></dt><span class=\"description\"><dd>The amount downloaded by the peer.</dd></span>";
					$stt .= "<dt><b>left</b></dt><span class=\"description\"><dd>The amount left to download for the peer.</dd></span>";
					$stt .= "<dt><b>ready</b></dt><span class=\"description\"><dd>The percentage completed by the peer.</dd></span>";
					$stt .= "<dt><b>seed</b></dt><span class=\"description\"><dd>Yes or no depending on if the peer is seeding or leeching.</dd></span>";
					$stt .= "<dt><b>connected</b></dt><span class=\"description\"><dd>Yes or no depending on if the peer is connected.</dd></span>";
					$stt .= "<dt><b>client</b></dt><span class=\"description\"><dd>The bittorrent client the peer is using.</dd></span>";
					$stt .= "<dt><b>nick</b></dt><span class=\"description\"><dd>The peer's username.</dd></span>";
				break;
				case sttpal:
					$stt .= "<dt><b>Torrent Peers List Admin Limit</b></dt>";
					$stt .= "<dd><span class=\"description\">How many peers to show on the peers list page.</span></dd>";
				break;
				case sttpa:
					$stt .= "<center><h3><b>Torrent Peers List Admin</b></h3></center>";
					$stt .= "<dt><b>user</b></dt><span class=\"description\"><dd>The username of the peer.</dd></span>";
					$stt .= "<dt><b>torrent</b></dt><span class=\"description\"><dd>The name of the torrent.</dd></span>";
					$stt .= "<dt><b>ip</b></dt><span class=\"description\"><dd>The ip address of the peer.</dd></span>";
					$stt .= "<dt><b>port</b></dt><span class=\"description\"><dd>The port number of the peer.</dd></span>";
					$stt .= "<dt><b>uploaded</b></dt><span class=\"description\"><dd>The amount uploaded by the peer.</dd></span>";
					$stt .= "<dt><b>downloaded</b></dt><span class=\"description\"><dd>The amount downloaded by the peer.</dd></span>";
					$stt .= "<dt><b>peer-id</b></dt><span class=\"description\"><dd>The peer id of the peer.</dd></span>";
					$stt .= "<dt><b>connected</b></dt><span class=\"description\"><dd>Yes or no depending on if the peer is connected.</dd></span>";
					$stt .= "<dt><b>seeding</b></dt><span class=\"description\"><dd>Yes or no depending on if the peer is seeding or leeching.</dd></span>";
					$stt .= "<dt><b>started</b></dt><span class=\"description\"><dd>When the peer started downloading.</dd></span>";
					$stt .= "<dt><b>last-action</b></dt><span class=\"description\"><dd>The last time the peer has done something with the torrent.</dd></span>";
				break;
				case sttfal:
					$stt .= "<dt><b>Torrent Free Leech Admin Limit</b></dt>";
					$stt .= "<dd><span class=\"description\">How many torrents to show on the free leech list page.</span></dd>";
				break;
				case sttfa:
					$stt .= "<center><h3><b>Torrent Free Leech Admin</b></h3></center>";
					$stt .= "<dt><b>id</b></dt><span class=\"description\"><dd>The id of the torrent.</dd></span>";
					$stt .= "<dt><b>post_id</b></dt><span class=\"description\"><dd>The post id of the torrent.</dd></span>";
					$stt .= "<dt><b>attachment_id</b></dt><span class=\"description\"><dd>The attachment id of the torrent.</dd></span>";
					$stt .= "<dt><b>info_hash</b></dt><span class=\"description\"><dd>The info hash of the torrent.</dd></span>";
					$stt .= "<dt><b>name</b></dt><span class=\"description\"><dd>The torrent name.</dd></span>";
					$stt .= "<dt><b>filename</b></dt><span class=\"description\"><dd>The filename for the torrent.</dd></span>";
					$stt .= "<dt><b>save_as</b></dt><span class=\"description\"><dd>The filename the torrent is saved as.</dd></span>";
					$stt .= "<dt><b>category</b></dt><span class=\"description\"><dd>The category image or name for the torrent.</dd></span>";
					$stt .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$stt .= "<dt><b>type</b></dt><span class=\"description\"><dd>The type of torrent either multi file or single file.</dd></span>";
					$stt .= "<dt><b>numfiles</b></dt><span class=\"description\"><dd>Number of files the torrent has.</dd></span>";
					$stt .= "<dt><b>banned</b></dt><span class=\"description\"><dd>If the torrent is banned or not.</dd></span>";
					$stt .= "<dt><b>owner</b></dt><span class=\"description\"><dd>Username of who uploaded the torrent.</dd></span>";
					$stt .= "<dt><b>nfo</b></dt><span class=\"description\"><dd>If the torrent has an nfo or not.</dd></span>";
					$stt .= "<dt><b>announce</b></dt><span class=\"description\"><dd>The announce url of the torrent.</dd></span>";
					$stt .= "<dt><b>torrentlang</b></dt><span class=\"description\"><dd>The language of the torrent.</dd></span>";
				break;
				case stta:
					return wptrader_help_file('stt', 'stthf').wptrader_help_file('stt', 'sttl').wptrader_help_file('stt', 'stts').wptrader_help_file('stt', 'sttc').wptrader_help_file('stt', 'stte').wptrader_help_file('stt', 'sttp').wptrader_help_file('stt', 'sttpal').wptrader_help_file('stt', 'sttpa').wptrader_help_file('stt', 'sttfal').wptrader_help_file('stt', 'sttfa');
				break;
			}
			$stt .= "</dl>";
			return $stt;
		break;
		case sfu:
			$sfu .= "<dl>";
				switch ($table){
					case sfuis:
						$sfu .= "<dt><b>Max Image Size</b></dt>";
						$sfu .= "<dd><span class=\"description\">Maximum image size in bytes.</span></dd>";
					break;
					case sfuat:
						$sfu .= "<dt><b>Allowed Image Types</b></dt>";
						$sfu .= "<dd><span class=\"description\">Allowed image types should be sperated by a comma.</span></dd>";
					break;
					case sfunf:
						$sfu .= "<dt><b>NFO Size</b></dt>";
						$sfu .= "<dd><span class=\"description\">NFO size in bytes.</span></dd>";
					break;
					case sfua:
						return wptrader_help_file('sfu', 'sfuis').wptrader_help_file('sfu', 'sfuat').wptrader_help_file('sfu', 'sfunf');
					break;
				}
			$sfu .= "</dl>";
			return $sfu;
		break;
		case sfl:
			$sfl .= "<dl>";
				switch ($table){
					case sflo:
						$sfl .= "<dt><b>On / Off</b></dt>";
						$sfl .= "<dd><span class=\"description\">Turn free leech on and off.</span></dd>";
					break;
					case sfla:
						return wptrader_help_file('sfl', 'sflo');
					break;
				}
			$sfl .= "</dl>";
			return $sfl;
		break;
		case swt:
			$swt .= "<dl>";
				switch ($table){
					case swtcs:
						$swt .= "<dt><b>Wait Classes</b></dt>";
						$swt .= "<dd><span class=\"description\">Classes wait time applies to.</span></dd>";
					break;
					case swtw:
						$swt .= "<dt><b>Min Gigs Needed For ".esc_attr( get_option('minimum_waita') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum gigs user needs to have for no wait time.</span></dd>";
					break;
					case swtr:
						$swt .= "<dt><b>Min Ratio Needed For ".esc_attr( get_option('minimum_waita') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum ratio user needs to have for no wait time.</span></dd>";
					break;
					case swta:
						$swt .= "<dt><b>Minimum Wait Time</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum time a user must wait in hours.</span></dd>";
					break;
					case swtwb:
						$swt .= "<dt><b>Min Gigs Needed For ".esc_attr( get_option('minimum_waitb') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum gigs user needs to have for no wait time.</span></dd>";
					break;
					case swtrb:
						$swt .= "<dt><b>Min Ratio Needed For ".esc_attr( get_option('minimum_waitb') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum ratio user needs to have for no wait time.</span></dd>";
					break;
					case swtb:
						$swt .= "<dt><b>Minimum Wait Time</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum time a user must wait in hours.</span></dd>";
					break;
					case swtwc:
						$swt .= "<dt><b>Min Gigs Needed For ".esc_attr( get_option('minimum_waitc') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum gigs user needs to have for no wait time.</span></dd>";
					break;
					case swtrc:
						$swt .= "<dt><b>Min Ratio Needed For ".esc_attr( get_option('minimum_waitc') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum ratio user needs to have for no wait time.</span></dd>";
					break;
					case swtc:
						$swt .= "<dt><b>Minimum Wait Time</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum time a user must wait in hours.</span></dd>";
					break;
					case swtwd:
						$swt .= "<dt><b>Min Gigs Needed For ".esc_attr( get_option('minimum_waitd') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum gigs user needs to have for no wait time.</span></dd>";
					break;
					case swtrd:
						$swt .= "<dt><b>Min Ratio Needed For ".esc_attr( get_option('minimum_waitd') )."H Wait</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum ratio user needs to have for no wait time.</span></dd>";
					break;
					case swtd:
						$swt .= "<dt><b>Minimum Wait Time</b></dt>";
						$swt .= "<dd><span class=\"description\">Minimum time a user must wait in hours.</span></dd>";
					break;
					case swtal:
						return wptrader_help_file('swt', 'swtcs').wptrader_help_file('swt', 'swtw').wptrader_help_file('swt', 'swtr').wptrader_help_file('swt', 'swta').wptrader_help_file('swt', 'swtwb').wptrader_help_file('swt', 'swtrb').wptrader_help_file('swt', 'swtb').wptrader_help_file('swt', 'swtwc').wptrader_help_file('swt', 'swtrc').wptrader_help_file('swt', 'swtc').wptrader_help_file('swt', 'swtwd').wptrader_help_file('swt', 'swtrd').wptrader_help_file('swt', 'swtd');
					break;
				}
			$swt .= "</dl>";
			return $swt;
		break;
		case sma:
			$sma .= "<dl>";
			switch ($table){
				case smal:
					$sma .= "<dt><b>Most Active Limit</b></dt>";
					$sma .= "<dd><span class=\"description\">How many torrents to show in the most active widget.</span></dd>";
				break;
				case smae:
					$sma .= "<dt><b>Most Active External</b></dt>";
					$sma .= "<dd><span class=\"description\">Show external tracked torrents in the most active widget.</span></dd>";
				break;
				case smas:
					$sma .= "<dt><b>Most Active Name Shortner</b></dt>";
					$sma .= "<dd><span class=\"description\">Number of letters for the torrent name in the most active widget.</span></dd>";
				break;
				case smatt:
					$sma .= "<center><h3><b>Most Active Torrent Table</b></h3></center>";
					$sma .= "<dt><b>category</b></dt><span class=\"description\"><dd>The category image or name for the torrent.</dd></span>";
					$sma .= "<dt><b>name</b></dt><span class=\"description\"><dd>The torrent name.</dd></span>";
					$sma .= "<dt><b>dl</b></dt><span class=\"description\"><dd>The download link for the torrent, which shows as a download icon.</dd></span>";
					$sma .= "<dt><b>uploader</b></dt><span class=\"description\"><dd>The name of the uploader.</dd></span>";
					$sma .= "<dt><b>comments</b></dt><span class=\"description\"><dd>The number of comments the torrent has.</dd></span>";
					$sma .= "<dt><b>completed</b></dt><span class=\"description\"><dd>The number of times the torrent has been completed.</dd></span>";
					$sma .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$sma .= "<dt><b>seeders</b></dt><span class=\"description\"><dd>The number of seeders the torrent has.</dd></span>";
					$sma .= "<dt><b>leechers</b></dt><span class=\"description\"><dd>The number of leechers the torrent has.</dd></span>";
					$sma .= "<dt><b>health</b></dt><span class=\"description\"><dd>The health of the torrent which is caculated by the number of seeders and leechers.</dd></span>";
					$sma .= "<dt><b>external</b></dt><span class=\"description\"><dd>Shows if the torrent is external or internal.</dd></span>";
					$sma .= "<dt><b>wait</b></dt><span class=\"description\"><dd>Shows the wait times if that option is enabled.</dd></span>";
					$sma .= "<dt><b>rating</b></dt><span class=\"description\"><dd>The rating of the torrent. (a rating system is not in the source yet and this may be removed at a later date)</dd></span>";
					$sma .= "<dt><b>added</b></dt><span class=\"description\"><dd>The date the torrent was uploaded and added to the system.</dd></span>";
					$sma .= "<dt><b>nfo</b></dt><span class=\"description\"><dd>The link to the nfo if one exists.</dd></span>";
				break;
				case smaa:
					return wptrader_help_file('sma', 'smal').wptrader_help_file('sma', 'smae').wptrader_help_file('sma', 'smas').wptrader_help_file('sma', 'smatt');
				break;
			}
			$sma .= "</dl>";
			return $sma;
		break;
		case slu:
			$slu .= "<dl>";
			switch ($table){
				case slul:
					$slu .= "<dt><b>Latest Uploaded Limit</b></dt>";
					$slu .= "<dd><span class=\"description\">How many torrents to show in the latest uploaded widget.</span></dd>";
				break;
				case slue:
					$slu .= "<dt><b>Latest Uploaded External</b></dt>";
					$slu .= "<dd><span class=\"description\">Show external tracked torrents in the latest uploaded widget.</span></dd>";
				break;
				case slus:
					$slu .= "<dt><b>Latest Uploaded Name Shortner</b></dt>";
					$slu .= "<dd><span class=\"description\">Number of letters for the torrent name in the latest uploaded widget.</span></dd>";
				break;
				case slut:
					$slu .= "<center><h3><b>Latest Uploaded Torrent Table</b></h3></center>";
					$slu .= "<dt><b>category</b></dt><span class=\"description\"><dd>The category image or name for the torrent.</dd></span>";
					$slu .= "<dt><b>name</b></dt><span class=\"description\"><dd>The torrent name.</dd></span>";
					$slu .= "<dt><b>dl</b></dt><span class=\"description\"><dd>The download link for the torrent, which shows as a download icon.</dd></span>";
					$slu .= "<dt><b>uploader</b></dt><span class=\"description\"><dd>The name of the uploader.</dd></span>";
					$slu .= "<dt><b>comments</b></dt><span class=\"description\"><dd>The number of comments the torrent has.</dd></span>";
					$slu .= "<dt><b>completed</b></dt><span class=\"description\"><dd>The number of times the torrent has been completed.</dd></span>";
					$slu .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$slu .= "<dt><b>seeders</b></dt><span class=\"description\"><dd>The number of seeders the torrent has.</dd></span>";
					$slu .= "<dt><b>leechers</b></dt><span class=\"description\"><dd>The number of leechers the torrent has.</dd></span>";
					$slu .= "<dt><b>health</b></dt><span class=\"description\"><dd>The health of the torrent which is caculated by the number of seeders and leechers.</dd></span>";
					$slu .= "<dt><b>external</b></dt><span class=\"description\"><dd>Shows if the torrent is external or internal.</dd></span>";
					$slu .= "<dt><b>wait</b></dt><span class=\"description\"><dd>Shows the wait times if that option is enabled.</dd></span>";
					$slu .= "<dt><b>rating</b></dt><span class=\"description\"><dd>The rating of the torrent. (a rating system is not in the source yet and this may be removed at a later date)</dd></span>";
					$slu .= "<dt><b>added</b></dt><span class=\"description\"><dd>The date the torrent was uploaded and added to the system.</dd></span>";
					$slu .= "<dt><b>nfo</b></dt><span class=\"description\"><dd>The link to the nfo if one exists.</dd></span>";
				break;
				case sluall:
					return wptrader_help_file('slu', 'slul').wptrader_help_file('slu', 'slue').wptrader_help_file('slu', 'slus').wptrader_help_file('slu', 'slut');
				break;
			}
			$slu .= "</dl>";
			return $slu;
		break;
		case ssw:
			$ssw .= "<dl>";
			switch ($table){
				case sswl:
					$ssw .= "<dt><b>Seed Wanted Limit</b></dt>";
					$ssw .= "<dd><span class=\"description\">How many torrents to show in the seed wanted widget.</span></dd>";
				break;
				case sswe:	
					$ssw .= "<dt><b>Seed Wanted External</b></dt>";
					$ssw .= "<dd><span class=\"description\">Show external tracked torrents in the seed wanted widget.</span></dd>";
				break;
				case ssws:
					$ssw .= "<dt><b>Seed Wanted Name Shortner</b></dt>";
					$ssw .= "<dd><span class=\"description\">Number of letters for the torrent name in the seed wanted widget.</span></dd>";
				break;
				case sswt:
					$ssw .= "<center><h3><b>Seed Wanted Torrent Table</b></h3></center>";
					$ssw .= "<dt><b>category</b></dt><span class=\"description\"><dd>The category image or name for the torrent.</dd></span>";
					$ssw .= "<dt><b>name</b></dt><span class=\"description\"><dd>The torrent name.</dd></span>";
					$ssw .= "<dt><b>dl</b></dt><span class=\"description\"><dd>The download link for the torrent, which shows as a download icon.</dd></span>";
					$ssw .= "<dt><b>uploader</b></dt><span class=\"description\"><dd>The name of the uploader.</dd></span>";
					$ssw .= "<dt><b>comments</b></dt><span class=\"description\"><dd>The number of comments the torrent has.</dd></span>";
					$ssw .= "<dt><b>completed</b></dt><span class=\"description\"><dd>The number of times the torrent has been completed.</dd></span>";
					$ssw .= "<dt><b>size</b></dt><span class=\"description\"><dd>The size of the torrent.</dd></span>";
					$ssw .= "<dt><b>seeders</b></dt><span class=\"description\"><dd>The number of seeders the torrent has.</dd></span>";
					$ssw .= "<dt><b>leechers</b></dt><span class=\"description\"><dd>The number of leechers the torrent has.</dd></span>";
					$ssw .= "<dt><b>health</b></dt><span class=\"description\"><dd>The health of the torrent which is caculated by the number of seeders and leechers.</dd></span>";
					$ssw .= "<dt><b>external</b></dt><span class=\"description\"><dd>Shows if the torrent is external or internal.</dd></span>";
					$ssw .= "<dt><b>wait</b></dt><span class=\"description\"><dd>Shows the wait times if that option is enabled.</dd></span>";
					$ssw .= "<dt><b>rating</b></dt><span class=\"description\"><dd>The rating of the torrent. (a rating system is not in the source yet and this may be removed at a later date)</dd></span>";
					$ssw .= "<dt><b>added</b></dt><span class=\"description\"><dd>The date the torrent was uploaded and added to the system.</dd></span>";
					$ssw .= "<dt><b>nfo</b></dt><span class=\"description\"><dd>The link to the nfo if one exists.</dd></span>";
				break;
				case sswa:
					return wptrader_help_file('ssw', 'sswl').wptrader_help_file('ssw', 'sswe').wptrader_help_file('ssw', 'ssws').wptrader_help_file('ssw', 'sswt');
				break;
			}
			$ssw .= "</dl>";
			return $ssw;
		break;
	}
}
?>