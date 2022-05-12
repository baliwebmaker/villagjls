<?php
/*//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );
*/
/*  DISABLE GUTENBERG STYLE IN HEADER| WordPress 5.9 */
function wps_deregister_styles() {
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );
remove_filter( 'render_block' , 'wp_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block' , 'gutenberg_render_layout_support_flag', 10, 2 );
/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
    // Remove from TinyMCE
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
/*--- EXTRA FUNCTIONS ---*/
function get_meta_value($value, $default) {
	if($value == '') {
			return $default;
		} else {
			return $value;
	}
}

function get_array_value($array, $index) {
	return isset($array[$index]) ? $array[$index] : '';
}

class tailwind_walker_nav_menu extends Walker_Nav_menu {
    private $curItem;
    function start_lvl( &$output, $depth = 0, $args = array() ){ 
        $indent = str_repeat("\t",$depth); // indents the outputted HTML
        $output .= "\n$indent<ul style='padding-left:0;' class=\"absolute hidden block bg-white group-hover:block mt-6\">\n";
    }
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ 
        $this->curItem = $item;
        // li a span
        $indent = ( $depth ) ? str_repeat("\t",$depth) : '';
        
        $li_attributes = '';
        $class_names = $value = '';
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $classes[] = ($args->walker->has_children) ? 'group relative' : '';

        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = empty(esc_attr($class_names)) ?'': ' class="' . esc_attr($class_names) . '"';
        
        $output .= $indent . '<li style="margin:0 auto;"' . $value . $class_names . $li_attributes . '>';
        
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';

        $class_a = ( $args->walker->has_children ) ? ' after:content-[\'\'] after:inline-block after:border-4 after:border-white after:border-t-teal-600 after:ml-1 after:align-middle' : ' ';
                
        $item_output = $args->before;
        $item_output .= ( $depth > 0 ) ? '<a class="text-teal-600 hover:text-teal-400 text-sm whitespace-nowrap block p-3" ' . $attributes . '>' : '<a class="text-base semi-bold text-teal-600 whitespace-nowrap hover:text-teal-400 pb-8 px-5'.$class_a.'"' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        
    }
}

/******* SENDING MAIL *******/
    function wpdocs_set_html_mail_content_type() {
        return 'text/html';
    }
    add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
    add_action('wp_ajax_submit_reservation_form', 'submit_reservation_form');
    add_action('wp_ajax_nopriv_submit_reservation_form', 'submit_reservation_form');

    function submit_reservation_form() {

        $nonce = $_REQUEST['nonce'];
        if (! wp_verify_nonce($nonce , 'submit_reservation_form_nonce') ) {
            die('No naughty business please.');
        }
        else{
            $formdata = stripslashes($_POST['formdata']); 
            $formdata = json_decode($formdata , true);

            $fullname = $formdata['fullname'];
            $email = sanitize_email($formdata['email']);
            $subject = $formdata['subject'];
            $phone = $formdata['phone'];
            $checkin = $formdata['checkin'];
            $checkout = $formdata['checkout'];
            $number_of_guest = $formdata['number_of_guest'];
            $request = $formdata['request'];

            //$recipient_email = base64_decode($formdata['sendto']);

            /* Email Message */
            $body = "<h2>Reservation Message</h2>";
            $body .= "<strong>Villa Name:</strong> ".$subject."<br/>";
            $body .= "<strong>Nama:</strong> ".$fullname."<br/>";
            $body .= "<strong>E-mail:</strong> ".$email."<br/>";
            $body .= "<strong>Phone:</strong> ".$phone."<br/>";
            $body .= "<strong>Check in date:</strong> ".$checkin."<br/>";
            $body .= "<strong>Check out date:</strong> ".$checkout."<br/>";
            $body .= "<strong>Number of guest:</strong> ".$number_of_guest."<br/>";
            $body .= "<strong>Request:</strong> ".$request."<br/>";
            
            if( $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ){
                $result['status'] = 'true';
            } else{

                if( function_exists('wp_mail') ) {

                    $headers = 'From: ' . $fullname . ' <' . $email . '>' . "\r\n";

                    if(wp_mail($recipient_email, $subject, $body, $headers)) {
                        $result['status'] = 'true';
                    } else {
                        $result['status'] = 'false';
                    }
                    
                } else {
                    $result['status'] = 'false';
                }

            }

            echo json_encode($result);
            
            die();

        }
    }
