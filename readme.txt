=== WP-Trader ===
Contributors: Andrew Walker & Lee Howarth
Donate link: http://wp-tracker.com
Tags: WordPress Torrent Tracker, Torrent, Tracker, Torrent Tracker, Music, Bands, Indy, Short Films, Software, Software Release, Distribution, Music Distribution, Software Distribution, Movies Distribution, Uploads, Downloads, Peers
Requires at least: 3.0
Tested up to: 3.3.1
Beta tag: .4.8

Transform your WordPress Blog into a torrent tracker.

== Description ==

INFO: Roughly based on Torrent Trader 2.07, WP-Trader is an easy solution for people to run a torrent site. Now it is easier for bands, software makers, authors and etc. to be able to get their work out to their users without the high cost of having servers for product download. We hope this plugin will be usefule for people who do not want to distribute their works through the normal channel which like to act like a mafiaa and not pay the artists what they deserve (we will not mention the companies names but you should know who you are and should not fear us but embrace us). Users of this plugin should only use it to distribute work which they own the rights to. The author(s) of this plugin can not be held responsible for the use of this plugin.<br />Most people look at a torrent site and say oh well that is how they normally look so that is how i will keep mine. I look at a torrent site and say what can I make different instead of having the same old boring shit.
   
= Things already added from the Torrent Trader source: =

Most of the config is in the db and at the moment there is two sections for the options in the admin panel.
At the moment the announce works but has not been tested for everything like wait classes and freeleech.
Torrent browse page is working if that option is set in the admin section.
Torrents made into post is working if that option is chosen but still needs work done on how things are displayed and maybe a few things added.
Download page is working.
On plugin activation a user is made with the username system for anon uploads and other things.
Admin panel has a safety feature to not delete the plugin options and data when deactivated but this can be disabled if you want to delete everything.

There are other features added (some can be viewed in the different versions) but at the moment I cannot think of all of them so lets move on to the things not done.

= Things not added yet from the Torrent Trader source: =

Anon upload needs finishing off in torrent upload and possibly in other places.
Need to sort out a cleanup to get the dead torrents to not show up in the post or on the torrent browse.
Need to add language pics and pic on post display.
Need to do a torrent details page if the torrent browse is being used. (May combine the template for that with the posts)
Need to sort a default theme.
And plenty of others things will need adding so it can have a lot of the features which torrent trader has.
Move the announce to the actual plugin folder.(it is in the template folder so the announce can use permalinks)

= Things need fixing or adding: =

Most Active Torrents widget needs fixing.
Pagination needs adding for torrent table, peers list and a few other things. (Will try to add in next release)

== Installation ==
= To Install: =

1. Download WP-Trader 
2. Unzip the file into a folder on your hard drive
3. Upload `/wp-trader/` folder to the `/wp-content/plugins/` folder on your site
4. Visit your WordPress admin panel -> Plugins and activate WP-Trader
5. Click on WP-Trader and setup the plugin, most settings are already set default but may need some fine tuning for your needs
6. If you see an error about the announce.php please click the button to move it to the theme folder. If it cannot be moved then please locat it in the `/wp-content/plugins/wp-trader/templates/` and move it to your current theme folder
7. You must update your permalinks to use either "Month and name" option or "Day and name" option or "Custom Structure" or if your using Wordpress 3.3 and above you can use the "Post name" option just as long as you have /%postname%/ at the end of the url in order for the announce and scrape to work. Make sure that the post which is made for the announce and scrape keep the names they have because of the limitations of the bittorrent protocol.
8. At the moment until a css option is added for the wordpress editor in torrent upload the editor will only show up correctly on light color themes, so if it does not show correctly then please disable it on the settings page.
= Usage =
This section will be updated in a later release

== Frequently Asked Questions ==

= Will WP-Trader work with a 'standard' WordPress theme? =
Yes, the plugin has been tested on a few themes to see if there is any problems so I would not see why it would not work on any standard theme.

= Can I use WP-Trader on an existing WordPress Blog? =
Yes

= Does WP-Trader use any shortcodes? =
Yes, below is a list of shortcode.

Most Active Torrents
[most_active mostactive="most_active_template"] [/most_active]

