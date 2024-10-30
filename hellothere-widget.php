<?php
/**
 * Plugin Name: HelloThere widget
 * Plugin URI: https://www.hellothere.io
 * Description: This plugin adds HelloThere widget to the site.
 * Version: 0.1
 */

defined( 'ABSPATH' ) or die( 'Not allowed' );

define( 'HELLOTHERE_DOMAIN', 'https://www.hellothere.io' );

add_action( 'wp_enqueue_scripts', 'hellothere_embed_widget' );

function hellothere_embed_widget() {
	$widget_key = get_option( 'widget_key' );
	if ( $widget_key ) {
		wp_enqueue_script(
			'hellothere-widget',
			HELLOTHERE_DOMAIN . '/widget/' . $widget_key . '.js',
			array(),
			null,
			true
		);
	}
}

add_action( 'admin_init', 'hellothere_plugin_settings' );

function hellothere_plugin_settings() {
	register_setting( 'widget_settings', 'widget_key' );
}

add_action( 'admin_menu', 'hellothere_plugin_menu' );

function hellothere_plugin_menu() {
	global $_wp_last_object_menu;

	add_menu_page(
		'HelloThere Widget Settings',
		'HelloThere', 'administrator',
		'hellothere-widget-settings',
		'hellothere_settings_page',
		'dashicons-testimonial',
		$_wp_last_object_menu
	);
}

function hellothere_settings_page() { ?>
  <div class="wrap">
  <h1>HelloThere Widget Settings</h1>
  <br>
  You can get your widget key after creating a free account on our website: <a target="_blank" href="<?php echo HELLOTHERE_DOMAIN; ?>"><?php echo HELLOTHERE_DOMAIN; ?></a><br>
  Just add a new widget, make a few setup steps, and press the "Get code" button

  <form method="post" action="options.php">
      <?php settings_fields('widget_settings'); ?>
      <?php do_settings_sections('widget_settings'); ?>
      <table class="form-table">
          <tr valign="top">
          <th scope="row">Widget key</th>
          <td><input placeholder="Paste you widget key here" type="text" name="widget_key" value="<?php echo esc_attr( get_option( 'widget_key' ) ); ?>" /></td>
          </tr>
      </table>

      <?php submit_button(); ?>

  </form>
  </div>
<?php } ?>