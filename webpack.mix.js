let mix = require('laravel-mix');

mix.setPublicPath('./dist');
mix.postCss('src/css/theme.css','css')
.options(
    {
        postCss:[
            require('tailwindcss')('tailwind.config.js')
        ],
        processCssUrls: false
    }
).postCss('src/css/tiny-slider.css','css');

mix.js('src/js/main.js','js')
.js('src/js/tiny-slider.js','js')
.js('src/js/alpinejs.js','js')
.js('src/js/reservationform.js','js')
.js('src/js/datepicker.js','js');