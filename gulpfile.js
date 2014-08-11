// Install on vagrant
// Run gulp on localhost, not vagrant
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');

// Paths
var adminScss = 'public/assets/scss/admin/**/*';
var adminCss = 'public/assets/css/admin/';
var scss = 'public/assets/scss/*';
var css = 'public/assets/css/';

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
gulp.task('default', ['admin_sass', 'sass', 'watch']);