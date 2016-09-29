var gulp   = require('gulp');
var zip    = require('gulp-zip');
var rimraf = require('rimraf'); 

gulp.task('clean', (cb) => {
    rimraf('./dist', cb);
});

gulp.task('package', () => {
    return gulp.src(['./src/**'])
        .pipe(zip('shoreditch-assists.zip'))
        .pipe(gulp.dest('dist'));
});

gulp.task('default', ['clean', 'package']);