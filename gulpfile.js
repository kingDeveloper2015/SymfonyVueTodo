var gulp        = require('gulp');
var sass        = require('gulp-sass');
var sourcemaps  = require('gulp-sourcemaps');
var concat      = require('gulp-concat');
var minifyCSS   = require('gulp-minify-css');
var util        = require('gulp-util');
var gulpif      = require('gulp-if');
var plumber     = require('gulp-plumber');
var uglify      = require('gulp-uglify');
var gulpRev     = require('gulp-rev');
var del         = require('del');

var config = {
    assetsDir: 'app/Resources/assets',
    sassPattern: 'sass/**/*.scss',
    production: !!util.env.production,
    sourceMaps: !util.env.production,
    bowerDir: 'vendor/bower_components',
    revManifestPath: 'app/Resources/assets/rev-manifest.json'
};

var app = {};

app.addStyle = function(paths, outputFilename) {
    gulp.src(paths)
        .pipe(plumber())
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))
        .pipe(sass())
        .pipe(concat('css/'+outputFilename))
        .pipe(config.production ? minifyCSS() : util.noop())
        .pipe(gulpRev())
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        .pipe(gulpRev.manifest('app/Resources/assets/rev-manifest.json'))
        .pipe(gulp.dest('.'))
        .pipe(gulpRev.manifest(config.revManifestPath, {
            merge: true
        }));
};

app.copy = function(srcFiles, outputDir) {
    gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};

gulp.task('styles', function() {

    app.addStyle([
        config.bowerDir+'/bootstrap/dist/css/bootstrap.css',
        config.bowerDir+'/font-awesome/css/font-awesome.css',
        config.assetsDir+'/sass/styles.scss'
    ], 'styles.css');

});

gulp.task('scripts', function() {
    gulp.src([

        config.bowerDir+'/jquery/dist/jquery.js',
        config.bowerDir+'/bootstrap/dist/js/bootstrap.js',
        config.assetsDir+'/js/scripts.js'
    ])
        .pipe(plumber())
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))
        .pipe(concat('scripts.js'))
        .pipe(config.production ? uglify() : util.noop())
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('.')))
        .pipe(gulp.dest('web/js'));
});

gulp.task('fonts', function() {
    app.copy([
            config.bowerDir+'/bootstrap/dist/fonts/*',
            config.bowerDir+'/font-awesome/fonts/*'
        ],'web/fonts'
    );
});

gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
});

gulp.task('watch', function() {
    gulp.watch(config.assetsDir+'/'+config.sassPattern, ['styles']);
    gulp.watch(config.assetsDir+'/js/**/*.js', ['scripts']);
});

gulp.task('default', ['clean','styles', 'scripts', 'fonts', 'watch']);
