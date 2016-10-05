const elixir = require('laravel-elixir');
const imagemin = require('gulp-imagemin');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.webpack('app.js'),
    mix.webpack('places.js'),
    mix.version('js/places.js'),
    mix.styles(['pages.css'], 'public/css/pages.css'),
    mix.styles(['shepherd-themes'], 'public/css/shepherd-theme-arrow.css')
});

gulp.task('images', () =>
    gulp.src('public/img/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/img/dist'))
);