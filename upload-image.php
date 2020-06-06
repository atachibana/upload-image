<?php
/**
 * Plugin Name:     Upload Image
 * Description:     Example block written with ESNext standard and JSX support – build step required.
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     atachibana
 *
 * @package         atachibana
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function atachibana_upload_image_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "atachibana/upload-image" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'atachibana-upload-image-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$editor_css = 'editor.css';
	wp_register_style(
		'atachibana-upload-image-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'style.css';
	wp_register_style(
		'atachibana-upload-image-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'atachibana/upload-image', array(
		'editor_script' => 'atachibana-upload-image-block-editor',
		'editor_style'  => 'atachibana-upload-image-block-editor',
		'style'         => 'atachibana-upload-image-block',
	) );

 	wp_enqueue_script(
		'handle_name',
		plugins_url( 'build/upload-image.js', __FILE__ ),
		array( 'jquery' ),
		filemtime( "$dir/build/upload-image.js" )		
	);
	$data = array(
		'upload_url' => admin_url( 'async-upload.php' ),
		'nonce'      => wp_create_nonce( 'media-form' ),
	);
	wp_localize_script( 'handle_name', 'data_name', $data );
}
add_action( 'init', 'atachibana_upload_image_block_init' );
