<?php

add_action( 'init', 'Landing_Page_Holder_cpt',100 );
add_action( 'widgets_init', 'DHbuildpress_sidebars' );
$no_slug = get_option('dhlp_hide_slug',FALSE);

function Landing_Page_Holder_cpt() {
	$slug = get_option('dhlp_slug','l');

	register_post_type( 'landing_page', array(
	  'labels' => array(
		'name' => 'Landing Pages',
		'singular_name' => 'Landing Page',
	   ),
	  'description' => 'Creates Landing Pages and holders for setting Local Data',
	  'public' => true,
	  'menu_position' => 20,
	  'supports' => array( 'title','editor', 'page-attributes', 'excerpt', 'thumbnail' ),
	  'exclude_from_search' => false,
	  'hierarchical' => true,
	  'rewrite' => array("slug" => $slug,'with_front' =>true),
	  //'rewrite' => false,
	  'capability_type'      => 'edit_DH_landing_page'	,
      'capabilities' => array(
            'read_post' => 'edit_DH_landing_page',
            'publish_posts' => 'edit_DH_landing_page',
            'edit_posts' => 'edit_DH_landing_page',
            'edit_others_posts' => 'edit_DH_landing_page',
            'delete_posts' => 'edit_DH_landing_page',
            'delete_others_posts' => 'edit_DH_landing_page',
            'read_private_posts' => 'edit_DH_landing_page',
            'edit_post' => 'edit_DH_landing_page',
            'delete_post' => 'edit_DH_landing_page',
            'edit_pages' => 'edit_DH_landing_page',
            'delete_pages' => 'edit_DH_landing_page',
            'edit_page' => 'edit_DH_landing_page',
            'delete_page' => 'edit_DH_landing_page'
    	),

  ));
}

if($no_slug){
	/**
	 * Remove the slug from published post permalinks. Only affect our custom post type, though.
	 */
	function dhlp_remove_cpt_slug( $post_link, $post ) {

	    if ( 'landing_page' === $post->post_type && 'publish' === $post->post_status ) {
	        $post_link = str_replace( '/l/', '/', $post_link );
	    }

	    return $post_link;
	}
	add_filter( 'post_type_link', 'dhlp_remove_cpt_slug', 10, 2 );


	/**
	 * Have WordPress match postname to any of our public post types (post, page, landing_page).
	 * All of our public post types can have /post-name/ as the slug, so they need to be unique across all posts.
	 * By default, WordPress only accounts for posts and pages where the slug is /post-name/.
	 *
	 * @param $query The current query.
	 */
	function dhlp_add_cpt_post_names_to_main_query( $query ) {

		// Bail if this is not the main query.
		if ( ! $query->is_main_query() ) {
			return;
		}

		// Add CPT to the list of post types WP will include when it queries based on the post name.
		$query->set( 'post_type', array( 'post', 'landing_page', 'page' ) );
	}
	if(!is_admin()){
		add_action( 'pre_get_posts', 'dhlp_add_cpt_post_names_to_main_query' );
	}
}




add_filter( 'default_content', 'dhlp_editor_content', 10, 2 );

function dhlp_editor_content( $content, $post ) {
	if($post->post_parent == 0 && $post->post_type == 'landing_page'){
        $content = '[lp-children]';
    	return $content;
    }
    else{ return;}
}

function DHbuildpress_sidebars() {

	register_sidebar(
		array(
			'name'          => _x( 'Landing Page Sidebar', 'backend', 'buildpress_wp' ),
			'id'            => 'lp-sidebar',
			'description'   => _x( 'Sidebar on the LandingPage layout.', 'backend', 'buildpress_wp' ),
			'class'         => 'lp  sidebar',
			'before_widget' => '<div class="widget  %2$Vc03gi0o2fkr  push-down-30">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>'
		)
	);
}


function add_dh_caps() {

  	$Vodachviow4f = get_role( 'administrator' );
    $Vodachviow4f->add_cap( 'edit_DH_landing_page' );


}
add_action( 'admin_init', 'add_dh_caps');

function remove_dh_caps() {


	$V1dbxmv1knhd = get_role('editor');

	$V1dbxmv1knhd->remove_cap( 'edit_DH_landing_page');


}
add_action( 'admin_init', 'remove_dh_caps');


// add javascript so page defaults to
function add_landing_page_js(){
    wp_enqueue_script( 'lp-admin-script', '/wp-content/plugins/dh-localised/js/lp-admin-script.js','jQuery',NULL,true );
}
add_action( 'admin_init', 'add_landing_page_js');




?>
