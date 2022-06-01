<?php
class villaimagesmetabox{
    private function create_villa_images_metabox(){

        $args = 
        array(
            'id' => 'villa_images_metabox',
            'title' => __('Villa Images Gallery:','villagjls'), 
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
             'fields' => array(
                array(
                    'id' => 'villa_images',
                    'label' => 'Gallery Images',
                    'type' => 'gallery',

                )
            )
        );
        ot_register_meta_box($args);
    }

    function villa_images_metabox(){

        $post = empty($_GET['post'])?'0':$_GET['post'];
         $page_template = get_post_meta( $post, '_wp_page_template', true );

          if($page_template == 'villa-page.php'){

            $this->create_villa_images_metabox();
        }

    }
}

$villa_images_metabox = new villaimagesmetabox();
add_action( 'admin_init', array($villa_images_metabox , 'villa_images_metabox') );