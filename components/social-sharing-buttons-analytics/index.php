<?php
add_action('plugins_loaded', 'chroma_social_analytics');
function chroma_social_analytics() {
  include plugin_dir_path( __FILE__ ) . 'inc/share-counter-interface.php';
  include plugin_dir_path( __FILE__ ) . 'inc/classes/facebook-share-count.php';
  include plugin_dir_path( __FILE__ ) . 'inc/classes/twitter-share-count.php';
  include plugin_dir_path( __FILE__ ) . 'inc/classes/master-share-count.php';
  include plugin_dir_path( __FILE__ ) . 'views/analytics-view.php';
  include plugin_dir_path( __FILE__ ) . 'views/wordcount-view.php';
  include plugin_dir_path( __FILE__ ) . 'views/default.php';
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'chroma', '/share-count', array(
    'methods' => 'POST',
    'callback' => array('FacebookShareCount', 'get_share_count_endpoint'),
    'permission_callback' => '__return_true',
  ));
});

add_action( 'rest_api_init', function () {
  register_rest_route( 'chroma', '/social-count', array(
    'methods' => 'POST',
    'callback' => 'MasterShareCount::update_share_count_endpoint',
    'permission_callback' => '__return_true',  
));
});

add_action( 'rest_api_init', function () {
  register_rest_route( 'chroma', '/social-get-url-from-id', array(
    'methods' => 'POST',
    'callback' => 'MasterShareCount::get_url_from_id',
    'permission_callback' => '__return_true',  
));
});
//app data
add_action( 'wp_footer', 'chroma_localize_data', 11);
function chroma_localize_data() {
  echo "<script>var chromaApp = {fbAppID: ".get_option('fb_api_key')."}</script>";
}

function save_post_permalinks($id) {
  $cached_permalink = str_replace('http://34.227.68.226', 'https://idropnews.com', get_the_permalink($id));
  update_post_meta($id, '_chroma_permalink', $cached_permalink);
}

add_action('save_post', 'save_post_permalinks', 100);
