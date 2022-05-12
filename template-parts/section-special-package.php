<div class="w-full block text-center mt-24">
      <img src="<?php echo esc_url( wp_get_attachment_url( get_theme_mod('custom_logo') ) );?>" alt="Logo" class="mx-auto w-44">
      <h1 class="text-gray-500 uppercase text-2xl tracking-widest">SPECIAL PACKAGE</h1>
      <p class="text-sm text-gray-500">   Villas Promotions and special deals available for your vacation</p>
    </div>
<div class="mx-auto mt-8 relative container">
    <div class="my-slider" id="specialoffers">
<?php
    $loop = new WP_Query(
        array(
            'post_type' => 'special-package',
            'order'=>'ASC'
        )
    );
    if($loop->have_posts(  )): while($loop->have_posts(  )) : $loop->the_post(  );

        if(has_post_thumbnail( get_the_ID() )): 
            $image = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
        endif;
?>
    <div class="text-center">
        <img class="w-full" src="<?php echo esc_url( $image );?>" alt="">
        <div class="px-4 py-2">
          <p class="text-gray-500 text-sm tracking-normal"><?php echo get_the_excerpt(  );?></p>
          <a href="/" class="mx-auto inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-md focus:shadow-outline hover:bg-indigo-800">
more
          </a>
        </div>
      </div>
      <?php endwhile; endif;?>
</div>
</div>
