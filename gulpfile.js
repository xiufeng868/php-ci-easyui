/**
 * autor：gxl
 * repository：https://github.com/saopang/gulp-page.git
 */
var gulp = require('gulp'),
    path = require('path'),
    autoprefixer = require('gulp-autoprefixer'), //- 添加兼容前缀
    cssnano = require('gulp-cssnano'), //-压缩css
    md5 = require("gulp-md5-plus"), //md5去缓存（修改了源码）
    sourcemaps = require('gulp-sourcemaps'), //-添加map文件
    uglify = require('gulp-uglify'), //js压缩混淆
    concat = require('gulp-concat'), //文件合并all-in-one
    spritesmith = require('gulp.spritesmith'), //雪碧图
    rename = require("gulp-rename"); // rename重命名

var mcPath = {
    css: ['resources/css/login.css', 'resources/css/style.css'],
    js: ['resources/js/jquery.min.js', 'resources/js/jquery.easyui.min.js','resources/js/jquery.easyui.plus.js', 'resources/js/common.js', 'resources/js/easyui-lang-zh_CN.js', 'resources/js/mc.js'],
    img: ['resources/img/icons'],
    theme:  ['resources/themes/']
};

var mPath = {
    css: ['resources/themes/material/easyui.css', 'resources/themes/mobile.css', 'resources/themes/color.css', 'resources/css/iosSelect.css', 'resources/css/m.css'],
    js: ['resources/js/jquery.min.js', 'resources/js/jquery.easyui.min.js','resources/js/jquery.easyui.mobile.js', 'resources/js/easyui-lang-zh_CN.js', 'resources/js/iosSelect.js', 'resources/js/m.js'],
};

var distPath = {
    css: ['resources/dist/css/'],
    js: ['resources/dist/js/'],
    img: ['resources/dist/img/']
}



var _html = 'html/index.html', //需要处理的html文件
    _scssArr = ['src/page/a/scss/*.scss', 'src/lib/scss/*.scss'], //需要处理的scss数组
    _jsArr = ['src/page/a/js/*.js', 'src/lib/js/*.js'], //需要处理的js数组
    _imgArr = [], //需要处理的img数组
    _cssDistDir = 'dist/css/a/', //发布的css目录
    _cssMapsDir = 'dist/maps/a/', // 发布的cssMaps目录
    _cssDistName = 'a.min.css', //发布的css名称
    _jsDistDir = 'dist/js/a/', //发布的js目录
    _jsMapsDir = 'dist/maps/a/', // 发布的jsMaps目录
    _jsDistName = 'a.min.js'; //发布到js名称
// css雪碧图，生成的雪碧图和对应的css，需手动替换
gulp.task('sprite', function() {
    var spriteData = gulp.src(_imgArr).pipe(spritesmith({
        imgName: 'sprite.png',
        cssName: 'sprite.css'
    }));
    return spriteData.pipe(gulp.dest('dist/sprite/'));
});
//scss预处理（合并，解析，兼容前缀，压缩，sourcemaps）
gulp.task('scssTask', function() {
    gulp.src(_scssArr) //- 需要处理的scss文件，放到一个数组里
        .pipe(sourcemaps.init())
        .pipe(sass()).on('error', sass.logError)
        .pipe(concat(_cssDistName)) //合并scss
        .pipe(autoprefixer()) //- 添加兼容性前缀
        // .pipe(px2rem({remUnit: 75}))
        // .pipe(base64({extensions: [/\.(jpg|png)#base64/i]}))  //后缀为#base64的小于32k的图片会被转为base64
        // .pipe(cssnano()) //-压缩css
        .pipe(rename(_cssDistName)) //重命名css
        .pipe(sourcemaps.write(path.relative(_cssDistDir, _cssMapsDir), {
            sourceMappingURL: function(file) {
                return '/' + _cssMapsDir + file.relative + '.map';
            }
        })) //- maps另存
        .pipe(gulp.dest(_cssDistDir)) //- 处理得到的css文件发布到对应目录
        .pipe(md5(10, _html)); //处理html引用加入md5去缓存
});
//js预处理（合并，压缩混淆，sourcemaps）
gulp.task('jsTask', function() {
    gulp.src(_jsArr) //- 需要处理的js文件，放到一个字符串里
        .pipe(sourcemaps.init()) //- map初始化
        .pipe(concat(_jsDistName)) //合并js
        .pipe(uglify()) //-压缩混淆js
        .pipe(sourcemaps.write(path.relative(_jsDistDir, _jsMapsDir), {
            sourceMappingURL: function(file) {
                return '/' + _jsMapsDir + file.relative + '.map';
            }
        })) //- maps另存
        .pipe(gulp.dest(_jsDistDir)) //- 处理得到的js文件发布到对应目录
        .pipe(md5(10, _html)); //处理html引用加入md5去缓存
});
//监听文件变化，处理scss，刷新浏览器
gulp.task('watch', function() {
    gulp.watch(_html, ['reload']); //html变化刷新浏览器
    gulp.watch(_scssArr, ['scssTask', 'reload']); //scss变化，处理scss，刷新浏览器
    gulp.watch(_jsArr, ['jsTask', 'reload']); //js变化，处理js，刷新浏览器
});
//设置默认任务
gulp.task('default', ['web']);
//开发任务
gulp.task('dev', ['scssTask', 'jsTask', 'web', 'watch']);
//发布任务
gulp.task('pub', ['web']);
