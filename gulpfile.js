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
    mix
        .sass('app.scss')

        .styles([
            '../bower/bootstrap/dist/css/bootstrap.min.css',
            '../bower/font-awesome/css/font-awesome.min.css',
            '../bower/typeahead.js-bootstrap3.less/typeahead.css',
            '../bower/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css',
            '../bower/datatables/media/css/dataTables.bootstrap.min.css'
        	], 'public/css/vendor.css')

        .styles([
            '../bower/dropzone/dist/min/dropzone.min.css'
            ], 'public/css/dropzone.css')

        .copy('resources/assets/bower/bootstrap/dist/css/bootstrap.min.css.map','public/build/css/')
        .copy('resources/assets/bower/x-editable/dist/bootstrap3-editable/img','public/build/img/')
        .copy('resources/assets/bower/font-awesome/fonts', 'public/build/fonts/')
        .copy('resources/assets/bower/bootstrap/dist/fonts', 'public/build/fonts/')


        .scripts([
        	'../bower/jquery/dist/jquery.min.js',
        	'../bower/bootstrap/dist/js/bootstrap.min.js',
            '../bower/datatables/media/js/jquery.dataTables.min.js',
        	'../bower/typeahead.js/dist/typeahead.bundle.min.js',
            '../bower/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js',
            '../bower/x-editable/dist/inputs-ext/typeaheadjs/typeaheadjs.js',
            '../bower/bootstrap-confirmation2/bootstrap-confirmation.min.js'
        	], 'public/js/vendor.js')

        .scripts([
            '../bower/dropzone/dist/min/dropzone.min.js'
            ], 'public/js/dropzone.js')

        .scripts('app.js')

        .version([
        	'css/app.css',
        	'css/vendor.css',
            'css/dropzone.css',
        	'js/vendor.js',
        	'js/app.js',
            'js/dropzone.js'
        	])
    ;

});
