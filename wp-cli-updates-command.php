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
	 * @synopsis <datum> [--group-by=<post-arg>] [--period=<period>] [--start-date=<yyyy-mm-dd>] [--end-date=<yyyy-mm-dd>] [--format=<format>]
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

			WP_CLI::success('Plugin updates refreshed');
		}
	}

	function check_themes()
	{
		$themes = get_theme_updates();
		
		if ( ! empty( $themes ) ) {
			
			WP_CLI::success('Theme updates refreshed');
		}
	}

}

WP_CLI::add_command( 'updates', 'Updates_Command' );
