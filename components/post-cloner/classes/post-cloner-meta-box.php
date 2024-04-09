<?php
abstract class Post_Cloner_Meta_Box
{
  //adds meta box width duplication toggle
  public static function add() {
    add_meta_box(
      'post_duplicator_meta_box_1',
      'Post Duplication',
      [self::class, 'html'],
      'post',
      'side',
      'core'
    );
  }

  //clones a post & its meta data
  public static function clone_post($post_id, $clone_category) {
      $clone_category = (empty($clone_category)) ? get_option('default_clone_cat') : $clone_category;
      $title = get_the_title($post_id);
      $parent_post = get_post($post_id);
      $post = array(
        'post_title' => $title,
        'post_content' => $parent_post->post_content,
        'post_status' => 'Draft',
        'post_type' => $parent_post->post_type,
        'post_author' => $parent_post->post_author,
        'post_date' => $parent_post->post_date,
        'post_excerpt' => $parent_post->post_excerpt
      );

      //insert a new post into the database
      $duplicat_post_id = wp_insert_post($post);

      //deep copy all custom post meta data
      $custom_fields = get_post_custom($post_id);
      foreach ($custom_fields as $key => $values) {
          foreach($values as $value) {
            add_post_meta($duplicat_post_id, $key, $value);
          }
      }

      //update cloned post with a custom post meta field that stores it's original counterpart's ID, to be used as a canonical reference
      update_post_meta($duplicat_post_id, 'canonical_reference', $post_id);

      //set the categories for the cloned post
      update_option('default_clone_cat', $clone_category );
      $clone_category = get_cat_ID($clone_category);
      wp_set_post_categories($duplicat_post_id, array( $clone_category ), false);

      //save a reference to the clones
      $existing_clones =  (is_array(get_post_meta($post_id, 'clonez', true) )) ? get_post_meta($post_id, 'clonez', true) : array();
      array_push($existing_clones, $duplicat_post_id);
      update_post_meta($post_id, 'clonez', $existing_clones );

    //return the editing url for redirection
    return get_site_url() .'/wp-admin/post.php?post='.$duplicat_post_id.'&action=edit';
  }

  //evaluations clone state, if possible updates meta data and clones post
  public static function post_clone_execute($post_id)
  {
    if(empty($post_id))
      $post_id = $_POST['post_id'];

    $reponse = array();

    $clone_category = ( isset($_POST['clone_category']) ) ? $_POST['clone_category'] : null;

    if ( isset($_POST['post_duplicator_field']) )  {
      //update parent custom post meta boolean indicating that this post has been cloned
      update_post_meta($post_id, 'has_been_cloned', $_POST['post_duplicator_field']);
      $duplicat_post_url = self::clone_post($post_id, $clone_category);
      $response['message'] = "Cloned! Redirecting you to the clone...";
      $response['post_url'] = $duplicat_post_url;
    }
    else
    {
      $response['message'] = "Error Cloning!";
      $response['post_url'] = "";
    }
    return $response;
  }

 //function used to save the canonical
  public static function canonical_save() {
     $no_canonical = ( isset($_POST['no_canonical']) ) ? $_POST['no_canonical'] : null;
     update_post_meta(get_the_ID(), 'no_canonical', $no_canonical);
     if($no_canonical == "true")
      update_post_meta(get_the_ID(), 'canonical_reference', null);
  }

  //function used to save the post sync
   public static function post_sync_save($post_id) {
      $post_sync = ( isset($_POST['post_sync']) ) ? $_POST['post_sync'] : null;
      update_post_meta($post_id, 'post_sync', $post_sync);
      if( $post_sync != 'true')
        return;
      $clonez = get_post_meta($post_id, 'clonez', true);
      $clonez = array_filter($clonez, function($clone) {return (!empty($clone) && $clone != NULL); });
      if (count($clonez) <= 0)
        return;
      $title = get_the_title($post_id);
      $parent_post = get_post($post_id);

      foreach ($clonez as $ref) {
        if( get_post_status($ref) != 'trash' && get_post_status($ref) != false ) {
          $new_ref_data = array(
            'ID' => $ref,
            'post_title' => $title,
            'post_content' => $parent_post->post_content,
            'post_author' => $parent_post->post_author,
            'post_date' => $parent_post->post_date
          );
          wp_update_post( $new_ref_data );
  //       //deep copy all custom post meta data
  //       // $custom_fields = get_post_custom($ref);
  //       // foreach ($custom_fields as $key => $values) {
  //       //     foreach($values as $value) {
  //       //       add_post_meta($ref, $key, $value);
  //       //     }
  //       // }
  //       //set the posts category
  //       // $clone_category = get_option('default_clone_cat');
  //       // $clone_category = get_cat_ID($clone_category);
  //       // wp_set_post_categories($ref, array( $clone_category ), false);
      }
    }
  }



