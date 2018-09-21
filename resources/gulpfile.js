var gulp = require('gulp');
var minifier = require('gulp-minifier');
var gulpClean = require('gulp-clean');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var riot = require('gulp-riot');
var ext_replace = require('gulp-ext-replace');
var del = require('del');

function criticalCss() {
    return gulp.src([
            'node_modules/spectre.css/dist/spectre.min.css',
            'css/app.css'
        ])
        .pipe(minifier({
            minify: true,
            minifyCSS: true,
            collapseWhitespace: true
        }))
        .pipe(concat('style.min.css'))
        .pipe(gulp.dest('../public/css'));
}

function css() {
    return gulp.src([
            'node_modules/spectre.css/dist/spectre-icons.min.css',
            'node_modules/sweetalert2/dist/sweetalert2.min.css',
            'node_modules/pell/dist/pell.min.css'
        ])
        .pipe(minifier({
            minify: true,
            minifyCSS: true,
            collapseWhitespace: true
        }))
        .pipe(gulp.dest('../public/css'));
}

function criticalJs() {
    return gulp.src([
            'node_modules/riot/riot.min.js',
            'node_modules/riot-route/dist/route.min.js',
            'js/geral.js',
            'js/serialize.js',
            'js/request.js'
        ])
        .pipe(minifier({
            minify: true,
            minifyJS: true,
            collapseWhitespace: true
        }))
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('../public/js'));
}

function js() {
    return gulp.src([
            'node_modules/sweetalert2/dist/sweetalert2.min.js',
            'node_modules/pell/dist/pell.js',
            'node_modules/vanilla-masker/build/vanilla-masker.min.js',
            'node_modules/choices.js/assets/scripts/dist/choices.min.js',
            'js/listagem-mixin.js'
        ])
        .pipe(minifier({
            minify: true,
            minifyJS: true,
            collapseWhitespace: true
        }))
        .pipe(gulp.dest('../public/js'));
}

function icons() {
    return gulp.src([
            'icons/**'
        ])
        .pipe(gulp.dest('../public/icons'));
}


function tags() {
    return gulp.src([
            'tags/**/*.tag'
        ])
        .pipe(riot({
            compact: true,
        }))
        .pipe(ext_replace('.js'))
        .pipe(minifier({
            minify: true,
            minifyJS: true,
            collapseWhitespace: true
        }))
        .pipe(gulp.dest('../public/tags'));
}

function clean() {
    return gulp.src([
        '../public/css',
        '../public/js',
        '../public/tags',
        '../public/icons',
    ], {
        read: false,
        allowEmpty: true
    }).pipe(gulpClean({
        force: true
    }));
}

exports.clean = clean;
exports.criticalCss = criticalCss;
exports.css = css;
exports.criticalJs = criticalJs;
exports.js = js;
exports.tags = tags;
exports.icons = icons;

gulp.task('default', gulp.series(clean, gulp.parallel(criticalCss, css, criticalJs, js, tags, icons)));