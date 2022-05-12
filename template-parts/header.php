<div class="flex flex-col lg:h-screen">
<header>
        <div class="flex flex-wrap justify-between container mx-auto py-2">
          <div class="flex items-center md:w-2/5">
            <a href="/" class="pl-4"><img class="w-44 md:w-48" src="<?php echo esc_url( wp_get_attachment_url( get_theme_mod('custom_logo') ) );?>" alt="Logo"></a>
          </div>
          <!--icon menu-->
          <div class="block md:hidden pr-4">
            <button id="nav-toggle" class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
              <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
              </svg>
            </button>
          </div>

          <nav id="nav-content" class="flex-grow md:flex items-center mt-2 p-4 md:w-3/5 w-full justify-around hidden">
          <?php

          if( has_nav_menu( 'topmenu' )): 
            wp_nav_menu( array(
              'theme_location' => 'topmenu',
              'container' => '',
              'items_wrap' => '<ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">%3$s</ul>',
              'fallback_cb' => false,
              'walker' => new tailwind_walker_nav_menu()
            ) );

          endif;
          ?>

            <a href="/" class="bg-blue-700 text-white inline-block p-2 uppercase rounded-md tracking-wide text-sm md:ml-24">booking</a>
          </nav>
        </div>
    </header>
    <?php if( is_front_page() OR is_home()) : ?>
    <!--hero image-->
    <?php
      $hero_image = ot_get_option('hero_image');
      $hero_image_id = attachment_url_to_postid( $hero_image );
      $hero_image_title = get_the_title( $hero_image_id );
      $hero_image_caption = get_the_excerpt( $hero_image_id );
    ?>
    <div class="bg-center bg-cover block flex-grow" style="background-image:url(<?php echo esc_url($hero_image ) ;?>);aspect-ratio:16/9;">
      <div class="flex items-center justify-center w-full h-full bg-gray-900 bg-opacity-40">
      <div class="text-center">
      <h1 class="text-2xl text-white font-medium font-intro capitalize md:text-7xl tracking-wider"><?php echo $hero_image_title;?> </h1>
      <p class="text-white mt-4 px-6"><?php echo $hero_image_caption ;?></p>
      </div>
      </div>
    </div>
  <?php else: ?>
<?php if (has_post_thumbnail()) : $imgID = get_post_thumbnail_id($post->ID);
  $featuredImage = wp_get_attachment_image_src($imgID, 'full' );
  $imgURL = $featuredImage[0]; ?>
  <div class="bg-center bg-cover" style="background-image:url('<?php echo $imgURL ?>');height:auto;aspect-ratio:16/9;">

  </div>
  <?php  endif; ?>
  <?php endif; ?>
</div>