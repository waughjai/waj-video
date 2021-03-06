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
					$types[] = [ 'type' => 'mp4', 'url' => getSourceFromID( $atts[ 'mp4' ] ) ];
					unset( $atts[ 'mp4' ] );
				}
				if ( array_key_exists( 'webm', $atts ) )
				{
					$types[] = [ 'type' => 'webm', 'url' => getSourceFromID( $atts[ 'webm' ] ) ];
					unset( $atts[ 'webm' ] );
				}
				if ( array_key_exists( 'poster-id', $atts ) )
				{
					$atts[ 'poster' ] = getPosterSourceFromID( $atts[ 'poster-id' ], 'large_medium' );
					unset( $atts[ 'poster-id' ] );
				}
				$video = new HTMLVideo( $types, $atts );
				return $video->getHTML();
			}
		);

		function getSourceFromID( string $id )
		{
			return wp_get_attachment_url( $id );
		}

		function getPosterSourceFromID( string $id, string $size )
		{
			$image = wp_get_attachment_image_src( intval( $id ), $size );
			return $image[ 0 ];
		}
	}
?>
