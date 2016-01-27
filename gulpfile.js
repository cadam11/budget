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
    mix.sass('app.scss');

    mix.styles([
        '../bower/bootstrap/dist/css/bootstrap.min.css',
        '../bower/typeahead.js-bootstrap3.less/typeahead.css'
    	], 'public/css/vendor.css');

    mix.copy('resources/assets/bower/bootstrap/dist/css/bootstrap.min.css.map','public/build/css/');


    mix.scripts([
    	'../bower/jquery/dist/jquery.min.js',
    	'../bower/bootstrap/dist/js/bootstrap.min.js',
    	'../bower/typeahead.js/dist/typeahead.bundle.min.js'
    	], 'public/js/vendor.js');

    mix.scripts('app.js');

    mix.version([
    	'css/app.css',
    	'css/vendor.css',
    	'js/vendor.js',
    	'js/app.js'
    	]);

});
