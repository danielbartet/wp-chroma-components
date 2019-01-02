<?php
wp_head();
global $ai_wp_data;
$ai_wp_data [AI_WP_DEBUGGING] |= AI_DEBUG_NO_INSERTION;
?>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <div class="cm-quiz-single">
    <aside class="cm-quiz" id="cm-quiz" data-id="<?php the_ID();?>" >
      <div class="cm-quiz-title-bar"><div class="cm-quiz-title"><?php the_title() ?></div><div class="cm-quiz-prog" id="cm-quiz-prog">0</div></div>
      <div class="cm-quiz-box">
          <?php the_content(); ?>
        <div class="cm-quiz-prompt">
          <div class="cm-quiz-prompt-box">
              <?php
                getChromaForm('Subscribe to See Results', 'Automatically enter for a chance to win a free 2018 MacBook Pro!', $cta = 'Subscribe', $placeholder = 'win@example.com', 'quiz-subscribe');
                $fbLoginDefault = new fb_login_button(array('context' => 'cm-quiz_fb-login', 'msg' => 'Facebook Login'));
              ?>
          </div>
        </div>
        <div class="cm-quiz-results" data-slide="slide-z">
          Results:
        </div>
        <div class="cm-quiz_timer"></div>
        <div id="cm-quiz-back" class="cm-quiz_nav-b">
          <div class="cm-quiz_nav-b-a cm-quiz_nav-b-a-b">
          </div>
        </div>
        <div id="cm-quiz-fwd" class="cm-quiz_nav-f">
          <div class="cm-quiz_nav-f-a cm-quiz_nav-f-a-f">
          </div>
        </div>
        </div>
        <?php $quizSocialShare = new social_share_component(
          array(
            'setFacebook' => true,
            'setTwitter' => true,
            'setEmail' => true,
            'setDots' => true,
            'moreBox' => true,
            'classList' => 'cm-quiz-share'
          )
        );
        $jstime = filemtime( plugin_dir_path( __DIR__ ) .'src/quiz-app.js' );
        $cssTime = filemtime( plugin_dir_path( __DIR__ ) .'src/style.sass' );
        $jsPath = plugin_dir_url('chroma_wp_components') . 'chroma_wp_components/dist/quiz.js?' . $jstime;
        echo '<link rel="stylesheet" href="'.plugin_dir_url("chroma_wp_components") . 'chroma_wp_components/dist/cmquiz.css?'.$cssTime.'" type="text/css" media="all"/>';
        echo "<script defer src='$jsPath'></script></script>";
        ?>
      </aside>
    </div>
  </div>
<?php wp_footer();
