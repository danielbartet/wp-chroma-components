<?php
// Add Social Share Count Column
function social_share_columns_head($defaults) {
  $defaults['social_shares'] = 'Engagement';
  return $defaults;
}
// fill with content
function social_share_columns_content($column_name, $post_ID) {
  if ($column_name == 'social_shares') {
      $url = get_the_permalink($post_ID);
      $shares = MasterShareCount::get_share_count($url);
      //$views2 = MasterPageViews::get_view_count($url);
      $split = explode('|', $shares);
      $split2 = explode(': ', $split[0]);
      $views = $split2[1];
      $viewsInt = intval( $views );
      update_post_meta($post_ID, 'total_views', $views);
      update_post_meta($post_ID, 'int_views', $viewsInt);
      $meta = get_post_meta($post_ID, 'total_views', true);
      echo $shares . "<span class='social-button'>See Stats</span>";
      //echo 'Views: ' . $views . ' | meta:' . $meta . ' | ' . $views2 . ' ////' . $shares . "<span class='social-button'>See Stats</span>";
  }
}

// make sortable
function fsj_engagement_column_register_sortable($columns) {
  $columns['social_shares'] = 'social_shares';
  return $columns;
}

//query

function fsj_engagement_column_orderby( $query ) {
  if( ! is_admin() )
      return;

  $orderby = $query->get( 'orderby');

  if( 'social_shares' == $orderby ) {
    $query->set('meta_key','total_views');
    $query->set('orderby','meta_value_num');
  } 
}



/* This does not work. Keeping for posterity
function fsj_engagement_column_orderby($orderby, $wp_query) {

  global $wpdb;

  $_orderby = $wp_query->get( 'orderby' );
  $_order   = $wp_query->get( 'order' );

  //echo $_orderby . ' vs ' . $wp_query->get( 'orderby' );
  //echo '<script>alert("Welcome to Geeks for Geeks")</script>';
  
  if ('social_shares' == @$wp_query->query['orderby'])
      $orderby = "(SELECT CAST(meta_value as decimal) FROM $wpdb->postmeta WHERE post_id = $wpdb->posts.ID AND meta_key = 'total_views') " . $_order;

  return $orderby;
}*/







add_filter('manage_posts_columns', 'social_share_columns_head');
add_action('manage_posts_custom_column', 'social_share_columns_content', 10, 2);
add_filter('manage_edit-post_sortable_columns', 'fsj_engagement_column_register_sortable');
//add_filter('posts_orderby', 'fsj_engagement_column_orderby', 10, 2);

add_action( 'pre_get_posts', 'fsj_engagement_column_orderby' );