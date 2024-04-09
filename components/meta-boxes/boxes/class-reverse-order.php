<?php

// class to add reverse metabox to editor screen
abstract class reverse_order {

  public static function add_box() {
    add_meta_box(
      'reverse-order',			// Unique ID
      'Reverse Order',		// Title
      'reverse_order::display_box',		// Callback function
      'post',					// Admin page (or post type)
      'side',					// Context
      'core'					// Priority
    );
  }

  public static function display_box( $post ) {
    // set selected to retrieve post meta data from database to be displayed / manipulated by select form below
    $selected = get_post_meta( $post->ID, 'reverse-order', true );
    ?>
    <p>
      <label for="chromma-toggle-ads">
        Select Order of Slider Block
      </label>
      <br />
      <br />
      <!-- select menu allowing editor to choose option; once option has been picked and 'Updated' via WP built in form POST method, it will run update_post_meta below -->
      <select class="widefat" name="reverse-order" id="reverse-order">
          <option value="ascending" <?php selected( $selected, 'ascending' ); ?>>Order starting from Length</option>
          <option value="descending" <?php selected( $selected, 'descending' ); ?>>Order starting from 1</option>
      </select>
    </p>
    <!-- declared a global variable to be used in store.js -->
    <script>
        var isReversed = "<?php echo $selected ?>";
        console.log('isReserved php: ',isReversed);
    </script>
  <?php
  }

  //check posted values
  public static function check_posted_values( $post ) {
    if ( isset( $_POST['reverse-order'] ) ) {
      update_post_meta( $post->ID, 'reverse-order', $_POST['reverse-order'] );
    }
  }

} ?>
