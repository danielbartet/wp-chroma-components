<?php
/**
 * Template part for displaying Social Sharing Buttons
 */

class social_share_comp {
  function setButton($key) {
    $key = strtolower(str_replace('set' ,'',$key));
    ob_start();
    include plugin_dir_path( __DIR__ ) . "buttons/$key.php";
    $contents = ob_get_contents();
    ob_end_clean();
    echo $contents;
  }

  function __construct( $config = array(
    'setFacebook' => false,
    'setTwitter' => false,
    'setFlipboard' => false,
    'setReddit' => false,
    'setEmail' => false,
    'setComment' => false,
    'setDots' => false,
    'setCopyLink' => false,
    'setWhatsApp' => false,
    'setFBMessenger' => false,
    'setLinkedIn' => false,
    'setPinterest' => false,
    'setPocket' => false,
    'setPrint' => false,
    'classList' => null,
    'id' => null,
    'moreBox' => false,
    'dotsOverrideClass' => null,
    'urlOverride' => false
  )) {
      if (!empty($config['dotsOverrideClass'])) {
        echo '<button class="share-button '.$config['dotsOverrideClass'].'" data-share="more" aria-label="click for more sharing options" title="click for more sharing options"></button>';
      } else {
        $classList = (!empty($config['classList'])) ? $config['classList'] : '';
        $id = (!empty($config['id'])) ? $config['id'] : '';
        unset($config['classList']);
        unset($config['id']);
        global $post2;
        $urlOverride = ( !empty($config['urlOverride']) && $config['urlOverride'] === true) ?  "data-url-override='".get_the_permalink($post)."'" : '';
        $titleOverride = ( !empty($config['urlOverride']) && $config['urlOverride'] === true) ?  "data-title-override='".get_the_title($post)."'" : '';
      echo '<div class="social-sharing-controller '.$classList.'" id="'.$id.'"  '.$urlOverride.' '.$titleOverride.'>';
        foreach($config as $key => $value) {
           if ($value && !(in_array($key, array('moreBox', 'dotsOverrideClass', 'urlOverride')))) {
            $this->setButton($key);
          }
        }
      }

    echo '</div>';
    if (!empty($config['moreBox']) && $config['moreBox'] === true) {
      add_action('wp_footer', array($this, 'createMoreShareNodes' ), 100);
    }
  }
  function createMoreShareNodes() {
    echo '<div class="more-sharing" id="more-sharing"><span class="more-sharing-title">Social Sharing<span class="more-sharing-close" id="msc"></span></span>';
      $generic_config = array(
        'setFacebook',
        'setTwitter',
        'setFlipboard',
        'setReddit',
        'setEmail',
        'setComment',
        'setCopyLink',
        'setWhatsApp',
        'setFBMessenger',
        'setLinkedIn',
        'setPinterest',
        'setPocket',
        'setLine',
        'setPrint'
      );
      foreach($generic_config as $key) {
        echo '<div class="more-sharing-node">';
          $this->setButton($key);
        echo '</div>';
      }
    echo '</div>';
  }
}
