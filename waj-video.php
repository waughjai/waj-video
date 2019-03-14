<?php

	/*
	Plugin Name:  WAJ Video
	Plugin URI:   https://github.com/waughjai/waj-scripts
	Description:  Easily generate video HTML.
	Version:      1.0.0
	Author:       Jaimeson Waugh
	Author URI:   https://www.jaimeson-waugh.com
	License:      GPL2
	License URI:  https://www.gnu.org/licenses/gpl-2.0.html
	Text Domain:  waj-video
	*/

	namespace WaughJ\WPScripts
	{
		require_once( 'vendor/autoload.php' );

		use WaughJ\HTMLVideo\HTMLVideo;

		add_shortcode
		(
			'upload-video',
			function( $atts )
			{
				$types = [];
				if ( array_key_exists( 'mp4', $atts ) )
				{
					$types = [ 'type' => 'mp4', getSourceFromID( $atts[ 'mp4' ] ) ];
					unset( $atts[ 'mp4' ] );
				}
				if ( array_key_exists( 'webm', $atts ) )
				{
					$types = [ 'type' => 'webm', getSourceFromID( $atts[ 'webm' ] ) ];
					unset( $atts[ 'webm' ] );
				}
				if ( array_key_exists( 'poster-id', $atts ) )
				{
					$atts[ 'poster' ] = getSourceFromID( $atts[ 'poster-id' ] ];
					unset( $atts[ 'webm' ] );
				}
				$video = new HTMLVideo( $types, $atts );
				return $video->getHTML();
			}
		);

		function getSourceFromID( string $id )
		{
			$image = wp_get_attachment_image_src( intval( $id ) );
			return $image[ 0 ];
		}
	}
?>
