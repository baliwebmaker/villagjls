<div class="bg-white w-full mt-6 ">
<h3 class="text-gray-500 pb-4 capitalize text-md font-semibold md:text-left text-center">images gallery</h3>
<?php
   $photos = get_post_meta( get_the_ID(), 'villa_images', true );
   $photosarray  = explode("," , $photos );
   $photostr = '';
   
   foreach($photosarray as $value): 
    $photo = get_array_value(wp_get_attachment_image_src( $value , 'large'),0  );
     $photostr .=  $photo.',';
   endforeach;

   $str = array_filter(explode("," ,$photostr)) ; 
?>
<div x-data ="{ items:<?php echo esc_html(wp_json_encode($str));?>, current:0, total:0}" >
    <div class="flex flex-wrap">
        <template x-for="(item,index) in items.slice(0, 4)" :key="index">
            <div  class="lg:w-1/2 w-1/2 p-3" >
                <img 
                class="object-center object-cover h-auto w-full cursor-pointer"
                :src="item" 
                @click="$dispatch('lightbox', { src: item  });
                document.body.classList.add('overflow-hidden','h-screen');
                current = index,open = true"
                :data-current = index
                :data-total = items.length
                />
            </div>
        </template>
    </div>
    <div 
        x-show="lightboxOpen" 
        x-data="{lightboxOpen: false, current: 0, total: 0, imgSrc: ''}" 
        x-transition.opacity
        @lightbox.window="
        lightboxOpen = true; 
        imgSrc = $event.detail.src; 
        current = $event.target.dataset.current; 
        total = items.length;"
        x-cloak
    >
    <div class="fixed top-0 left-0 w-full h-full z-40 overflow-hidden bg-black bg-opacity-80"></div>
        <div 
        class="fixed top-0 left-0 w-full h-full z-50 lightbox-container display-none 
        before:content-[''] before:inline-block before:align-middle before:h-full" 
        x-show="lightboxOpen"
        >
        <div class="flex absolute top-0 bottom-0 m-auto justify-center items-center w-full pl-2 pr-2 overflow-hidden">
        <div>
          <button 
            class="text-white font-semibold text-2xl w-full text-right" 
            @click="
            lightboxOpen = false;
            document.body.classList.remove('overflow-hidden','h-screen');"
          >&times;
          </button>
            <figure>
                <img 
                x-data="{ wH:0 }"
                x-init="wH = (window.innerHeight)- 40 "
                :style="'max-height:'+ wH +'px'" 
                @resize.window="wH = (window.innerHeight)-40"
                :src="imgSrc"
                class="block w-auto h-auto max-w-full mx-auto pt-2 pb-10"
                :current = current
                >
            </figure>
         <button title="Previous (Left arrow key)" type="button" :data-current = parseInt(current)-1
                    :class="current >= 1 ? 'text-white font-semibold text-2xl absolute left-0 top-1/2 ml-6':'hidden'" 
                    @click.prevent="
                    if(current >= 1){
                    $dispatch('lightbox', { src: items[parseInt(current)-1] })
                    }"
        >&#10094;</button>
         <button title="Next (Right arrow key)" type="button" :data-current = parseInt(current)+1
                    :class="current < total-1 ? 'text-white font-semibold text-2xl absolute right-0 top-1/2 mr-6':'hidden'"
                    @click.prevent="
                    if(current < total-1){
                    $dispatch('lightbox', { src: items[parseInt(current)+1]  } );
                    }"
         >&#10095;</button>
         </div>
         </div></div></div>
</div>
</div>