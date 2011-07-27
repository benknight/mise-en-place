<?php 

/**
 * Custom [gallery] shortcode
 */
remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'galleria_shortcode' );
function galleria_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'image_size' => 'large'
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
		
		$output .= "
			<article class='galleria-item'>
				<h1>{$attachment->post_title}</h1>
				{$image}
				<p>{$attachment->post_content}{$more_link}</p>
			</article>	
		";
	
	}
	
	$output .= '</div><!-- #galleria -->';
	return $output;
}