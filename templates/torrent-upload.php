<?php
/*
  * Holds the Torrent Upload
  * @package WP-Trader
  * @subpackage Template
*/
function torrent_upload_template() {
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	$torrent_roles_uploader = array_map('trim', @explode('|', get_option('torrent_roles_uploader')));
	if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
		$errorheader = "Error";
		$errormessage = "Sorry you must be a member to view this page!";
		wptrader_update($errorheader, $errormessage);
	}elseif(wp_trader_options('uploaders_only_yes') && !in_array(get_current_user_role(), $torrent_roles_uploader)){
			$errorheader = "Error";
			$errormessage = "Sorry you must be an uploader to view this page!";
			wptrader_update($errorheader, $errormessage);
	}else{
		include_once( WP_TRADER_ABSPATH . '/includes/function-torrent-upload.php' );
		global $current_user, $wpdb;
		$announce_urls = explode(",", strtolower(wp_trader_options('announce_list')));
?>
	<style type='text/css'>
		div.updated, .wrap div.error {
			margin: 5px 0 15px;
		}
		div.updated, .login .message {
			background-color: #FFFFE0;
			border-color: #E6DB55;
		}
		div.updated, div.error {
			border-radius: 3px 3px 3px 3px;
			border-style: solid;
			border-width: 1px;
			margin: 5px 15px 2px;
			padding: 0 0.6em;
		}
	</style>
<?php
		//If user does not have a passkey generate one, only if tracker is set to members only	
		if (!get_user_meta($current_user->ID, 'trader_secret')){
			add_user_meta( $current_user->ID, 'trader_secret', mksecret() );
		}
		$trader_secret = get_user_meta($current_user->ID, 'trader_secret', true);
		if (wp_trader_options('members_only_yes')){
			if (!get_user_meta($current_user->ID, 'trader_passkey', true) || strlen(get_user_meta($current_user->ID, 'trader_passkey', true)) != 32) {
				$rand = array_sum(explode(" ", microtime()));
				$trader_passkey = md5($current_user->user_login.$rand.$trader_secret.($rand*mt_rand()));
				add_user_meta( $current_user->ID, 'trader_passkey', $trader_passkey );
			}
		}
		//End if user does not have a passkey generate one, only if tracker is set to members only
		
		//If user does not have upload or download stats add place in db
		if (!get_user_meta($current_user->ID, 'trader_download')){
			add_user_meta( $current_user->ID, 'trader_download', '0' );
		}
		if (!get_user_meta($current_user->ID, 'trader_upload')){
			add_user_meta( $current_user->ID, 'trader_upload', '0' );
		}
		//End if user does not have upload or download stats add place in db
		
		if(isset($_POST["takeupload"]) == "yes") {
			require_once( WP_TRADER_ABSPATH . '/includes/parse.php' );
			
			//check form data
			/*foreach(explode(":","type:name") as $v) {
				if (!isset($_POST[$v])){
					$errorheader = "Upload Failed";
					$errormessage = "Missing form data.".$v."";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
			}*/
		
			if (!isset($_FILES["torrent"])){
				$errorheader = "Upload Failed";
				$errormessage = "No .torrent file was selected.";
				die(unlink_files());
			}
			
			$f = $_FILES["torrent"];
			$fname = $f["name"];
		
			if (empty($fname)){
				$errorheader = "Upload Failed";
				$errormessage = "Empty filename!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}
			
			if ($_FILES['nfo']['size'] != 0) {
				$nfofile = $_FILES['nfo'];

				if ($nfofile['name'] == ''){
					$errorheader = "Upload Failed";
					$errormessage = "No NFO!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
			
				if (!preg_match('/^(.+)\.nfo$/si', $nfofile['name'], $fmatches)){
					$errorheader = "Upload Failed";
					$errormessage = "NFO uploaded does not have the .nfo extension.";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}

				if ($nfofile['size'] == 0){
					$errorheader = "Upload Failed";
					$errormessage = "NFO must not be 0-byte.";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}

				if ($nfofile['size'] > wp_trader_options('nfo_size')){
					$errorheader = "Upload Failed";
					$errormessage = "NFO is too big! Max ".wp_trader_options('nfo_size')." bytes.";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
				
				$nfo_filename .= $nfofile['tmp_name'];

				if (@!is_uploaded_file($nfo_filename)){
					$errorheader = "Upload Failed";
					$errormessage = "Upload NFO failed!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
				$nfo = 'yes';
			}
			
			$descr = $_POST["descr"];
			if (!$descr){
				$errorheader = "Upload Failed";
				$errormessage = "No Description!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}else{
				$descr = bbcode_to_html($_POST["descr"]); 
			}

			$langid = (0 + $_POST["lang"]);
		
			$catid = (0 + $_POST["type"]);

			if (!is_valid_id($catid)){
				$errorheader = "Upload Failed";
				$errormessage = "Upload No Category!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}

			if (!validfilename($fname)){
				$errorheader = "Upload Failed";
				$errormessage = "Upload Invalid Filename!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}

			if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches)){
				$errorheader = "Upload Failed";
				$errormessage = "Upload Invalid Filename not torrent!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}

			$shortfname = $torrent = $matches[1];

			if (!empty($_POST["name"]))
				$torrent = $_POST["name"];

			$tmpname = $f["tmp_name"];

			if (!is_uploaded_file($tmpname)){
				$errorheader = "Upload Failed";
				$errormessage = "Upload not found in temp!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}
			//end check form data
			
			//If the upload directory is not added then add it
			$uploads = wp_upload_dir();
			if (!is_dir($uploads['path'] . '/'.wp_trader_options("torrent_directory").'/')){
				mkdir($uploads['path'] . '/'.wp_trader_options("torrent_directory").'/', 0755);
			}
			//End if the upload directory is not added then add it
			
			//if the nfo directory is not added then add it
			if (wp_trader_options('allow_nfo_upload_yes')){
				if (!is_dir($uploads['path'] . '/'.wp_trader_options("nfo_directory").'/')){
					mkdir($uploads['path'] . '/'.wp_trader_options("nfo_directory").'/', 0755);
				}
				$nfo_dir = ''.$uploads['path'].'/'.wp_trader_options("nfo_directory").'/';
			}
			//End if the nfo directory is not added then add it
			$torrent_dir = ''.$uploads['path'].'/'.wp_trader_options("torrent_directory").'/';
			
			if(!move_uploaded_file($tmpname, "$torrent_dir/$fname")){
				$errorheader = "Upload Failed";
				$errormessage = "Upload could not be copied! $tmpname - $torrent_dir - $fname";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}
			
			//Parse torrent file
			$TorrentInfo = array();
			$TorrentInfo = ParseTorrent("$torrent_dir/$fname");
			$announce = $TorrentInfo[0];
			$infohash = $TorrentInfo[1];
			$creationdate = $TorrentInfo[2];
			$internalname = $TorrentInfo[3];
			$torrentsize = $TorrentInfo[4];
			$filecount = $TorrentInfo[5];
			$annlist = $TorrentInfo[6];
			$comment = $TorrentInfo[7];
			$filelist = $TorrentInfo[8];
			//End parse torrent file
			
			//check announce url is local or external
			if (!in_array($announce, $announce_urls, 1)){
				$external='1';
			}else{
				$external='0';
			}

			//if externals is turned off
			if (wp_trader_options('allow_external_no') && $external == '1'){
				$errorheader = "Upload Failed";
				$errormessage = "Upload torrent must have the tracker's announce!";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}

			$ret = mysql_query("SHOW TABLE STATUS LIKE '" . $wpdb->prefix . "trader_torrents'");
			$row = mysql_fetch_array($ret);
			$next_id .= $row['Auto_increment'];
			
			//Release name check and adjust
			if ($name ==""){
				$name = $internalname;
			}
			$name = str_replace(".torrent","",$name);
			$name = str_replace("_", " ", $name);
			//End release name check and adjust
			
			//Upload images
			$maxfilesize = wp_trader_options('image_size');

			//Allowed image types
			$imagetypes = explode(",", get_option('image_types'));
			foreach ($imagetypes as $imagetypes){
				$allowed_types .= str_replace(".", "image/", "".$imagetypes." ");
			}
			$allowed_types = explode(" ", $allowed_types);
			$allowed_types = array_flip($allowed_types);
			//Allowed image types End
	
			if (!($_FILES[image]['name'] == "")) {
				$y = $x + 1;

				if (!array_key_exists($_FILES[image.$x]['type'], $allowed_types)){
					$errorheader = "Upload Failed";
					$errormessage = "The file type is not an image!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
				if (!preg_match('/^(.+)\.(jpg|gif|png)$/si', $_FILES[image.$x]['name'])){
					$errorheader = "Upload Failed";
					$errormessage = "The file type is not an image!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}

				if ($_FILES[image]['size'] > $maxfilesize){
					$errorheader = "Upload Failed";
					$errormessage = "Image file size to big!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
				
				//If the images directory is not added then add it
				$uploads = wp_upload_dir();
				if (!is_dir($uploads['path'] . '/'.wp_trader_options("image_directory").'/')){
					mkdir($uploads['path'] . '/'.wp_trader_options("image_directory").'/', 0755);
				}
				//End if the images directory is not added then add it
				
				//If the thumbnails directory is not added then add it
				if (!is_dir($uploads['path'] . '/'.wp_trader_options("image_directory").'/thumbnails/')){
					mkdir($uploads['path'] . '/'.wp_trader_options("image_directory").'/thumbnails/', 0755);
				}
				//End if the thumbnails directory is not added then add it
				
				$uploaddir = ''.$uploads['path'].'/'.wp_trader_options("image_directory").'/';
			
				$ifile = $_FILES[image]['tmp_name'];

				$ifilename = $next_id . substr($_FILES[image]['name'], strlen($_FILES[image]['name'])-4, 4);

				$copy = copy($ifile, $uploaddir.$ifilename);

				if (!$copy){
					$errorheader = "Upload Failed";
					$errormessage = "An error has occured uploading image!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}

			}
			//End upload images
			
			//Anonymous upload
			$anonyupload = $_POST["anonycheck"];
			//End anonymous upload
			
			$query = "SELECT info_hash FROM " . TRADER_TORRENTS . "";
			$res = mysql_query($query) or die(mysql_error());
			while ($row = mysql_fetch_assoc($res)) {
				if ($row["info_hash"] == $infohash){
					$errorheader = "Upload Failed";
					$errormessage = "Torrent already uploaded!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
			}
			$torrent_browse_page_yes = wp_trader_options('torrent_browse_page') == 1;
			$torrent_browse_page_no = wp_trader_options('torrent_browse_page') == 0;
			if(!$torrent_browse_page_yes){
				$post_status = 'publish';
			}else{
				$post_status = 'draft';
			}
			
			//Create post object but update the content further down.
			$upload_torrent_post = array(
				'post_title' => ''.$name.'', 'post_status' => ''.$post_status.'', 'post_content' => '',
				'post_author' => $current_user->id, 'post_category' => array($catid)
			);
			//End create post object
			
			wp_trader_insert_torrent_post( $upload_torrent_post );
			//End insert the post into the database
			
			//Insert the torrent image post into the database
			$uploaded_save_name = $uploaddir . 'thumbnails/thumb_' . $ifilename;
			$upload_torrent_post_image_url = $uploads['url'] . $uploaded_save_name;
			$upload_torrent_post_title = get_page_by_title( ''.$name.'', object, 'post' );
			$upload_torrent_post_id = $upload_torrent_post_title->ID;
			
			//Create post object
			$upload_torrent_image_post = array(
				'post_author' => $current_user->id, 'post_title' => ''.sanitize_title($ifilename).'', 'post_status' => 'inherit',
				'comment_status' => 'closed', 'ping_status' => 'closed', 'post_name' => ''.sanitize_title($ifilename).'',
				'post_parent' => ''.$upload_torrent_post_id.'', 'guid' => ''.$upload_torrent_post_image_url.'', 'post_type' => 'attachment', 'post_mime_type' => 'image/jpeg'
			);
			//End create post object
			
			wp_trader_insert_torrent_image_post( $upload_torrent_image_post );
			//End insert the torrent image post into the database
			
			//Upload NFO
			if (wp_trader_options('allow_nfo_upload_yes') && $_FILES['nfo']['size'] != 0){
				$nfofilename = $next_id . substr($nfofile['name'], strlen($nfofile['name'])-4, 4);
				$copy_nfo = copy($nfo_filename, $nfo_dir.$nfofilename);

				if (!$copy_nfo){
					$errorheader = "Upload Failed";
					$errormessage = "An error has occured uploading nfo!";
					wptrader_update($errorheader, $errormessage);
					die(unlink_files());
				}
				if(extension_loaded('gd') && wp_trader_options('nfo_display_type_yes')){
					if (!is_dir($uploads['path'] . '/'.wp_trader_options("nfo_directory").'/nfo_image/')){
						mkdir($uploads['path'] . '/'.wp_trader_options("nfo_directory").'/nfo_image/', 0755);
					}
					$nfo_image_dir = ''.$uploads['path'].'/'.wp_trader_options("nfo_directory").'/nfo_image/';
					
					# Read file and remove \r
					$content = file_get_contents ( $nfo_dir.$nfofilename );
					$content = str_replace ( "\r", null, $content );
   
					# Get height by counting lines
					$lines = explode ( "\n", $content );
					$line_count = count ( $lines );
   
					# Get width by looking for longest line
					$char_count = 0;
					foreach ( $lines as $v ){
						$strlen = strlen ( rtrim ( $v, "\n" ) );
						if ( $strlen > $char_count ){
							$char_count = $strlen;
						}
					}
   
					# Single symbol width and height
					$fontx = 5;
					$fonty = 12;
   
					# Load nfo font from image
					$font = imagecreatefrompng ( WP_TRADER_ABSPATH . '/css/fonts/nfo_font.png' );
   
					# Width and height
					$width = $char_count * $fontx;
					$height = $line_count * $fonty;
   
					if ( $width > 1600 ) $width = 1600;
   
					# Create image
					$im = imagecreatetruecolor ( $width, $height );
   
					# Font and background colors
					$bg = imagecolorallocate ( $im, 255, 255, 255 );
					$fontcol = 5 * $fonty;
   
					imagefill ( $im, 0, 0, $bg );
   
					$x = 0;
					$y = 0;
   
					# Fill image with text
					for ( $l = 0; $l < $line_count; $l++ ){
						$x = 0;
    
						$strlen = strlen ( $lines [ $l ] );
						for ( $c = 0; $c < $strlen; $c++ ){
							$char = $lines [ $l ] [ $c ];
							if ( $char !== "\n" ){
								$offset = ord ( $char ) * $fontx;
								imagecopy ( $im, $font, $x, $y, $offset, $fontcol, $fontx, $fonty );
								$x += $fontx;
							}
						}
    
						$y += $fonty;
					}
					
					$nfo_png_filename = $next_id . '.png';
					$nfo_png_upload = imagepng($im, $nfo_image_dir.$nfo_png_filename);
					//$copy_nfo_png = copy($nfo_png_upload, $nfo_image_dir.$nfo_png_filename);

					if (!$nfo_png_upload){
						$errorheader = "Upload Failed";
						$errormessage = "An error has occured uploading nfo image!";
						wptrader_update($errorheader, $errormessage);
						die(unlink_files());
					}
					imagedestroy($nfo_png);
					$nfo_image_url = ''.$uploads['url'].'/'.wp_trader_options("nfo_directory").'/nfo_image/';
					add_post_meta($upload_torrent_post_id, 'nfo_png_location', $nfo_image_url.$nfo_png_filename);
				}
			}
			//End Upload NFO
			
			//Insert the torrent image meta into the database
			if(!($_FILES[image]['name'] == "") && extension_loaded('gd')){
				$extension = getExtension($_FILES[image]['name']);
				$extension = strtolower($extension);
				$uploaded_file_name = $ifile;
				$new_width = 150;
				$new_height = 150;
				crop_image($extension, $uploaded_file_name, $new_width, $new_height, $uploaded_save_name);
				$upload_torrent_image_post_title = get_page_by_title( ''.sanitize_title($ifilename).'', object, 'attachment' );
				$upload_torrent_image_post_id = $upload_torrent_image_post_title->ID;
				$image_meta_info = 'a:6:{s:5:"width";s:4:"1680";s:6:"height";s:4:"1050";s:14:"hwstring_small";s:23:"height=\'80\' width=\'128\'";s:4:"file";s:59:"'.$uploaddir.$ifilename.'";s:5:"sizes";a:3:{s:9:"thumbnail";a:3:{s:4:"file";s:59:"'.$uploaded_save_name.'";s:5:"width";s:3:"'.$new_width.'";s:6:"height";s:3:"'.$new_height.'";}s:6:"medium";a:3:{s:4:"file";s:59:"'.$uploaddir.$ifilename.'";s:5:"width";s:3:"300";s:6:"height";s:3:"187";}s:5:"large";a:3:{s:4:"file";s:60:"'.$uploaddir.$ifilename.'";s:5:"width";s:4:"1024";s:6:"height";s:3:"640";}}s:10:"image_meta";a:10:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";}}';
					add_post_meta($upload_torrent_image_post_id, '_wp_attached_file', $uploaded_save_name);
					add_post_meta($upload_torrent_image_post_id, '_wp_attachment_metadata', $image_meta_info);
					add_post_meta($upload_torrent_post_id, '_thumbnail_id', $upload_torrent_image_post_id);
			}
			// End insert the torrent image meta into the database
			
			//Insert post meta
			$torrent_dir = wp_trader_options('torrent_directory');
			$torrent_location = $uploads['path'] . "/$torrent_dir/$fname";
			add_post_meta($upload_torrent_post_id, "external", $external);
			add_post_meta($upload_torrent_post_id, "anon", $anonyupload);
			add_post_meta($upload_torrent_post_id, "torrent_location", $torrent_location);
			if (wp_trader_options('allow_nfo_upload_yes')){
				$nfo_dir = wp_trader_options('nfo_directory');
				$nfo_location = $uploads['path'] . "/$nfo_dir/$nfofilename";
				if ($nfo == "yes"){
					add_post_meta($upload_torrent_post_id, "nfo_location", $nfo_location);
				}
			}
			
			add_post_meta($upload_torrent_post_id, "views", "0");
			add_post_meta($upload_torrent_post_id, "hits", "0");
			add_post_meta($upload_torrent_post_id, "freeleech", "0");
			add_post_meta($upload_torrent_post_id, "descr", $descr);
			add_post_meta($upload_torrent_post_id, "last_action", current_time('mysql'));
			add_post_meta($upload_torrent_post_id, "torrent_visible", "1");
			//End post meta
			
			//Insert the torrent into the database
			//Create post object
			$upload_torrent = array(
				'post_id' => ''.$upload_torrent_post_id.'','attachment_id' => ''.$upload_torrent_image_post_id.'','info_hash' => ''.$infohash.'','name' => ''.$name.'','filename' => ''.$fname.'','save_as' => ''.$fname.'',
				'category' => ''.$catid.'','size' => ''.$torrentsize.'','type' => ''.$type.'','numfiles' => ''.$filecount.'','owner' => ''.$current_user->id.'','nfo' => ''.$nfo.'','announce' => ''.$announce.'','torrentlang' => ''.$langid.''
			);
			wp_trader_insert_torrent( $upload_torrent );
			//End insert the torrent into the database
			
			//Insert the torrent files into the database
			//foreach ($filelist as $file) {
					$data = array();
					if (count($filelist)) {
						foreach ($filelist as $file) {
							$dir = '';
							$size = $file["length"];
							$count = count($file["path"]);
							for ($i=0; $i<$count;$i++) {
								if (($i+1) == $count)
									$fname = $dir.$file["path"][$i];
								else
									$dir .= $file["path"][$i]."/";
							}
							$data[] = array('path' => $fname, 'size' => $size);
						}
					} else {
						$data[] = array('path' => $fname, 'size' => $size);
					}
					$array = serialize($data);
				//}
				add_post_meta($upload_torrent_post_id, 'torrent_files', $data);
			//End the torrent files into the database
			
			
			
			//Update post object which was crated above.
			$query = "SELECT id FROM " . TRADER_TORRENTS . " WHERE post_id = ".$upload_torrent_post_id."";
			$res = mysql_query($query) or die(mysql_error());
			$torrent_post_template = '[torrentdescription torrent_descr="download-box" torrent_post_id="'.$upload_torrent_post_id.'"] [/torrentdescription]';
			$torrent_post_template .= '<br />&nbsp;<br />&nbsp;<br />&nbsp;<br /><br />&nbsp;<br /><br />&nbsp;<br />';
			$torrent_post_template .= '[torrentdescription torrent_descr="container" torrent_post_id="'.$upload_torrent_post_id.'"] [/torrentdescription]';
			while ($row = mysql_fetch_assoc($res)) {
				$dialog_id .= $row["id"];
				$torrent_post_update = array(
					'ID' => ''.$upload_torrent_post_id.'', 'post_title' => ''.$name.'', 'post_status' => ''.$post_status.'', 'comment_status' => 'open', 'ping_status' => 'open',
					'post_content' => ''.$torrent_post_template.'', 'post_author' => $current_user->id, 'post_category' => array($catid)
				);
				wp_insert_post( $torrent_post_update );
				if (!count($annlist)) {
					$annlist = array(array($announce));
				}
				//Insert the announce urls
				foreach ($annlist as $anns) {
					foreach ($anns as $val) {
						if (strtolower(substr($val, 0, 4)) != "udp:") {
							$upload_torrent_announce = array( 'url' => sqlesc($val), 'torrent' => $row["id"] );
							wp_trader_insert_announce( $upload_torrent_announce );
						}
					}
				}
				//End insert the announce urls
			}
			//Uploaded ok message (update later)
			if (!$external=='1'){
				$title .= "".$name."";
				$message .= ''.$title.' was uploaded. \n\n <div>Please click <a href="' . WP_TRADER_PLUGIN_URL . 'download.php?id='.$dialog_id.'">here</a> to download the torrent.</div>';
			}else{
				$title .= "".$name."";
				$message .= ''.$title.' was uploaded. \n\n <div>Please click <a href="'.get_permalink( $upload_torrent_post_id ).'">here</a> to view the torrent or close the dialog to upload another.<BR><BR></div>';
			}
			?>
			<script>
			$(document).ready(function() {
				var newDiv = $(document.createElement('div')); 
				newDiv.load(location.href+" #info>*","");
				newDiv.dialog();
				var $dialog = $('<div></div>')
					.html('<?php echo $message; ?>')
					.dialog({
						autoOpen: true,
						title: '<?php echo $title; ?>'
					});
					newDiv('destroy');
					$dialog.dialog('open');
				
				/*setInterval(function() {
					$("#info").load(location.href+" #info>*","");
				}, 0);
				setInterval(function() {
					$("#validation").load(location.href+" #validation>*","");
				}, 0); 
				setInterval(function() {
					$("#success").load(location.href+" #success>*","");
				}, 0);*/
			});
			</script>
			<?php
			if (($external != "0" && wp_trader_options('scrape_upload_yes') && $_POST["scrape_upload"] != "no") || ($external != "0" && wp_trader_options('scrape_upload_yes') && wp_trader_options('scrape_upload_force_yes'))){
				$seeders1 = $leechers1 = $downloaded1 = null;
				echo "<div id='info' class='info'><center><b>Loading:</b> ".count($TorrentInfo[6])." urls to scrape.</center></div>";
				$tres = mysql_query("SELECT url FROM " . TRADER_ANNOUNCE . " WHERE torrent=$dialog_id");
				while ($trow = mysql_fetch_array($tres)) {
					$ann = $trow["url"];
					$tracker = explode("/", $ann);
					$path = array_pop($tracker);
					$oldpath = $path;
					$path = preg_replace("/^announce/", "scrape", $path);
					$tracker = implode("/", $tracker)."/".$path;

					if ($oldpath == $path) {
						continue;
					}

					if (preg_match("/thepiratebay.org/i", $tracker) || preg_match("/prq.to/", $tracker)) {
						$tracker = "http://tracker.openbittorrent.com/scrape";
					}
					//echo "<div id='validation' class='validation'><center><b>Currently Scraping:</b> <a href='".$ann."' target='_blank'>" . htmlspecialchars($ann) . "</a></center></div>"; 
					$stats = torrent_scrape_url($tracker, $infohash);
					if ($stats['seeds'] != -1) {
						$seeders1 += $stats['seeds'];
						$leechers1 += $stats['peers'];
						$downloaded1 += $stats['downloaded'];
						$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'yes', seeders = $stats[seeds], leechers = $stats[peers], times_completed = $stats[downloaded] WHERE url = '".sqlesc($ann)."' AND torrent = ".$dialog_id."";
						mysql_query($ares) or die(mysql_error());
						//echo "<div id='success' class='success'><center><b>Stats Detected:</b> <font color='red'>Seeders:</font><font color='green'>".$stats[seeds]."</font>, <font color='red'>Leechers:</font><font color='green'>".$stats[peers]."</font>, <font color='red'>Completed:</font><font color='green'>".$stats[downloaded]."</font></center></div>"; 
					} else {
						$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'no' WHERE url = '".sqlesc($ann)."' AND torrent = ".$dialog_id."";
						mysql_query($ares) or die(mysql_error());
					}
				}

				if ($seeders1 !== null){
					update_post_meta($upload_torrent_post_id, "seeders", $seeders1);
					update_post_meta($upload_torrent_post_id, "leechers", $leechers1);
					update_post_meta($upload_torrent_post_id, "times_completed", $downloaded1);
					update_post_meta($upload_torrent_post_id, "last_action", current_time('mysql'));
					update_post_meta($upload_torrent_post_id, "torrent_visible", "1");
				}
			}elseif ($external != "1" && wp_trader_options('scrape_upload_yes')){
				update_post_meta($upload_torrent_post_id, "seeders", "0");
				update_post_meta($upload_torrent_post_id, "leechers", "0");
				update_post_meta($upload_torrent_post_id, "times_completed", "0");
				update_post_meta($upload_torrent_post_id, "last_action", current_time('mysql'));
				update_post_meta($upload_torrent_post_id, "torrent_visible", "0");
			}
		}
		//tables need changing for dialog box
?>
		<table class="form-table">
			<form name="upload" enctype="multipart/form-data" action="" method="post">
			<input type="hidden" name="takeupload" value="yes" />
				<tr>
					<th><label for="upload_rules"><b>Upload Rules:</b>&nbsp;&nbsp;</label></th>
						<td><?php echo wp_trader_options('upload_rules')."<br /><br />"; ?></td>
				</tr>
				<tr>
					<th><label for="announce_url"><b>Announce Url:</b>&nbsp;&nbsp;</label></th>
						<td>
						<?php 
						while (list($key,$value) = each($announce_urls)) {
							echo "<b>$value</b><br />";
						}

						if (wp_trader_options('allow_external_yes')){
							echo "<i><b>This site accepts external torrents.</b></i>";
						}
						echo "<br /><br />";
						?>
						</td>
				</tr>
				<tr>
					<th><label for="torrent_file"><b>Torrent File:</b>&nbsp;&nbsp;</label></th>
						<td><input type="file" name="torrent" size="50" value=<?php echo $_FILES['torrent']['name']; ?>><br /><br /></td>
				</tr>
				<?php if (wp_trader_options('allow_nfo_upload_yes')){ ?>
				<tr>
					<th><label for="torrent_nfo"><b>NFO:</b>&nbsp;&nbsp;</label></th>
					<td><input type="file" name="nfo" size="50" value=<?php echo $_FILES['nfo']['name']; ?>><br /><br /></td>
				</tr>
				<?php } ?>
				<tr>
					<th><label for="torrent_name"><b>Torrent Name:</b>&nbsp;&nbsp;</label></th>
						<td>
							<input type="text" name="torrent_name" size="60" value=<?php echo $_POST['name']; ?>><br />
							<i><b>If left empty this will be taken from the torrent.</b></i><br />
						</td>
				</tr>
				<tr>
					<th><label for="torrent_image"><b>Image:</b>&nbsp;&nbsp;</label></th>
						<td>Max File Size: 500kb<br>Accepted Formats: .gif, .jpg, .png<br><b>IMAGE:</b>&nbsp&nbsp<input type="file" name="image" size=50><br /><br /></td>
				</tr>
				<tr>
					<th><label for="type"><b>Category:</b>&nbsp;&nbsp;</label></th>
					<td><?php wp_dropdown_categories(array('hide_empty' => 0, 'name' => 'type', 'hierarchical' => true))."<br /><br />"; ?></td>
				</tr>
					<?php
					$language = "<select name=\"lang\">\n<option value=\"0\">Unknown/NA</option>\n";
					$langs = langlist();
						foreach ($langs as $row)
							$language .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
							$language .= "</select>\n";
					?>
				<tr>
					<th><label for="lang"><b>Lanuage:</b>&nbsp;&nbsp;</label></th>
						<td><?php echo $language."<br /><br />"; ?></td>
				</tr>
					<?php if (wp_trader_options('members_only_yes') && wp_trader_options('anonymous_upload_yes')){ ?>
				<tr>
					<th><label for="anonycheck"><b>Anonymous:</b>&nbsp;&nbsp;</label></th>
						<td>
							<input type="radio" name="anonycheck" id="anonycheck" value="1" <?php echo (isset($_POST['anonycheck']) ? " checked" : ""); ?> /> Yes <input type="radio" name="anonycheck" id="anonycheck" value="0" <?php echo (!isset($_POST['anonycheck']) ? " checked" : ""); ?> /> No <br />
							<i><b>Your userid will not be associated to this upload.</b></i>
						</td>
				</tr>
					<?php } 
						if (wp_trader_options('allow_external_yes') && wp_trader_options('scrape_upload_yes') && wp_trader_options('scrape_upload_force_no')){
					?>
							<tr>
					<th><label for="scrape_upload"><b>Scrape External:</b>&nbsp;&nbsp;</label></th>
						<td>
							<input type="radio" name="scrape_upload" id="scrape_upload" value="yes" /> Yes <input type="radio" name="scrape_upload" id="scrape_upload" value="no" checked="checked" /> No <br />
							<i><b>This will scrape external stats for the torrent upon upload. Choosing this option will take longer to upload the torrent.</b></i>
						</td>
				</tr>
					<?php
						}
					?>
				<tr>
					<th><label for="descr"><b>Description:</b>&nbsp;&nbsp;</label></th>
						<td>
							<?php
								global $wp_version;
								if ($wp_version >= '3.3' && wp_trader_options('torrent_upload_wordpress_editor_yes')){
									$content = "";
									$editor_id = "descr";
									$settings = array(
										'wpautop' => true,
										'media_buttons' => true,
										'textarea_rows' => '15',																				'editor_css' => '<style>http://www.wp-trader.tsocialmedia.com/test-editor.css</style>',
										//'editor_class' => 'descr',
										'tinymce' => true,
										'quicktags' => true
									);
									wp_editor( $content, $editor_id, $settings );
								}elseif ($wp_version < '3.3' || wp_trader_options('torrent_upload_wordpress_editor_no')){
									require_once(WP_TRADER_ABSPATH . '/includes/bbcode.php');
									print ("".textbbcode("upload","descr","$descr")."");
								}
							?>
						</td>
				</tr>
		</table>
			<p class="form-submit">
				<BR><BR><CENTER><input id="t_u_s" type="submit" name="submit" onsubmit="descr.post();" value="Upload"><BR>
				<I>Please click upload button only once!</I>
				</CENTER>
			</p>
			</form>
<?php
	}
}
?>