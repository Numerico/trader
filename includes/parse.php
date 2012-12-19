<?php
//
//  TorrentTrader v2.x
//	This file was last updated: 27/June/2007
//	
//	http://www.torrenttrader.org
//
//

/*array info for ref:
announce
infohash
creation date
intenal name
torrentsize
filecount
announceruls
comment
filelist
*/


function ParseTorrent($filename) {
	require_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	require_once(WP_TRADER_ABSPATH . '/includes/BDecode.php') ;
	require_once(WP_TRADER_ABSPATH . '/includes/BEncode.php') ;

	$TorrentInfo = array();

	global $array;

	//check file type is a torrent
	$torrent = explode(".", $filename);
    $fileend = end($torrent);
    $fileend = strtolower($fileend);

	if ( $fileend == "torrent" ) {
		$parseme = @file_get_contents("$filename");

	if ($parseme == FALSE) {
		$errorheader = "Parser Error";
		$errormessage = "Error Opening torrent, unable to get contents.";
		wptrader_update($errorheader, $errormessage);
		die(unlink_files());
	}

	if(!isset($parseme)){
		$errorheader = "Parser Error";
		$errormessage = "Error Opening torrent. Torrent file not chosen or could not be found.";
		wptrader_update($errorheader, $errormessage);
		die(unlink_files());
	}else{
		$array = BDecode($parseme);
		if ($array === FALSE){
			$errorheader = "Parser Error";
			$errormessage = "Error Opening torrent, unable to decode.";
			wptrader_update($errorheader, $errormessage);
			die(unlink_files());
		}else{
			if(array_key_exists("info", $array) === FALSE){
				$errorheader = "Parser Error";
				$errormessage = "Error Opening torrent.";
				wptrader_update($errorheader, $errormessage);
				die(unlink_files());
			}else{
				//Get Announce URL
				$TorrentInfo[0] = $array["announce"];

				//Get Announce List Array
				if (isset($array["announce-list"])){
					$TorrentInfo[6] = $array["announce-list"];
				}

				//Read info, store as (infovariable)
				$infovariable = $array["info"];
				
				// Calculates SHA1 Hash
				$infohash = sha1(BEncode($infovariable));
				$TorrentInfo[1] = $infohash ;
				
				// Calculates date from UNIX Epoch
				$makedate = date('r' , $array["creation date"]);
				$TorrentInfo[2] = $makedate ;

				// The name of the torrent is different to the file name
				$TorrentInfo[3] = $infovariable['name'] ;

				//Get File List
				if (isset($infovariable["files"]))  {
					// Multi File Torrent
					$filecount = "";

					//Get filenames here
					$TorrentInfo[8] = $infovariable["files"];

					foreach ($infovariable["files"] as $file) {
						$filecount += "1";
						$multiname = $file['path'];//Not needed here really
						$multitorrentsize = $file['length'];
						$torrentsize += $file['length'];
					}

					$TorrentInfo[4] = $torrentsize;  //Add all parts sizes to get total
					$TorrentInfo[5] = $filecount;  //Get file count
				}else {
					// Single File Torrent
					$torrentsize = $infovariable['length'];
					$TorrentInfo[4] = $torrentsize;//Get file count
					$TorrentInfo[5] = "1";
				}

				// Get Torrent Comment
				if(isset($array['comment'])) {
					 $TorrentInfo[7] = $array['comment'];
				}
			}
		}
	}
}
return $TorrentInfo;
}//End Function
?>