Latest Uploads
[latest_uploaded_torrents latestuploads="latest_uploads_template"] [/latest_uploaded_torrents]

Seed Wanted
[seed_wanted_torrents seedwanted="seed_wanted_template"] [/seed_wanted_torrents]

Torrent Browse
[torrentbrowse torrent="torrent_browse"] [/torrentbrowse]

Torrent Upload
[torrentupload torrent_up="upload"] [/torrentupload]

Torrent Announce
[torrent_announce announce="announce_template"] [/torrent_announce]

Torrent Scrape
[torrent_scrape scrape="scrape_template"] [/torrent_scrape]

Download Box Of Torrent Post (Needs ID Of Torrent)
[torrentdescription torrent_descr="download-box" torrent_post_id="torrent id goes here"] [/torrentdescription]

Description Part Which Consist Of Tabbed Data (Needs ID Of Torrent Post)
[torrentdescription torrent_descr="container" torrent_post_id="torrent post id goes here"] [/torrentdescription]

== Screenshots ==

1. The main admin page
2. Some of the main options
3. The torrent options page with all the options collapsed
4. Some of the torrent options options

== CHANGELOG ==
= Version: beta .4.8 - 2012-04-5 =
* Added upload to user's profile.
* Added download to user's profile.
* Added ratio to user's profile.
* Added passkey to user's profile if site is set to members only and passkey tracking is used.
* Added reset passkey option to user's profile.
* Added option in admin panel to allow or not allow user to generate passkey on their profile.
* Added download banned option to user's profile.
* Added download banned check to download page.
* Added download banned check to announce. (probably should add it to torrent details and torrent browse if used)
* Added seed bonus to user profile.
* Added option in admin panel to turn seed bonus on and off.
* Added cleanup to make inactive torrents not show and update seeders and leechers. (probably will have a few bugs and will need some more testing)
* Added wordpress cron job for cleanup.
* Changed the cleanup setting in the admin panel to only allow to choose hourly, twice daily and daily for cleanup times.

= Version: beta .4.7.4 - 2012-04-5 =
* Added scrape on upload option to torrent upload page for the uploaders to choose if they want to scrape the torrent or not. (need to sort the upload to where it loads the page then shows what has been scraped)
* Added option in admin panel to turn off option for uploaders to choose not to scrape on upload.
* Fix bug in admin panel with scripts conflicting outside of the plugin.

= Version: beta .4.7.3 - 2012-03-14 =
* Sorted scrape on upload.
* Added scrape button in torrent details.
* Sorted missing argument in the help page.

= Version: beta .4.7.2 - 2012-02-26 =
* Added a help page in the admin panel to do away with the old help tab.
* Added a help icon for each option.
* Fixed on download, passkey not being added if that option is used.
* Fixed bug in Members Only Page Exclude option with not updating correctly.
* Fixed bug with memebers only exclude pages not working with some permalinks.

= Version: beta .4.7.1 - 2012-02-14 =
* Fixed bug where widgets would not open in admin panel.
* Fixed bug where main options would not save in admin panel.
* Fixed bug on torrent upload permission.
* Fixed display bug on Peers List page in admin panel.
* Fixed a few bugs in the announce. (probably a few more will need sorting after people test it)
* Changed torrent table options in admin panel to drag and drop.
* Changed options for freeleech in admin panel to only show if freeleech is enabled.
* Added option to track by ip if memebers only and made it to track by ip when not memebers only.(may be a bit buggy and probably needs a few things adding)

= Version: beta .4.7 - 2012-01-31 =
* Re-done the design of the admin panel.
* Cleaned up a bit of the code.

= Version: beta .4.6.1 - 2012-01-23 =
* Sorted memebrs only.
* Added in admin panel part to exclude pages from members only incase you want a page to show for everybody (will sort in next update a way to make it go to that page instead of redirect to login when people go to the index of the site).
* Added Uploader Only Classes option in admin panel when Uploaders Only is chosen.
* Added code to lock down the upload page if Uploaders Only option is chosen.
* Got rid of some code which was marked as to remove at later date.

