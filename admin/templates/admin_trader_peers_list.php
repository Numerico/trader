<?php
/** 
* WP-Trader Peers List Administration Screen. 
* @package WP-Trader 
* @subpackage Administration 
**/
include_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

if (isset($_POST['move_announce'])){
		check_admin_referer('wptrader-missing-announce');
		$source = WP_TRADER_ABSPATH . '/templates/announce.php';
		$destination = get_stylesheet_directory() . '/announce.php';
		if (!file_exists($destination) && file_exists($source)) {
			$data = file_get_contents($source);
			$handle = fopen($destination, "w");
			fwrite($handle, $data);
			fclose($handle);
			$errorheader = "Updated";
			$errormessage = "The announce has been moved.";
			wptrader_update($errorheader, $errormessage);
		}
}elseif (isset($_POST['move_scrape'])){
	check_admin_referer('wptrader-missing-scrape');
	$scrape_source = WP_TRADER_ABSPATH . '/templates/scrape.php';
	$destination_scrape = get_stylesheet_directory() . '/scrape.php';
	if (!file_exists($destination_scrape) && file_exists($scrape_source)) {
		$data_scrape = file_get_contents($scrape_source);
		$handle_scrape = fopen($destination_scrape, "w");
		fwrite($handle_scrape, $data_scrape);
		fclose($handle_scrape);
		$errorheader = "Updated";
		$errormessage = "The scrape has been moved.";
		wptrader_update($errorheader, $errormessage);
	}
}
?>
<div data-role="page" data-theme="d" class="form-table">
	<?php wptrader_header(); ?>
	<div data-role="content">
	<?php
	donate_header();
	wptrader_missing_announce();
	wptrader_missing_scrape();
	?>
	<div data-role="collapsible" data-collapsed="false" data-theme="a">
		<h3>Peers List</h3>
		<div data-role="fieldcontain">
			<?php
			global $current_user, $wpdb;
	
			$torrent_table = "id, torrent, peer_id, ip, port, uploaded, downloaded, to_go, seeder, started, last_action, connectable, client, userid, passkey";
			$current = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
	
			$pag = $wpdb->get_results("SELECT " . $torrent_table ." FROM " . TRADER_PEERS . " ORDER BY started DESC");
	
			$limit = "".get_option('torrent_peers_list_admin_limit')."";
	
			$pagination_args = array(
				'base' => @add_query_arg('paged','%#%'),
				'format' => '',
				'total' => ceil(sizeof($pag)/$limit),
				'current' => $current,
				'show_all' => false,
				'type' => 'plain',
			);
	
			if( !empty($wp_query->query_vars['s']) )
				$pagination_args['add_args'] = array('s'=>get_query_var('s'));
	
			$torrent_peers_list .= "<div class='tablenav'><div class='tablenav-pages'>" . paginate_links($pagination_args) . "</div></div>";
	
			$start = ($current - 1) * $limit;
			$end = $start + $limit;
			$end = (sizeof($pag) < $end) ? sizeof($pag) : $end;
	
			$torrent_peers_list .= "<div class='wrap'><table class='widefat'>";

			if( sizeof($pag) != 0 ) {
	
				// Columns
				$cols = explode(",", get_option('torrent_peers_list_admin'));
				$cols = array_map("strtolower", $cols);
				$cols = array_map("trim", $cols);
				$colspan = count($cols);
				// End
				$torrent_peers_list .= '<thead>';
				$torrent_peers_list .= '<tr>';
				foreach ($cols as $col) {
					switch ($col) {
						case 'user':
							$torrent_peers_list .= '<th>User</th>';
						break;
						case 'torrent':
							$torrent_peers_list .= '<th>Torrent</th>';
						break;
						case 'ip':
							$torrent_peers_list .= '<th>IP</th>';
						break;
						case 'port':
							$torrent_peers_list .= '<th>Port</th>';
						break;
						case 'uploaded':
							$torrent_peers_list .= '<th>Uploaded</th>';
						break;
						case 'downloaded':
							$torrent_peers_list .= '<th>Downloaded</th>';
						break;
						case 'peer-id':
							$torrent_peers_list .= '<th>Peer-ID</th>';
						break;
						case 'connected':
							$torrent_peers_list .= '<th>Connected</th>';
						break;
						case 'seeding':
							$torrent_peers_list .= '<th>Seeding</th>';
						break;
						case 'started':
							$torrent_peers_list .= '<th>Started</th>';
						break;
						case 'last-action':
							$torrent_peers_list .= '<th>Last Action</th>';
						break;
					}
				}
				$torrent_peers_list .= '</tr></thead>';
				$torrent_peers_list .= '<tfoot><tr>';
				foreach ($cols as $col) {
					switch ($col) {
						case 'user':
							$torrent_peers_list .= '<th>User</th>';
						break;
						case 'torrent':
							$torrent_peers_list .= '<th>Torrent</th>';
						break;
						case 'ip':
							$torrent_peers_list .= '<th>IP</th>';
						break;
						case 'port':
							$torrent_peers_list .= '<th>Port</th>';
						break;
						case 'uploaded':
							$torrent_peers_list .= '<th>Uploaded</th>';
						break;
						case 'downloaded':
							$torrent_peers_list .= '<th>Downloaded</th>';
						break;
						case 'peer-id':
							$torrent_peers_list .= '<th>Peer-ID</th>';
						break;
						case 'connected':
							$torrent_peers_list .= '<th>Connected</th>';
						break;
						case 'seeding':
							$torrent_peers_list .= '<th>Seeding</th>';
						break;
						case 'started':
							$torrent_peers_list .= '<th>Started</th>';
						break;
						case 'last-action':
							$torrent_peers_list .= '<th>Last Action</th>';
						break;
					}
				}
				$torrent_peers_list .= '</tr></tfoot>';

				for ($i=$start;$i < $end ;++$i ) {
					$row = $pag[$i];
					$sql2 = "SELECT id, name FROM " . TRADER_TORRENTS . " WHERE id = " . $row->torrent . "";
					$result2 = mysql_query($sql2);
					while ($row2 = mysql_fetch_assoc($result2)) {
						$post_id = get_post($row2["post_id"]);
						$post_author = $post_id->post_author;
						$post_added = $post_id->post_date;
						$post_comment = $post_id->comment_count;
						$post_url = $post_id->guid;
						$torrent_peers_list .= '<tbody><tr>';
						foreach ($cols as $col) {
							switch ($col) {
								case 'user':
									//if ($site_config['MEMBERSONLY']) {
									//}
									$user_info = get_userdata($row->userid);
									if ($user_info){
										$torrent_peers_list .= '<td><a href="' . $user_info->user_url . '">' . $user_info->user_login . '</a></td>';
									}else{
										$torrent_peers_list .= '<td>' . $row->ip . '</td>';
									}
								break;
								case 'torrent':
									$smallname = CutName(htmlspecialchars($row2["name"]), 40);
									$torrent_peers_list .= '<td><a href="' . $post_url . '">' . $smallname . '</a></td>';
								break;
								case 'ip':
									$torrent_peers_list .= '<td>'.$row->ip.'</td>';
								break;
								case 'port':
									$torrent_peers_list .= '<td>'.$row->port.'</td>';
								break;
								case 'uploaded':
									if ($row->uploaded < $row->downloaded){
										$torrent_peers_list .= '<td><font color="#ff0000">'.mksize($row->uploaded).'</font></td>';
									}elseif ($row->uploaded == '0'){
										$torrent_peers_list .= '<td>'.mksize($row->uploaded).'</td>';
									}else{
										$torrent_peers_list .= '<td><font color="green">'.mksize($row->uploaded).'</font></td>';
									}
								break;
								case 'downloaded':
									$torrent_peers_list .= '<td>'.mksize($row->downloaded).'</td>';
								break;
								case 'peer-id':
									$torrent_peers_list .= '<td>'.htmlspecialchars($row->peer_id).'</td>';
								break;
								case 'connected':
									if ($row->connectable == 'yes'){
										$torrent_peers_list .= '<td><font color="green">'.$row->connectable.'</font></td>';
									}else{
										$torrent_peers_list .= '<td><font color="#ff0000">'.$row->connectable.'</font></td>';
									}
								break;
								case 'seeding':
									if ($row->seeder == 'yes'){
										$torrent_peers_list .= '<td><font color="green">'.$row->seeder.'</font></td>';
									}else{
										$torrent_peers_list .= '<td><font color="#ff0000">'.$row->seeder.'</font></td>';
									}
								break;
								case 'started':
									$torrent_peers_list .= '<td>'.$row->started.'</td>';
								break;
								case 'last-action':
									$torrent_peers_list .= '<td>'.$row->last_action.'</td>';
								break;
							}
						}
					}
					$torrent_peers_list .= '</tr></tbody></div>';
				}
				$torrent_peers_list .= '</table>';
				$torrent_peers_list .= '<div class="tablenav"><div class="tablenav-pages">' . paginate_links($pagination_args) . '</div></div>';
			}else{
				$torrent_peers_list .= '<div class="wrap"><table class="widefat"><tbody><tr><td align="center"><h2>No Peers</h2></td></tr></tbody></table></div><br />';
			}
		echo $torrent_peers_list;
?>
		</div>
	</div>
</div>
<?php wptrader_footer(); ?>
</div>