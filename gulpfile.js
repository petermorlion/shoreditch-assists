var gulp = require('gulp');
var zip  = require('gulp-zip');

gulp.task('default', () => {
    return gulp.src(['./**/!(readme.md|license.md|.gitignore)'])
        .pipe(zip('archive.zip'))
        .pipe(gulp.dest('dist'));
});