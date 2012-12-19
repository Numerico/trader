<?php
/*
  * Holds the Admin Bar Menu Class
  * @package WP-Trader
  */

class WPTraderMenu {
  
  function WPTraderMenu(){
    add_action('admin_bar_menu', array($this, "wptrader_links"));
  }

  /**
   * Add's new global menu, if $href is false menu is added but registred as submenuable
   *
   * $name String
   * $id String
   * $href Bool/String
   *
   * @return void
   * @author Janez Troha
   **/

  function add_root_menu($name, $id, $href = FALSE)
  {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
      return;

    $wp_admin_bar->add_menu( array(
    'id' => $id,
    'title' => $name,
    'href' => $href ) );
  }

  /**
   * Add's new submenu where additinal $meta specifies class, id, target or onclick parameters
   *
   * $name String
   * $link String
   * $root_menu String
   * $meta Array
   *
   * @return void
   * @author Janez Troha
   **/
  function add_sub_menu($name, $link, $root_menu, $meta = FALSE)
  {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
      return;
    
    $wp_admin_bar->add_menu( array(
    'parent' => $root_menu,
    'title' => $name,
    'href' => $link,
    'meta' => $meta) );
    
  }

  function wptrader_links() {
    $this->add_root_menu("WP-Trader", "wptrader");
	$this->add_sub_menu("Index", admin_url( "admin.php?page=wp-trader" ), "wptrader");
    $this->add_sub_menu("Options Main", admin_url( "admin.php?page=wptrader-options-main" ), "wptrader");
    $this->add_sub_menu("Options Torrent", admin_url( "admin.php?page=wptrader-options-torrent" ), "wptrader");
    $this->add_sub_menu("Options Widgets", admin_url( "admin.php?page=wptrader-options-widgets" ), "wptrader");
  }

}
add_action("init", "WPTraderMenuInit");
function WPTraderMenuInit() {
    global $WPTraderMenu; $WPTraderMenu = new WPTraderMenu();
}
?>