<?php 

/**
 * Custom [gallery] shortcode
 */
remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'galleria_shortcode' );
function galleria_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'image_size' => 'large',
		'items_wrap' => '<article class="galleria-item"><h1>%1$s</h1>%2$s<p>%3$s</p></article>'
	), $atts ) );
	
	global $post;
	
	$attachments = get_children( array( 
		'post_parent' => $post->ID, 
		'post_type' => 'attachment', 
		'post_mime_type' => 'image', 
		'orderby' => 'menu_order', 
		'order' => 'ASC', 
		'numberposts' => 999
	));
	
	if ( empty( $attachments ) )
		return '';

	$output = '<div id="galleria">';
	
	foreach ( $attachments as $id => $attachment ) {
		
		$image = wp_get_attachment_image( $id, $image_size );
		$custom = get_post_custom( $id );
		$more_link = empty( $custom['more-link'] ) ? '' : " <a class='more' href='{$custom['more-link'][0]}'>More</a>";
		
		$output .= sprintf( 
			$items_wrap,
			$attachment->post_title,
			$image,
			$attachment->post_content
		);	
	}
	
	$output .= '</div><!-- #galleria -->';
	return $output;
}