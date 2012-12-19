<?php
/** 
* WP-Trader Free Leech Administration Screen. 
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
<style type='text/css'>
.error_wp_trader {
	background: #FFFF00;
	border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -khtml-border-top-left-radius: 5px;
    -khtml-border-top-right-radius: 5px;
}
</style>
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
			$torrent_table = "id, post_id, attachment_id, info_hash, name, filename, save_as, category, size, numfiles, banned, owner, nfo, announce, torrentlang";
	
			$current = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
	
			$pag = $wpdb->get_results("SELECT " . $torrent_table ." FROM " . TRADER_TORRENTS . " ORDER BY id DESC");
	
			$limit = "".get_option('torrent_free_leech_admin_limit')."";
	
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
	
			$torrent_freeleech_list .= "<div class='tablenav'><div class='tablenav-pages'>" . paginate_links($pagination_args) . "</div></div>";
	
			$start = ($current - 1) * $limit;
			$end = $start + $limit;
			$end = (sizeof($pag) < $end) ? sizeof($pag) : $end;
	
			$torrent_freeleech_list .= "<div class='wrap'><table class='widefat'>";

			if( sizeof($pag) != 0 ) {
	
				// Columns
				$cols = explode(",", get_option('torrent_free_leech_admin'));
				$cols = array_map("strtolower", $cols);
				$cols = array_map("trim", $cols);
				$colspan = count($cols);
				// End
				$torrent_freeleech_list .= '<thead>';
				$torrent_freeleech_list .= '<tr>';
				foreach ($cols as $col) {
					switch ($col) {
						case 'id':
							$torrent_freeleech_list .= '<th>ID</th>';
						break;
						case 'post_id':
							$torrent_freeleech_list .= '<th>Post ID</th>';
						break;
						case 'attachment_id':
							$torrent_freeleech_list .= '<th>Attachment ID</th>';
						break;
						case 'info_hash':
							$torrent_freeleech_list .= '<th>Info Hash</th>';
						break;
						case 'name':
							$torrent_freeleech_list .= '<th>Name</th>';
						break;
						case 'filename':
							$torrent_freeleech_list .= '<th>Filename</th>';
						break;
						case 'save_as':
							$torrent_freeleech_list .= '<th>Filename Saved As</th>';
						break;
						case 'category':
							$torrent_freeleech_list .= '<th>Category</th>';
						break;
						case 'size':
							$torrent_freeleech_list .= '<th>Size</th>';
						break;
						case 'numfiles':
							$torrent_freeleech_list .= '<th>Numfiles</th>';
						break;
						case 'banned':
							$torrent_freeleech_list .= '<th>Banned</th>';
						break;
						case 'owner':
							$torrent_freeleech_list .= '<th>Owner</th>';
						break;
						case 'nfo':
							$torrent_freeleech_list .= '<th>NFO</th>';
						break;
						case 'announce':
							$torrent_freeleech_list .= '<th>Announce URL</th>';
						break;
						case 'torrentlang':
							$torrent_freeleech_list .= '<th>Torrent Lang</th>';
						break;
					}
				}
				$torrent_freeleech_list .= '</tr></thead>';
				$torrent_freeleech_list .= '<tfoot><tr>';
				foreach ($cols as $col) {
					switch ($col) {
						case 'id':
							$torrent_freeleech_list .= '<th>ID</th>';
						break;
						case 'post_id':
							$torrent_freeleech_list .= '<th>Post ID</th>';
						break;
						case 'attachment_id':
							$torrent_freeleech_list .= '<th>Attachment ID</th>';
						break;
						case 'info_hash':
							$torrent_freeleech_list .= '<th>Info Hash</th>';
						break;
						case 'name':
							$torrent_freeleech_list .= '<th>Name</th>';
						break;
						case 'filename':
							$torrent_freeleech_list .= '<th>Filename</th>';
						break;
						case 'save_as':
							$torrent_freeleech_list .= '<th>Filename Saved As</th>';
						break;
						case 'category':
							$torrent_freeleech_list .= '<th>Category</th>';
						break;
						case 'size':
							$torrent_freeleech_list .= '<th>Size</th>';
						break;
						case 'numfiles':
							$torrent_freeleech_list .= '<th>Numfiles</th>';
						break;
						case 'banned':
							$torrent_freeleech_list .= '<th>Banned</th>';
						break;
						case 'owner':
							$torrent_freeleech_list .= '<th>Owner</th>';
						break;
						case 'nfo':
							$torrent_freeleech_list .= '<th>NFO</th>';
						break;
						case 'announce':
							$torrent_freeleech_list .= '<th>Announce URL</th>';
						break;
						case 'torrentlang':
							$torrent_freeleech_list .= '<th>Torrent Lang</th>';
						break;
					}
				}
				$torrent_freeleech_list .= '</tr></tfoot>';

				for ($i=$start;$i < $end ;++$i ) {
					$row = $pag[$i];
					$post_id = get_post($row->post_id);
					$post_author = $post_id->post_author;
					$post_added = $post_id->post_date;
					$post_comment = $post_id->comment_count;
					$post_url = $post_id->guid;
					$free_leech_yes = (get_post_meta($row->post_id, 'freeleech', true) == 1) ? 'checked="checked"' : '';
					$free_leech_no = (get_post_meta($row->post_id, 'freeleech', true) == 0) ? 'checked="checked"' : ''; 
				
					$torrent_freeleech_list .= '<tbody><tr>';
					if($free_leech_yes){
						foreach ($cols as $col) {
							switch ($col) {
								case 'id':
									$torrent_freeleech_list .= '<td>' . $row->id . '</td>';
								break;
								case 'post_id':
									$torrent_freeleech_list .= '<td>' . $row->post_id . '</td>';
								break;
								case 'attachment_id':
									$torrent_freeleech_list .= '<td>'.$row->attachment_id.'</td>';
								break;
								case 'info_hash':
									$torrent_freeleech_list .= '<td>'.$row->info_hash.'</td>';
								break;
								case 'name':
									$smallname = CutName(esc_attr($row->name), 40);
									$torrent_freeleech_list .= '<td><a href="' . $post_url . '">' . $smallname . '</a></td>';
								break;
								case 'filename':
									$torrent_freeleech_list .= '<td>'.$row->filename.'</td>';
								break;
								case 'save_as':
									$torrent_freeleech_list .= '<td>'.$row->save_as.'</td>';
								break;
								case 'category':
									foreach((get_the_category( $row->post_id )) as $category) {
										$torrent_freeleech_list .= '<td>'.$category->cat_name.'</td>';
									}
								break;
								case 'size':
									$torrent_freeleech_list .= '<td>'.mksize($row->size).'</td>';
								break;
								case 'numfiles':
									$torrent_freeleech_list .= '<td>'.$row->numfiles.'</td>';
								break;
								case 'banned':
									$torrent_freeleech_list .= '<td>'.$row->banned.'</td>';
								break;
								case 'owner':
									$user_info = get_userdata($row->owner);
									if ($user_info){
										$torrent_freeleech_list .= '<td><a href="' . $user_info->user_url . '">' . $user_info->user_login . '</a></td>';
									//}else{
										//$torrent_freeleech_list .= '<td>' . $row->ip . '</td>';
									}
								break;
								case 'nfo':
									$torrent_freeleech_list .= '<td>'.$row->nfo.'</td>';
								break;
								case 'announce':
									$torrent_freeleech_list .= '<td>'.$row->announce.'</td>';
								break;
								case 'torrentlang':
									$querystr = "SELECT name FROM " . TRADER_TORRENT_LANGUAGES . " WHERE id = ".$row->torrentlang."";
									$lang_name = $wpdb->get_row($querystr);
									if (!$lang_name):
										$lang_name = "Unknown/NA";
									endif;
									$torrent_freeleech_list .= '<td>'.$lang_name->name.'</td>';
								break;
							}
						}
					}
					$torrent_freeleech_list .= '</tr></tbody></div>';
				}
				$torrent_freeleech_list .= '</table>';
				$torrent_freeleech_list .= "<div class='tablenav'><div class='tablenav-pages'>" . paginate_links($pagination_args) . "</div></div>";
			}else{
				$torrent_freeleech_list .= '<div class="wrap"><table class="widefat"><tbody><tr><td align="center"><h2>No Free Leech Torrents</h2></td></tr></tbody></table></div><br />';
			}
			echo $torrent_freeleech_list;
?>
		</div>
	</div>
</div>
<?php wptrader_footer(); ?>
</div>