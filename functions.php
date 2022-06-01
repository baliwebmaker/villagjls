<?php
define("THEME_NAME","villagjls");

/***option-tree */
/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Required: include theme options.
 */
require( trailingslashit( get_template_directory() ) . 'theme-options.php' );

/**
 * Remove admin bar
*/
add_filter('show_admin_bar', '__return_false');


if ( ! function_exists( 'villagjls_setup' ) ) :
    /**
    *  @since Villagjls 1.0
    */
    function villagjls_setup() {
        register_nav_menus( array(
            'topmenu'   => __( 'Top Menu', THEME_NAME )
        ) );

        add_theme_support( 'custom-logo' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
    }

endif;
add_action( 'after_setup_theme', 'villagjls_setup' );

/* ENQUEUE SCRIPTS */
if ( ! function_exists( 'villagjls_scripts' ) ) :

    function villagjls_scripts(){
        wp_enqueue_style( 'tw-style', get_template_directory_uri(  ).'/dist/css/theme.css' );
        
        wp_enqueue_script('tw-js', get_template_directory_uri(  ).'/dist/js/main.js', array(), null, true);

        wp_register_style( 'tiny-slider-css', get_template_directory_uri(  ).'/dist/css/tiny-slider.css');
        wp_register_script( 'tiny-slider', get_template_directory_uri(  ).'/dist/js/tiny-slider.js', array(), null, true );
        

        if( is_page_template( 'villa-page.php' )){
            wp_enqueue_script('recaptcha','https://www.google.com/recaptcha/api.js?render=6Ld0SAEgAAAAACz-EBJRejBqSgXZnVNo768gX5Lo', array(), null, false );
            //add script into theme and inject defer attributes in the <script>s
            $scripts_ids = array('datepicker','reservation-form','alpinejs');
            $scripts_srcs = array('datepicker.js','reservationform.js','alpinejs.js');

            foreach( array_combine( $scripts_ids , $scripts_srcs ) as $id => $src) {
                echo wp_get_script_tag( 
                    array(
                    'id'=> $id,
                    'src'=> get_template_directory_uri( ).'/dist/js/'. $src,
                    'defer'=> true,
                    )
                ); 
            }

        }

        /* Make site url available to JS scripts */
        $site_parameters = array(
            'site_url' => get_site_url(),
            'theme_directory' => get_template_directory_uri(),
            'ajax_url' => admin_url('admin-ajax.php')
        );
        wp_localize_script( 'tw-js', 'SiteParameters', $site_parameters );

    }

endif;

add_action( 'wp_enqueue_scripts','villagjls_scripts' );

/* add tailwind css to menu li */
function twcss_add_menu_li($classes, $item, $args){
    $classes[] = 'block flex-initial';
    return $classes;
}
add_filter( 'nav_menu_css_class','twcss_add_menu_li',10,4 );

/* add tailwind css to menu link att */
function twcss_add_menu_att($atts){
    $atts['class'] = 'text-gray-500 hover:text-gray-300 font-semibold text-sm';
    return $atts;
}
add_filter( 'nav_menu_link_attributes' , 'twcss_add_menu_att' );

/* register post type special package */

function register_special_package(){
    
    $labels = array(
        'singular_name'=>__(  "Special Package", THEME_NAME ),
        'add_new'=>__(  "Add New ", THEME_NAME ),
        'add_new_item'=>__(  "Add New Special Package", THEME_NAME ),
        'new_item'=>__(  "New Special Package", THEME_NAME ),
        'edit_item'=>__(  "Edit Special Package", THEME_NAME ),
        'all_items'=>__(  "All Special Packages", THEME_NAME ),
        'search_items'=>__(  "Search Special Package", THEME_NAME ),
        'not_found'=>__(  "No Special Package Found ", THEME_NAME ),
        'not_found_in_trash'=>__(  "No Special Package Found in Trash", THEME_NAME ),
        'show_in_nav_menus'=> true,
        'menu_icon'  => 'dashicons-store',
    );
    $args = array(
            'label' => __( "Special Package", THEME_NAME ),
            'labels'=> $labels,
            'menu_icon'  => 'dashicons-store',
            'description'=> 'Special Package Custom Type',
            'public' => true,
			'show_ui' => true,
			'capability_type' => 'page',
			'hierarchical' => false,
			'has_archive' => true,
            'supports' => array('title','editor','excerpt', 'page-attributes', 'thumbnail'),
            'rewrite'=>array(
                'slug'=> _x('special-package','Slug wording permalink',THEME_NAME),
                'with_front'=> false
            )
                    
    );
    register_post_type( 'special-package', $args );
}
add_action( 'init', 'register_special_package' );

/* ADD SHORTCODES */
function sc_special_package(){
    wp_enqueue_script( 'tiny-slider' );
    wp_enqueue_style('tiny-slider-css' );

    $script = "<script>
    var slider = tns({
        container: '.my-slider',
        items: 1,
        slideBy: 'page',
        autoplay: true,
        gutter:10,
        controls: false,
        nav: false,
        speed:400,
        autoplayButtonOutput:false,
        mouseDrag: true,
        responsive: {
          640: {
            items: 2
          },
          768: {
            items: 3
          }
        }
      });
    </script>";
    add_action( 'wp_footer', function() use($script) { echo $script;} , 100);
    ob_start();
    get_template_part( 'template-parts/section-special-package' );
    return ob_get_clean();
}
add_shortcode( 'special-package', 'sc_special_package');

/* Register widgets area */

function villagjls_widgets_init(){

    register_sidebar( 
        array(
            'name'  => esc_html__( 'Footer 1', THEME_NAME ),
            'id'    => 'sidebar-1',
            'description' => esc_html__( 'Add Widget Here', THEME_NAME ),
            'before_widget' => '<section id="%1$s" class="%2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="text-sm tracking-widest uppercase p-4" >',
            'after_title' => '</h2>'
        )
    );

    
    register_sidebar( 
        array(
            'name'  => esc_html__( 'Footer 2', THEME_NAME ),
            'id'    => 'sidebar-2',
            'description' => esc_html__( 'Add Widget Here', THEME_NAME ),
            'before_widget' => '<section id="%1$s" class="%2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="text-sm tracking-widest uppercase p-4" >',
            'after_title' => '</h2>'
        )
    );

    
    register_sidebar( 
        array(
            'name'  => esc_html__( 'Footer 3', THEME_NAME ),
            'id'    => 'sidebar-3',
            'description' => esc_html__( 'Add Widget Here', THEME_NAME ),
            'before_widget' => '<section id="%1$s" class="%2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="text-sm tracking-widest uppercase p-4 md:text-left">',
            'after_title' => '</h2>'
        )
    );
}
add_action( 'widgets_init',  'villagjls_widgets_init' );

/* Register Meta Boxes */

function register_meta_boxes(){
    get_template_part( 'metaboxes/villaimages' );
}
add_action( 'init', 'register_meta_boxes' );

include get_theme_file_path( '/functions/utilities.php' );

/* add tag support to pages */
function categories_support_page(){
    register_taxonomy_for_object_type('category','page');
}

add_action('init','categories_support_page');