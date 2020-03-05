/* global require */
var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var autoprefixer = require('gulp-autoprefixer');
var lec = require('gulp-line-ending-corrector');

gulp.task('serve', ['sass'], function () {
	/**
	 * watch for changes in sass files
	 */
	gulp.watch("./sass/**/*.scss", ['sass']);
});

/**
 * sass task, will compile the .SCSS files,
 * and handle the error through plumber and notify through system message.
 */
gulp.task('sass', function () {
	return gulp.src('./sass/**/**/**/*.scss')
		.pipe(plumber({
			errorHandler: notify.onError("Error: <%= error.messageOriginal %>")
		}))
		.pipe(sass({outputStyle: 'expanded'})) /* compressed */
		.pipe(autoprefixer(['last 4 versions']))
		.pipe(lec({verbose: true, eolc: 'CRLF', encoding: 'utf8'}))

		.pipe(gulp.dest('./'))
});

gulp.task('default', ['serve']);
gulp.task('build', ['sass']);
