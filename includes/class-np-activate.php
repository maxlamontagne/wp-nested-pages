<?php
/**
* Plugin Activation
*/
class NP_Activate {


	public function __construct()
	{
		register_activation_hook( dirname( dirname(__FILE__) ) . '/nestedpages.php', [ $this, 'install' ] );
	}


	/**
	* Activation Hook
	*/
	public function install()
	{
		$this->checkVersions();
		$this->setOptions();
	}


	/**
	* Check Wordpress and PHP versions
	*/
	public function checkVersions( $wp = '3.9', $php = '5.3.0' ) {
		global $wp_version;
		if ( version_compare( PHP_VERSION, $php, '<' ) )
			$flag = 'PHP';
		elseif ( version_compare( $wp_version, $wp, '<' ) )
			$flag = 'WordPress';
		else 
			return;
		$version = 'PHP' == $flag ? $php : $wp;
		deactivate_plugins( basename( __FILE__ ) );
		
		wp_die('<p><strong>Nested Pages</strong> plugin requires'.$flag.'  version '.$version.' or greater.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
	}


	/**
	* Set Default Options
	*/
	public function setOptions()
	{
		if ( !get_option('nestedpages_menusync') ){
			update_option('nestedpages_menusync', 'sync');
		}
	}


}