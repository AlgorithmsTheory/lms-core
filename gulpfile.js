var elixir = require('laravel-elixir');

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

elixir(function(mix) {
    mix.browserify('modules.js');
});

let gulp = require('gulp');

gulp.task('default', [], function() {
    gulp.src("public/js/ram/mode/**")
        .pipe(gulp.dest('node_modules/brace/mode/'));
});
