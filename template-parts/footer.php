<div class="w-full block text-center mt-24 bg-blue-800 text-gray-300">
      <img src="<?php echo esc_url( wp_get_attachment_url( get_theme_mod('custom_logo') ) );?>" alt="Logo" class="mx-auto w-44 pt-8 filter grayscale invert ">
      <h1 class="text-gray-300 capitalize text-sm tracking-widest opacity-70">Villa &amp; Resorts</h1>

    <div class="md:flex mx-auto container p-5 sm:pt-3">

    
        <div class="w-4/5 md:w-1/5 mx-auto pt-2">
        <?php if( is_active_sidebar( 'sidebar-1' )): ?>
        <?php dynamic_sidebar( 'sidebar-1' );?>
        <?php else: ?>
            <p class="text-xs">
            Jalan Widyadari 01
            Desa Khayangan Kd Pst 01010<br>
            Telp. : +62 0101 0101 , <br>E: gjsrbtn@alangkahindah.loc
            </p>
        <?php endif; ?>
        </div>

        <div class="w-3/5 mx-auto pt-2">
        <?php if( is_active_sidebar( 'sidebar-2' )): ?>
            <?php dynamic_sidebar( 'sidebar-2' );?>
        <?php else: ?>
        <div class="inline-flex space-x-3"></div>
        <?php endif; ?>
        </div>

        <div class="w-1/5 mx-auto pt-2">
        <?php if( is_active_sidebar( 'sidebar-3' )): ?>
            <?php dynamic_sidebar( 'sidebar-3' );?>
        <?php else: ?>
          <ul class="md:pl-4">
          <li class="text-xs md:text-left capitalize"><a>contact</a></li>
          <li class="text-xs md:text-left capitalize"><a>terms of use</a></li>
          <li class="text-xs md:text-left capitalize"><a>privacy policy</a></li>
          <li class="text-xs md:text-left capitalize"><a>sitemap</a></li>
          </ul>
        <?php endif;?>
        </div>
        
</div>
<span class="text-xs opacity-70 mb-5">Indah 2022 By GJLSSBTN Bebas Pakai Saja kalau Mau</span> 
</div>