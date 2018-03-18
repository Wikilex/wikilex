/**
 * Task to concate and verify scripts.
 *
 * Tasks:
 * - Verify scripts for errors
 * - Concate application scripts
 * - Sourcemaps
 * - Success/error message
 */

'use strict';

module.exports = function(gulp, $, config, messages) {
  gulp.task('scripts', function() {
  	return gulp.src(config.javascript.src)
  		.pipe($.plumber({
  			errorHandler: messages.error
  		}))
      .pipe($.jshint())
  		.pipe($.jshint.reporter($.stylish))
  		.pipe($.jshint.reporter('fail'))
      .pipe($.sourcemaps.init())
      .pipe($.concat(config.javascript.file))
      .pipe($.sourcemaps.write(config.javascript.sourcemaps))
      .pipe(gulp.dest(config.javascript.destination))
      .pipe($.notify(messages.success));
  });
};