= Version: beta .4.6 - 2012-01-10 =
* Fixed bug with help tags in admin panel where on some sites an error was being thrown on plugin activation.
* Fixed bug in widgets to show the correct torrents for each widget when logged in.
* Added login widget which shows some user stats when the user is logged in.
* Added footer to torrent table.
* Added option in admin panel to use header or footer or both in torrent table.

= Version: beta .4.5.2 - 2012-01-05 =
* Fixed bug in torrent-upload.php with short_open_tag.
* Fixed bug in torrent descrption which made it display wrong in some browsers.
* Fixed bug admi panel with warning if announce and scrape is not in the theme folder.
* Added free leech list in admin panel.
* Added options for free leech list in admin panel.
* Added the announce and scrape warning to each page in admin panel.

= Version: beta .4.5.1 - 2012-01-03 =
* Fixed bug where on some sites on plugin activation an error was being thrown and the system user was not being made.

= Version: beta .4.5 - 2012-01-03 =
* Fixed bug in announce which updated the peers table with wrong torrent id. (Site owners may have to move the new announce.php to their theme folder.)
* Added pagination to torrent table.
* Added pagination to peers list in admin panel.
* Styled peers list in admin panel to blend in more with wordpress.
* Added limit in admin panel for how many torrents to show on the torrent browse page.
* Added help entry in admin panel for torrent browse limit.

= Version: beta .4.4 - 2011-12-31 =
* Added peers list to admin panel.
* Added help tab in admin panel to each page with info on the options for the pages.

= Version: beta .4.3 - 2011-12-29 =
* Moved functions for torrent post out of torrent upload file and into its own file.
* Added class for WP-Trader in admin menu bar.
* Added submenu in admin menu bar.
* Sorted bug with upload when no nfo was selected it would error out.
* Added message in popup dialog when external torrents are uploaded.
* Added support to show NFO in png format. (Only available if GD is installed.)
* Added option in admin panel enable and disable NFO in png format. (Only available if GD is installed. Set to yes as default if GD installed.)

= Version: beta .4.2 - 2011-12-25 =
* NFO in upload is working.
* Added NFO tab to the post to display the NFO.
* Added option in admin panel to allow NFO upload which is set to yes by default.
* Added option in admin panel to show peer list which is set to yes by default.
* Added option in admin panel to show file list which is set to yes by default.

= Version: beta .4.1 - 2011-12-19 =
* Fixed bug in admin panel for moving scrape and announce.
* Added a new description editor for torrent upload page. (Only shows if using Wordpress Version 3.3 or higher.)
* Added option in admin panel to use new editor or old editor for torrent upload page. (Will add more options in next releases.)
* Updated number install instructions.
* Updated number 4 on the settings info on the admin index page.

= Version: beta .4 - 2011-12-12 =
* Changed Most Active Torrents widget (at the moment not working need to sort it out will try to push it out in next bug update).
* Changed Latest Uploads widget moved some code into the torrenttable function and added some options for it, still needs sorting a bit and some tweaking done to it.
* Added Seed Wanted widget moved some code into the torrenttable function and added some options for it, still needs sorting a bit and some tweaking done to it.
* Added some more options for the widgets.
* Removed a few rows from the torrents table in the db and added it to postmeta.
* Added a way to edit the torrent on the torrent post (still need to add more options to the editor).

= Version: beta .3 - 2011-11-26 =
* Added Most Active Torrents widget.
* Added Latest Uploads widget.
* Added Seed Wanted widget.
* Added widget options in admin panel.
* Added new shortcodes.
* Updated the FAQ with the shortcodes.

= Version: beta .2.2 - 2011-11-24 =
* Added scrape.
* Fixed bug in announce.
* Updated install instructions pay carefull attention to number seven.
* Fixed bug in torrent post not showing correctly.

= Version: beta .2.1 - 2011-11-23 =
* Fixed bug in admin area that would not allow options to be updated.
* Added agent bans to torrent options
* Cleaned up some of the admin code

= Version: beta .2 - 2011-11-23 =
* Added sub-menues to the admin menu
* Finished off the torrent upload
* Cleaned the code a bit and made a few small changes

= Version: beta .1 - 2011-11-14 =
* Initial Release