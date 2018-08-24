module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            css: {
                src: ['assets/css/function/animate.css','assets/css/function/message.css'],//当前grunt项目中路径下的src/css目录下的所有css文件
                dest: 'assets/css/function.css'  //生成到grunt项目路径下的dist文件夹下为all.css
                },
            css2: {
                src: ['assets/css/iconfont.css','assets/css/owo.css','assets/css/app.css','assets/css/custom.css','assets/css/fontello.css'],
                dest: 'assets/css/handsome.css'
            }

        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'assets/js/core.js',
                dest: 'assets/js/core.min.js'
            },
            build2: {
                src: 'assets/js/music.js',
                dest: 'assets/js/music.min.js'
            },
            build3: {
                src: 'assets/js/features/setting.js',
                dest: 'assets/js/features/setting.min.js'
            },
            build4: {
                src: 'assets/js/features/OwO.js',
                dest: 'assets/js/features/OwO.min.js'
            }
        },

        cssmin: {
            //文件头部输出信息
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                //美化代码
                beautify: {
                    //中文ascii化，非常有用！防止中文乱码的神配置
                    ascii_only: true
                }
            },
            build3: {
                src: 'assets/css/handsome.css',
                dest: 'assets/css/handsome.min.css',
            },
            build: {
                src: 'assets/css/function.css',
                dest: 'assets/css/function.min.css'
            },
            build4: {
                src: 'assets/css/features/coolopacity.css',
                dest: 'assets/css/features/coolopacity.min.css'
            }
        }

    });
 
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin'); 

    grunt.registerTask('default', ['concat', 'uglify','cssmin']);
 
};