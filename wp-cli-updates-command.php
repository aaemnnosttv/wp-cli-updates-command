<?php
/**
 * @author aaemnnosttv
 */
class Updates_Command extends WP_CLI_Command
{


	/**
	 * Updates
	 *
	 * @subcommand check
	 */
	public function check( $args, $assoc_args ) {

		do_action('load-update-core.php');
		$this->check_plugins();
		$this->check_themes();
	}

	function check_plugins()
	{
		require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
		
		$plugins = get_plugin_updates();
		
		if ( ! empty( $plugins ) )
		{
			foreach ( (array) $plugins as $plugin_file => $plugin_data )
				plugins_api('plugin_information', array('slug' => $plugin_data->update->slug ));

			WP_CLI::success('Plugin updates refreshed.');
		}
		else
			WP_CLI::log('All plugins are up to date.');
	}

	function check_themes()
	{
		$themes = get_theme_updates();
		
		if ( ! empty( $themes ) ) {
			
			WP_CLI::success('Theme updates refreshed.');
		}
		else
			WP_CLI::log('Themes are up to date.');
	}

}

WP_CLI::add_command( 'updates', 'Updates_Command' );
