const mix = require('laravel-mix');

const paths = {
    src: 'src/web/assets/src',
    dist: 'src/web/assets/dist',
};

mix.js(paths.src+'/footnotes.js', paths.dist)
    .sass(paths.src+'/footnotes.scss', paths.dist);
