/* global require */
const gulp = require('gulp'),
    sass = require('gulp-sass'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    autoprefixer = require('gulp-autoprefixer'),
    lec = require('gulp-line-ending-corrector');

/**
 * watch for changes in sass files
 */
const watch = () => {
    gulp.watch("./sass/**/*.scss", gulp.series(build));
};

/**
 * build task, will compile the .SCSS files,
 * and handle the error through plumber and notify through system message.
 */
const build = () => {
    return gulp.src('./sass/**/*.scss')
        .pipe(plumber({
            errorHandler: notify.onError("Error: <%= error.messageOriginal %>")
        }))
        .pipe(sass({outputStyle: 'compressed'})) /* compressed, expanded */
        .pipe(autoprefixer(['last 4 versions']))
        .pipe(lec({verbose: true, eolc: 'LF', encoding: 'utf8'}))
        .pipe(gulp.dest('./'))
};

exports.default = watch;
exports.watch = gulp.series(build, watch);
exports.build = build;
