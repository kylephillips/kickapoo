// Install on vagrant
// Run gulp on localhost, not vagrant
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

// Paths
var adminScss = 'public/assets/scss/admin/**/*';
var adminCss = 'public/assets/css/admin/';
var scss = 'public/assets/scss/*';
var css = 'public/assets/css/';

var js_source = 'public/assets/js/source/*';
var js_front_end = 'public/assets/js';

/**
* Smush the admin Styles and output
*/
gulp.task('admin_sass', function(){
	return gulp.src(adminScss)
		.pipe(sass())
		.pipe(autoprefix('last 15 version'))
		.pipe(gulp.dest(adminCss))
		.pipe(plumber())
		.pipe(livereload())
		.pipe(notify('Admin styles compiled & compressed.'));
});

/**
* Smush the front end js and output
*/
gulp.task('js', function(){
	return gulp.src(js_source)
		.pipe(concat('scripts.min.js'))
		.pipe(gulp.dest(js_front_end))
		.pipe(uglify())
		.pipe(gulp.dest(js_front_end))
		.pipe(notify('Front-end scripts compiles & compressed.'));
});

/**
* Smush the front end Styles and output
*/
gulp.task('sass', function(){
	return gulp.src(scss)
		.pipe(sass())
		.pipe(autoprefix('last 15 version'))
		.pipe(gulp.dest(css))
		.pipe(plumber())
		.pipe(livereload())
		.pipe(notify('Front end styles compiled & compressed.'));
});

/**
* Watch Task
*/
gulp.task('watch', function(){
	livereload.listen(8000);
	gulp.watch(adminScss, ['admin_sass']);
	gulp.watch(scss, ['sass']);
});

/**
* Default
*/
gulp.task('default', ['admin_sass', 'sass', 'js', 'watch']);