const mix = require('laravel-mix');

const paths = {
    src: 'src/web/assets/src',
    dist: 'src/web/assets/dist',
};

mix.js(paths.src+'/footnote.js', paths.dist)
    .sass(paths.src+'/footnote.scss', paths.dist);
