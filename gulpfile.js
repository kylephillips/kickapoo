var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');

gulp.task('default', function () {
    watch({glob: 'public/assets/scss/*.scss'}, function(files) {
        return files.pipe(sass())
            .pipe(gulp.dest('public/assets/css/'));
    });
});