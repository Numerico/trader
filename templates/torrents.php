<?php
/*
  * Holds the Torrent Browse
  * @package WP-Trader
*/
	function torrent_browse_template() {
		include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
		if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
				$errorheader = "Error";
				$errormessage = "Sorry you must be a member to view this page!";
				wptrader_update($errorheader, $errormessage);
		}else{
				?>
				<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
				<?php
				$res = mysql_query("SELECT COUNT(*) FROM " . TRADER_TORRENTS . "") or die(mysql_error());
				$row = mysql_fetch_row($res);
				$count = $row[0];

				if ($count) {
					$columns = get_option('torrenttable_columns');
					$char = get_option('torrent_table_name_shortner');
					$limit = get_option('torrent_table_limit');
					$order = "ORDER BY id DESC";
					$type = "torrent_list";
					return torrent_table_template($columns, $char, $limit, $order, $type);
				}else{
					$errorheader = "Nothing found";
					$errormessage = "No .torrents have been uploaded yet.";
					wptrader_update($errorheader, $errormessage);
				}
			//if ($CURUSER)
				//mysql_query("UPDATE users SET last_browse=".gmtime()." WHERE id=$CURUSER[id]");
		}
	}
?>