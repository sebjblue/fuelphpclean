/**
 *  All Grunt tasks use files from src/ and deploy to site/public/assets
 *  When running any Grunt task, the totality of site/public/assets/* is wiped clean
 *  
 */
module.exports = function(grunt){
    // instructions for grunt
    
    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
		sprite:{
			generic: {
				src: "src/sprites/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/generic.png",
				destCss: "site/public/assets/css/sprites/generic.css"
			},
			home: {
				src: "src/sprites/home/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/home.png",
				destCss: "site/public/assets/css/sprites/home.css"
			},
			news: {
				src: "src/sprites/news/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/news.png",
				destCss: "site/public/assets/css/sprites/news.css"
			},
			web: {
				src: "src/sprites/web/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/web.png",
				destCss: "site/public/assets/css/sprites/web.css"
			},
			publishing: {
				src: "src/sprites/publishing/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/publishing.png",
				destCss: "site/public/assets/css/sprites/publishing.css"
			},
			workshop: {
				src: "src/sprites/workshop/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/workshop.png",
				destCss: "site/public/assets/css/sprites/workshop.css"
			},
			about_us: {
				src: "src/sprites/about-us/*.{png,jpg,jpeg,gif}",
				dest: "site/public/assets/img/sprites/about-us.png",
				destCss: "site/public/assets/css/sprites/about-us.css"
			}
		},
        watch:  {
            scripts:  {
                files:  ["src/scripts/**/*.js", "!src/scripts/tests/**/*"],
                tasks:  ["jshint:dev", "copy:dev"],
                options:  {
                    spawn:  false
                }
            },
            styles:  {
                files:  ["**/*.less"],
                tasks:  ["less:dev"],
                options:  {
                    spawn:  false,
                    cwd:  "src/styles/less"
                }
            },
			sprites: {
				files: ["src/sprites/**.{png,jpg,jpeg,gif}"],
				tasks: ["sprite"],
				options: {
					spawn: false
				}
			},
            images: {
				files: ["src/img/**.{png,jpg,jpeg,gif}"],
				tasks: ["copy:images"],
				options: {
					spawn: false
				}
            }
        },
        less: {
            dev: { // parse all LESS files into their CSS equivalents
                files: [
                    {
                        expand: true,
                        cwd: "src/styles/less",
                        src: [ "**/*.less" ],
                        dest: "site/public/assets/css",
                        ext: ".css"
                    }
                ]
            }
        },
        copy: {
            dev: {
                files:  [{
                    expand: true,
                    cwd: "src/scripts/",
                    src: [ "**/*.js", "!tests/**/*" ],
                    dest: "site/public/assets/js/"
                },
                {
                    expand: true,
                    cwd: "src/img/",
                    src: [ "**/*.*" ],
                    dest: "site/public/assets/img/"
                },
                {
                    expand: true,
                    cwd: "src/fonts/",
                    src: [ "**/*.*" ],
                    dest: "site/public/assets/fonts/"
                }]
            },
            images: {
                files:  [{
                    expand: true,
                    cwd: "src/img/",
                    src: [ "**/*.*" ],
                    dest: "site/public/assets/img/"
                }]
            }
        },
        clean: {
			dev: {
				src : ["site/public/assets/css/**/*.*", "site/public/assets/js/**/*.*", "site/public/assets/html/**/*.*"]
			}
        },
        jscs: {
			src: [ "src/scripts/**/*.js", "!src/scripts/tests/**","!src/scripts/libs/**" ]
        },
        jshint: {
            src:  [ "src/scripts/**/*.js", "!src/scripts/tests/**", "!src/scripts/libs/**" ]
        },
        lesslint: {
            dev: {
                src: ["src/styles/less/**/*.less"],
                options: {
                    csslint: {
                        "adjoining-classes": false,
                        "important": false,
                        "ids": false,
                        "box-model": false,
                        "box-sizing": false
                    }
                }
            }
        }
    });

    // on watch events configure jshint: dev to only run on changed file 
    // I have been unable to do so for less: dev
    grunt.event.on("watch", function(action, filepath) {
		grunt.config("jshint.dev.src", filepath);
		//grunt.config("less.dev.files.src", filepath);
    });
    
    // Load the plugins
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-concat");
    grunt.loadNpmTasks("grunt-contrib-cssmin");
    grunt.loadNpmTasks("grunt-contrib-clean");
    grunt.loadNpmTasks("grunt-contrib-copy");
    grunt.loadNpmTasks("grunt-contrib-csslint");
    grunt.loadNpmTasks("grunt-contrib-jshint");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-jscs-checker");
    grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-spritesmith");
    //grunt.loadNpmTasks("grunt-lesslint");

    // validate src files first, then clean the site environment, then process tasks
    grunt.registerTask("dev-build", [ "jshint", "clean:dev", "less:dev", "copy:dev", "sprite" ]);
    grunt.registerTask("test", [ "jshint", "jscs" ]);
};
