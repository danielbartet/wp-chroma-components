<?php

function chroma_register_signup_widget() {
  register_widget( 'signupWidget' );
}
add_action( 'widgets_init', 'chroma_register_signup_widget' );

class signupWidget extends WP_Widget {

  function __construct() {
    $widget_options = array(
      'classname' => 'signupWidget',
      'description' => 'Displays a newsletter signup box that logs entries in wp database.',

    );
    // Instantiate the parent object
    parent::__construct( false, 'Sign Up' );
  }

  function widget( $args, $instance ) {
     $title = apply_filters( 'widget_title', $instance[ 'title' ] );
     $copy = apply_filters( 'widget_title', $instance[ 'copy' ] );
     $sticky = ($instance[ 'sticky' ]) ? 'true' : 'false';
     $willStick = ($sticky === 'true') ? ' sticky' : null;
		// Widget output
    echo '<div class="signup_sidebar'.$willStick.'">
    		<div class="ball">
    			<!-- sign up form with html validation -->
    			<form id="subscribe" class="signup_sidebar--form" method="post">
    				<label id="errorMessage" class="signup_sidebar--label">'.$title.'</label>
            <span id="errorMessage2" class="signup_sidebar--desc">'.$copy.'</span>
    				<input id="subscribeEmail" type="email" pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$" name="email" required minlength="6" class="signup_sidebar--input" placeholder="you@site.com"></input>
    				<button type="submit" class="signup_sidebar--submit">
    					<span class="signup_sidebar--submit--span">Subscribe</span>
    				</button>
    			</form>
    		</div>
    	</div>';
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'copy' ] = strip_tags( $new_instance[ 'copy' ] );
    $instance[ 'sticky' ] = strip_tags( $new_instance[ 'sticky' ] );
    return $instance;
	}

	function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $copy = ! empty( $instance['copy'] ) ? $instance['copy'] : '';
    $sticky = ! empty( $instance['sticky'] ) ? $instance['sticky'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
      <br>
      <label for="<?php echo $this->get_field_id( 'copy' ); ?>">Copy:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'copy' ); ?>" name="<?php echo $this->get_field_name( 'copy' ); ?>" value="<?php echo esc_attr( $copy ); ?>" />
      <br>
      <label for="<?php echo $this->get_field_id( 'sticky' ); ?>">Sticky?</label>
      <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'sticky' ); ?>" <?php checked( $sticky , 'on'); ?> name="<?php echo $this->get_field_name( 'sticky' ); ?>" />
    </p><?php
  }
}
