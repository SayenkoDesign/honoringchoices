//process.env.DISABLE_NOTIFIER = true; // Uncomment to disable all Gulp notifications.

var proxy = 'https://honoringchoices.vanwp.ca';

// Require our dependencies.
var args         = require('yargs').argv,
	autoprefixer = require('autoprefixer'),
    babel        = require( 'gulp-babel' ),
	browsersync  = require('browser-sync'),
	changecase   = require('change-case'),
	del          = require('del'),
	mqpacker     = require('css-mqpacker'),
	fs           = require('fs'),
	gulp         = require('gulp'),
	beautify     = require('gulp-cssbeautify'),
	cache        = require('gulp-cached'),
	cleancss     = require('gulp-clean-css'),
	concat       = require('gulp-concat'),
	csscomb      = require('gulp-csscomb'),
	cssnano      = require('gulp-cssnano'),
	filter       = require('gulp-filter'),
	imagemin     = require('gulp-imagemin'),
	notify       = require('gulp-notify'),
	plumber      = require('gulp-plumber'),
	postcss      = require('gulp-postcss'),
	rename       = require('gulp-rename'),
	replace      = require('gulp-replace'),
	sass         = require('gulp-sass'),
	sort         = require('gulp-sort'),
	sourcemaps   = require('gulp-sourcemaps'),
	uglify       = require('gulp-uglify'),
	wpPot        = require('gulp-wp-pot'),
	zip          = require('gulp-zip'),
	focus        = require('postcss-focus');

// Set assets paths.
var paths = {
	all:        ['./**/*', '!./node_modules/', '!./node_modules/**', '!./screenshot.png', '!./assets/images/**'],
	concat:     ['assets/scripts/vendor/*.js','assets/scripts/concat/*.js'],
	images:     ['assets/images/*', '!assets/images/*.svg'],
	php:        ['./*.php', './**/*.php', './**/**/*.php'],
	scripts:    [ 'assets/scripts/*.js', '!assets/scripts/*.min.js', '!assets/scripts/*config.js', '!assets/scripts/customizer.js' ],
    foundation: ['node_modules/foundation-sites/js/'],
	styles:     ['assets/sass/**/*.scss']
};



/**
 * Compile Sass.
 *
 * https://www.npmjs.com/package/gulp-sass
 */
gulp.task('styles', function () {

	gulp.src('assets/sass/style.scss')

		// Notify on error
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Initialize source map.
		.pipe(sourcemaps.init())

		// Process sass
		.pipe(sass({
            includePaths: ['node_modules/motion-ui/src'],
			outputStyle: 'compressed'
		}))

		// Parse with PostCSS plugins.
		.pipe(postcss([
			autoprefixer({
				browsers: 'last 2 versions'
			}),
			mqpacker({
				sort: true
			}),
			focus(),
		]))

		// Minify and optimize style.css again.
		.pipe(cssnano({
			safe: true,
			discardComments: {
				//removeAll: true,
			},
		}))


		// Write source map.
		.pipe(sourcemaps.write('.', {
			includeContent: true,
		}))	
        
        .pipe(gulp.dest('./'))

		// Filtering stream to only css files.
		.pipe(filter('**/*.css'))
        
        // Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile (uncomment for notifications).
		//.pipe(notify("Compiled: <%= file.relative %>"));

});

