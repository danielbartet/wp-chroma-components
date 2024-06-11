<?php
//custom filters for content
global $post;

function sanitize_html($html) {
    // Remover tags problemáticas o arreglar HTML mal formado
     $html = str_replace(array('&nbsp;', '&Acirc;', '&acirc;', '&lt;', '&gt;'), array(' ','','', '<', '>'), $html);
    $html = str_replace('€”', '—', $html);
    $html = str_replace('&#128;&#148;', '—', $html);

    $html = str_replace('â€™', '’', $html);
    $html = str_replace('â€œ', '“', $html);
    $html = str_replace('â€�', '”', $html);

    if (function_exists('tidy_parse_string')) {
        $config = array(
            'indent' => true,
            'output-xhtml' => true,
            'wrap' => 200
        );
        $tidy = tidy_parse_string($html, $config, 'utf8');
        $tidy->cleanRepair();
        $html = $tidy->value;
    }

    return $html;
}

//filter for view as one page slider options
function convert_multipage_post( $content ) {
  $content = str_replace('<!--nextpage-->', '', $content);
  $content = preg_replace('/<p>\s*(<script.*>*.<\/script>)\s*<\/p>/iU', '\1', $content);
  $content = preg_replace('/<p>\s*(/<!--(.|\s)*?-->/)\s*<\/p>/iU', '\1', $content);
  return $content;
}

if (get_option('comments_button') == 'yes') {
  function add_comments_icon($content) {
      global $post, $multipage, $page, $numpages;
      try {
        if(empty($content) || (!is_single()) || ( get_post_type( get_the_ID() ) != 'post' ) || has_category('gallery') || ($multipage && $page !== $numpages) )
          return $content;
        //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        //$content = htmlentities($content, ENT_QUOTES, 'UTF-8');
	$content = sanitize_html($content); 
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $comment = $dom->createElement('button');
        $comment_text = $dom->createTextNode("Comment");
        $comment->setAttribute('class', 'comments-icon');
        $post_id = get_the_ID($post);
        $comment->appendChild($comment_text);
        if (get_bloginfo('name') == 'iDrop News') {
          $count = $dom->createElement('span');
          $count->setAttribute('class','comments-count disqus-comment-count');
          $count->setAttribute('data-disqus-identifier', "idropnews-$post_id");
          $comment->appendChild($count);
        }
        //position comment button
        $ps = $dom->getElementsByTagName('p');
        if ($ps->length < 2) {
          return $content;
        }
        if ($ps->length == 2) {
          $targetP = $ps[($ps->length) - 1];
        } else {
          $targetP = $ps[($ps->length) - 2];
        }
        $targetP->parentNode->insertBefore($comment, $targetP);
        $content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
        return $content;
      } catch(Exception $e) {
        if(!$e->getMessage().contains('figure')) {
          echo $e->getMessage();
        }
      }
  }
  add_filter( 'the_content', 'add_comments_icon', 99 );
}

//strip unwanted stuff from content
function chroma_custom_content_filter( $content ) {
  //mb_internal_encoding("UTF-8");
  //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
 //$content = htmlspecialchars($content, ENT_COMPAT | ENT_HTML401, 'UTF-8');
// $content =  htmlentities($content, ENT_QUOTES | ENT_HTML401, 'UTF-8');
  if($content){
  $dom = new DOMDocument();
  $content = sanitize_html($content);
 error_log("##############");
  error_log($content);
   libxml_use_internal_errors(true);
  //$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  $dom->loadHTML($content);
   $errors = libxml_get_errors(); // Obtener los errores
  foreach ($errors as $error) {
    // Procesar o registrar los errores
    error_log("LibXML error: {$error->message}\n");
  }
  libxml_clear_errors();

  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .*\s*\/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<script.*?>.*?<\/script>)\s*<\/p>/is', '\1', $content);
  $content = preg_replace('/<p>\s*(<iframe.*?>.*?<\/iframe>)\s*<\/p>/is', '\1', $content);
  $content = preg_replace('/<p>\s*(<blockquote.*?>.*?<\/blockquote>)\s*<\/p>/is', '\1', $content);
  $content = preg_replace('/CONCLUSION/', 'Conclusion', $content);
  $content = str_replace(['text-align: justify;', 'text-align: center;', 'text-transform: uppercase;'], '', $content);
  $content = str_replace('<p>&nbsp;</p>', '', $content);
  $content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
  $content = str_replace('<p></p>', '', $content);

  $content = $dom->saveHTML();

  $content = preg_replace(['/^<!DOCTYPE.+?>/', '/<html>/', '/<\/html>/', '/<body>/', '/<\/body>/'], ['', '', '', '', ''], $content);
  }
  return $content;
}
add_filter( 'the_content', 'chroma_custom_content_filter', 99 );

/**
* Add Next Page/Page Break Button
* in WordPress Visual Editor
*
* @link https://shellcreeper.com/?p=889
*/
function my_add_next_page_button( $buttons, $id ) {

   /* only add this for content editor */
   if ( 'content' != $id )
       return $buttons;

   /* add next page after more tag button */
   array_splice( $buttons, 13, 0, 'wp_page' );

   return $buttons;
}
/* Add Next Page Button in First Row */
add_filter( 'mce_buttons', 'my_add_next_page_button', 1, 2 ); // 1st row

function related_a_tag($content) {
    if(empty($content) || (!is_single()) || ( get_post_type( get_the_ID() ) != 'post' ) )
      return $content;
    //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    //$content = htmlentities($content, ENT_QUOTES, 'UTF-8');
    $dom = new DOMDocument();
    $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $a = $dom->getElementsByTagName('a');
    if ($a->length <= 0)
    {
      return $content;
    }
    foreach($a as $a_tag) {
      if(stripos($a_tag->textContent, 'Related') === 0)
      {
        $a_tag->setAttribute('class', 'hg_related');
        //$dom->saveHTML($a_tag);
      }
    }
    $content = $dom->saveHTML();
    return $content;
}
add_filter( 'the_content', 'related_a_tag' );
