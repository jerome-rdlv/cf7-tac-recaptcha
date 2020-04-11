const gulp = require('gulp');
const rename = require('gulp-rename');
const terser = require('gulp-terser');

const src = ['*.js', '!gulpfile.js', '!*.min.js'];

function js() {
    return gulp.src(src)
        .pipe(rename(function (path) {
            path.extname = '.min.js';
        }))
        .pipe(terser())
        .pipe(gulp.dest('.'))
        ;
}

function watch_js() {
    return gulp.watch(src, js);
}

exports.js = js;
exports.watch_js = watch_js;