  //meta box html & js
  public static function html($post)
  {
    ?>
  <?php
    echo '<div id="postClone"></div>';
    $value = get_post_meta($post->ID, 'has_been_cloned', true);
    if ($value == "true") { ?>
      <label for="post_duplicator_field">
        This post was previously cloned.
      </label>
    <?php } else { ?>
      <label for="post_duplicator_field">
        Clone Post
      </label>
      <?php
    } ?>
    <br><br>
      <input type="text" class="hidden" name="post_id" value="<?php echo $post->ID?>"/>
      <!-- category selection -->
      <select id="clone_cat_select" name="clone_category">
        <?php
        $allCats = get_categories();
        foreach($allCats as $cat)
        {
          echo '<option value="'.$cat->name.'"'.selected(get_option('default_clone_cat'), $cat->name).'>'.$cat->name.'</option>';
        }
        ?>
      </select>
      <input class="button button-primary button-large" type="button" name="post_duplicator_field" id="post_duplicator_field" value="Clone"/><br><br>
      <hr/>

      <!-- canonical selection -->
      <?php $no_canonical = get_post_meta(get_the_ID(), 'no_canonical', true);
      ?>
      <input type="checkbox" name="no_canonical" id="no_canonical" value="true" <?php checked($no_canonical, "true"); ?> />
      <label>Disable Canonical Reference</label>
      <script type="text/javascript" >
      //ajax clone script
        jQuery(document).ready(function($) {

          //execute post data send and responses
          $('#post_duplicator_field').click( function()
            {
              jQuery.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php",
                data : {
                  'action': "post_clone_execute",
                  'post_duplicator_field': 'true',
                  'post_id': '<?php echo $post->ID?>',
                  'clone_category':  $('#clone_cat_select').val()
                },
                success: function(response) {
                  console.log(response['message']);
                  //redirect user to cloned post draft via pop up
                  var postCloneURL = response['post_url'],
                      postClone = document.getElementById('postClone'),
                      postCloneBoxStyle = 'z-index: 9999; background: white; position: fixed; top: 45%; left: 50%; right: 50%; height: 100px; width: 200px; padding: 20px; display: flex; flex-direction: column; justify-content: space-evenly;  box-shadow: 0px 0px 50rem 50rem rgba(0,0,0,.5);',
                      postCloneStayHere = document.createElement('div');
                  console.log(postCloneURL);
                  postCloneStayHere.setAttribute('class', 'button button-primary button-large');
                  postCloneStayHere.innerHTML = 'Stay Here';
                  postClone.setAttribute('style', postCloneBoxStyle);
                  postClone.innerHTML = '<a href="'+postCloneURL+'" id="postCloneURL" style="display: block;" class="button button-primary button-large">Go To Clone</a>';
                  postClone.appendChild(postCloneStayHere);

                  postCloneStayHere.addEventListener('click',
                    function() {
                        postClone.setAttribute('style', 'display: none;');
                    }
                  );
                }
            });
           });
          });
    </script>
    <!-- post sync selection -->
    <?php
      $post_synced = get_post_meta(get_the_ID(), 'post_sync', true);
    ?>
    <br />
    <input type="checkbox" name="post_sync" id="post_sync" value="true" <?php checked($post_synced, "true"); ?> />
    <label>Post Sync</label>
    <br />
    <?php
    function post_clone_links() {
      $clonez = get_post_meta(get_the_ID(), 'clonez', false);
      $clonez = array_filter($clonez, function($clone) {return (!empty($clone) && $clone != NULL); });
      if (count($clonez) > 0) {
        foreach($clonez  as $clone) {
          echo '<div><a href="'. get_the_permalink($clone) .'" target="_blank">Go to clone: '.$clone.'</a></div> ';
        }
      }
      // $clonez = get_post_meta(get_the_ID(), 'clonez');
      // $clonez = array_filter($clonez, function($clone) {return (!empty($clone) && $clone != NULL); });
      // $clonez = $clonez[0];
      $post_sync = get_post_meta(get_the_ID(), 'post_sync', true);
    }
    post_clone_links();
    ?>
  <?php }
}

//invoke duplication method callbacks to add meta box and ajax action callback
add_action('add_meta_boxes', ['Post_Cloner_Meta_Box', 'add']);
add_action( 'wp_ajax_post_clone_execute',  'post_clone_execute' );
add_action( 'save_post', ['Post_Cloner_Meta_Box', 'canonical_save'] );
add_action( 'save_post', ['Post_Cloner_Meta_Box', 'post_sync_save'] );

//execution for post editing screen via AJAX
function post_clone_execute() {
  global $post;
  $response = Post_Cloner_Meta_Box::post_clone_execute($post->post_id);
  wp_send_json($response);
}

//execute for all posts action row
function post_clone_action() {
  if (! ( isset( $_GET['post_id']) || isset( $_POST['post_id'])  || ( isset($_REQUEST['action']) && 'post_clone_action' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }
  $post_id = (isset($_GET['post_id']) ? absint( $_GET['post_id'] ) : absint( $_POST['post_id'] ) );
  $result = Post_Cloner_Meta_Box::clone_post($post_id, null);
  echo 'Redirecting you to the clone...';
  wp_redirect( $result );
  exit;
}
add_action( 'admin_action_post_clone_action', 'post_clone_action' );


$category = get_option('default_clone_cat');
//callback for post_row_action filter display action link for clone on all posts action row
function post_clone_action_link($actions, $category)
{
  global $post;
  $actions['post_clone_action'] = '<a href="admin.php?action=post_clone_action&post_id='.$post->ID.'">Clone</a>';
  return $actions;
}
add_filter('post_row_actions', 'post_clone_action_link', 10, 2);