/**
 * Concat javascript files.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('concat', function () {

	gulp.src(paths.concat)

		// Notify on error.
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Concatenate scripts.
		.pipe(concat('project.js'))

		// Output the processed js to this directory.
		.pipe(gulp.dest('assets/scripts'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}));

} );


gulp.task('foundation', function () {
	
    gulp.src([

		/* Choose what JS Plugin you'd like to use. Note that some plugins also
		require specific utility libraries that ship with Foundation—refer to a
		plugin's documentation to find out which plugins require what, and see
		the Foundation's JavaScript page for more information.
		http://foundation.zurb.com/sites/docs/javascript.html */

		// Core Foundation - needed when choosing plugins ala carte
		paths.foundation + 'foundation.core.js',

		// Choose the individual plugins you want in your project
		paths.foundation + 'foundation.dropdown.js',

		paths.foundation + 'foundation.equalizer.js',

		paths.foundation + 'foundation.tabs.js',

		paths.foundation + 'foundation.accordion.js',
 		paths.foundation + 'foundation.accordionMenu.js',
        
        paths.foundation + 'foundation.zf.responsiveAccordionTabs.js',

		//paths.foundation + 'foundation.abide.js',

		//paths.foundation + 'foundation.drilldown.js',

		//paths.foundation + 'foundation.dropdownMenu.js',

		//paths.foundation + 'foundation.interchange.js',
		//paths.foundation + 'foundation.magellan.js',

		//paths.foundation + 'foundation.orbit.js',
		//paths.foundation + 'foundation.responsiveMenu.js',
		//paths.foundation + 'foundation.responsiveToggle.js',

		//paths.foundation + 'foundation.slider.js',
		paths.foundation + 'foundation.sticky.js',

		//paths.foundation + 'foundation.tooltip.js',

		//paths.foundation + 'foundation.offcanvas.js',

		paths.foundation + 'foundation.toggler.js',

		paths.foundation + 'foundation.reveal.js',

		paths.foundation + 'foundation.util.mediaQuery.js',
 		paths.foundation + 'foundation.util.box.js',
		paths.foundation + 'foundation.util.triggers.js',

		paths.foundation + 'foundation.util.keyboard.js',
		paths.foundation + 'foundation.util.motion.js',
		paths.foundation + 'foundation.util.timerAndImageLoader.js',
        
        paths.foundation + 'foundation.util.nest.js',

        //paths.foundation + 'foundation.util.touch.js',

	])
    
    // Notify on error.
    .pipe(plumber({
        errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    
    .pipe(babel({
		presets: ['env'],
		compact: false
	}))
    
	// Concatenate scripts.
    .pipe(concat('foundation.js'))

    // Output the processed js to this directory.
    .pipe(gulp.dest('assets/scripts'))

    // Inject changes via browsersync.
    .pipe(browsersync.reload({
        stream: true
    }));
});


/**
 * Minify javascript files.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('scripts', ['concat'], function () {

	gulp.src(paths.scripts)

		// Notify on error.
		.pipe(plumber({
			errorHandler: notify.onError("Scripts Error: <%= error.message %>")
		}))

		// Source maps init.
		.pipe(sourcemaps.init())

		// Cache files to avoid processing files that haven't changed.
		.pipe(cache('scripts'))

		// Add .min suffix.
		.pipe(rename({
			suffix: '.min'
		}))

		// Minify.
		.pipe(uglify())

		// Write source map.
		.pipe(sourcemaps.write('./', {
			includeContent: false,
		}))

		// Output the processed js to this directory.
		.pipe(gulp.dest('assets/scripts'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile.
		.pipe(notify("Minified: <%= file.relative %>"));

});

/**
 * Optimize images.
 *
 * https://www.npmjs.com/package/gulp-imagemin
 */
gulp.task('images', function () {

	return gulp.src(paths.images)

		// Notify on error.
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		// Cache files to avoid processing files that haven't changed.
		.pipe(cache('images'))

		// Optimize images.
		.pipe(imagemin({
			progressive: true
		}))

		// Output the optimized images to this directory.
		.pipe(gulp.dest('assets/images'))

		// Inject changes via browsersync.
		.pipe(browsersync.reload({
			stream: true
		}))

		// Notify on successful compile.
		.pipe(notify("Optimized: <%= file.relative %>"));

});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('translate', function () {

	return gulp.src(paths.php)

		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.message %>")
		}))

		.pipe(sort())

		.pipe(wpPot({
			domain: '_s',
			destFile: '_s',
			package: '_s'
		}))

		.pipe(gulp.dest('./languages/'));

});

/**
 * Package theme.
 *
 * https://www.npmjs.com/package/gulp-zip
 */
gulp.task('zip', function () {

	gulp.src(['./**/*', '!./node_modules/', '!./node_modules/**', '!./aws.json'])
		.pipe(zip(__dirname.split("/").pop() + '.zip'))
		.pipe(gulp.dest('../'));

});




/**
 * Process tasks and reload browsers on file changes.
 *
 * https://www.npmjs.com/package/browser-sync
 */
gulp.task('watch', function () {

	// HTTPS (optional).
	browsersync({
		proxy: proxy,
		port: 3000,
		notify: false,
		open: true,
		https: {
		 	'key': '/Users/kylerumble/Documents/Certificates/localhost.key',
			'cert': '/Users/kylerumble/Documents/Certificates/localhost.crt'
		}
	});

	// Run tasks when files change.
	gulp.watch(paths.styles, ['styles']);
    gulp.watch(paths.concat, ['scripts']);
	gulp.watch(paths.scripts, ['scripts']);
	gulp.watch(paths.images, ['images']);
	gulp.watch(paths.php).on('change', browsersync.reload);

});

/**
 * Create default task.
 */
gulp.task('default', ['watch'], function () {

	gulp.start('styles', 'foundation', 'scripts', 'images');

});
