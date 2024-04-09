<?php
// Add Social Share Count Column
function wordcount_columns_head($columns) {
    $_columns = [];

foreach( (array) $columns as $key => $label )
{
    $_columns[$key] = $label;
    if( 'title' === $key )
        $_columns['wordcount'] = __( 'Word Count' );  
}
return $_columns;




    
}


// fill with content
function wordcount_columns_content($column_name, $post_ID) {
  if ($column_name == 'wordcount') {
      global $post;
      $content = $post->post_content;
      $decode_content = html_entity_decode( $content );
      $filter_shortcode = strip_shortcodes( $decode_content );
      $remove_videos = preg_replace('/<figure class="wp-block-embed is-type-video is-provider-tiktok">(.*?)<\/figure>/s', '', $filter_shortcode);
    $remove_images = preg_replace('/<div class="wp-block-chroma-blocks-media-upload none">(.*?)<\/div>/s', '', $remove_videos);
    $double_remove_images = preg_replace('/<figure class="wp-block-image">(.*?)<\/figure>/s', '', $remove_images);
    //strips the html tags
    $strip_tags = wp_strip_all_tags( $double_remove_images, true );
    //counts the words
    $count = str_word_count( $strip_tags);
      $length = $count;

      update_post_meta($post_ID, 'word_length', $length);
      $meta = get_post_meta($post_ID, 'word_length', true);
      echo $meta  ;
      //echo 'Views: ' . $views . ' | meta:' . $meta . ' | ' . $views2 . ' ////' . $shares . "<span class='social-button'>See Stats</span>";
  }
}







// make sortable
function fsj_wordcount_column_register_sortable($columns) {
  $columns['wordcount'] = 'wordcount';
  return $columns;
}


//query

function fsj_wordcount_column_orderby( $query ) {
  if( ! is_admin() )
      return;

  $orderby = $query->get( 'orderby');

  if( 'wordcount' == $orderby ) {
    $query->set('meta_key','word_length');
    $query->set('orderby','meta_value_num');
  } 
}





add_filter('manage_posts_columns', 'wordcount_columns_head');

add_action('manage_posts_custom_column', 'wordcount_columns_content', 10, 2);
add_filter('manage_edit-post_sortable_columns', 'fsj_wordcount_column_register_sortable');

add_action( 'pre_get_posts', 'fsj_wordcount_column_orderby' );