const gulp = require('gulp')
const cleanCSS = require('gulp-clean-css')
const sass = require('gulp-sass')
const rename = require('gulp-rename')
const autoprefix = require('gulp-autoprefixer')
const standard = require('gulp-standard')
const sassLint = require('gulp-sass-lint')
const ts = require('gulp-typescript')
const tslint = require('gulp-tslint')
const browserSync = require('browser-sync').create()

const pack = require('./package.json')
const utils = require('./config/utils.js')

gulp.task('compress', ['js-lint', 'commonjs', 'dev', 'production', 'all', 'all.min'])

gulp.task('commonjs', () => {
  return utils.packageRollup({
    dest: 'dist/' + pack.name + '.common.js',
    format: 'cjs'
  })
})

gulp.task('dev', () => {
  return utils.packageRollup({
    dest: 'dist/' + pack.name + '.js',
    format: 'umd'
  })
})

gulp.task('production', () => {
  return utils.packageRollup({
    dest: 'dist/' + pack.name + '.min.js',
    format: 'umd',
    minify: true
  })
})

gulp.task('all', ['sass'], () => {
  return utils.packageRollup({
    entry: 'src/sweetalert2.all.js',
    dest: 'dist/' + pack.name + '.all.js',
    format: 'umd'
  })
})

gulp.task('all.min', ['sass'], () => {
  return utils.packageRollup({
    entry: 'src/sweetalert2.all.js',
    dest: 'dist/' + pack.name + '.all.min.js',
    format: 'umd',
    minify: true
  })
})

gulp.task('sass', ['sass-lint'], (cb) => {
  gulp.src('src/sweetalert2.scss')
    .pipe(sass())
    .pipe(autoprefix())
    .pipe(gulp.dest('dist'))
    .pipe(cleanCSS())
    .pipe(rename({extname: '.min.css'}))
    .pipe(gulp.dest('dist'))
    .on('end', cb)
})

gulp.task('ts', ['ts-lint'], () => {
  return gulp.src('sweetalert2.d.ts')
    .pipe(ts())
})

gulp.task('lint', ['js-lint', 'sass-lint', 'ts-lint'])

gulp.task('js-lint', () => {
  return gulp.src(['src/**/*.js', 'test/*.js'])
    .pipe(standard())
    .pipe(standard.reporter('default', {
      breakOnError: true
    }))
})

gulp.task('sass-lint', () => {
  return gulp.src(['src/**/*.scss'])
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError())
})

gulp.task('ts-lint', () => {
  return gulp.src('sweetalert2.d.ts')
    .pipe(tslint({ formatter: 'verbose' }))
    .pipe(tslint.report())
})

gulp.task('default', ['sass', 'ts', 'compress'])

gulp.task('watch', () => {
  browserSync.init({
    port: 8080,
    notify: false,
    reloadOnRestart: true,
    https: false,
    server: ['./'],
    startPath: 'test/sandbox.html'
  })

  gulp.watch(['dist/sweetalert2.all.min.js']).on('change', browserSync.reload)

  gulp.watch([
    'src/**/*.js',
    'test/*.js'
  ], ['compress'])

  gulp.watch(['src/*.scss'], ['sass', 'compress'])
})
