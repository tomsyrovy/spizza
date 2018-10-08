module.exports = function(grunt) {

	grunt.initConfig({


		// Pospojuj JS
		concat: {
			js: {
				options: {
					separator: ';'
				},
				src: [

				/// Third party components

				// Swiper.js
				'node_modules/swiper/dist/js/swiper.jquery.js',


				// Fancybox.js
				// 'bower_components/fancybox/dist/jquery.fancybox.js',


				// FastCLick
				'node_modules/fastclick/lib/fastclick.js',

				/// Own components
				'js/functions.js',
				'js/domReady.js',


				'js/main.js'

				],
				dest: '../web/assets/js/main.min.js'
			}
		},





		// Minifikuj JS
		uglify: {
			options: {
				mangle: false
			},
			js: {
				files: {
					'../web/assets/js/main.min.js': ['../web/assets/js/main.min.js']
				}
			}
		},





		// Kompiluj a minifikuj Sass
		sass: {
			style: {
				options: {
		            sourceMap: false,
					outputStyle: 'compressed',
		        },
				files: {
					'../web/assets/css/style.min.css': 'scss/style.scss'
				}
			}
	    },





		// Autoprefixuj
		autoprefixer: {
			options: {
				map: false
			},
			file: {
				src: '../web/assets/css/style.min.css',
				dest: '../web/assets/css/style.min.css'
			}
		},





		// Zkopíruj potřebné dependency komponenty z NPM adresáře, aby šly použít mimo tento adresář
		copy: {
			jquery: {
				files: {
					'../assets/js/jquery.min.js': 'node_modules/jquery/dist/jquery.min.js'
				}
			},
			html5shiv: {
				files: {
					'../assets/js/html5shiv.min.js': 'node_modules/html5shiv/dist/html5shiv.min.js'
				}
			},
			css3mediaqueries: {
				files: {
					'../assets/js/css3-mediaqueries.js': 'node_modules/css3-mediaqueries-js/css3-mediaqueries.js'
				}
			},
			fontawesome: {
				files: [{
					expand: true,
					src: ['node_modules/font-awesome/fonts/*'],
					dest: '../assets/font/fontawesome/',
					filter: 'isFile',
					flatten: true
				}],
			},
		},





		// Notifikace úspěchu a failů pro parádu
		notify: {
			notify_js: {
				options: {
					title: 'Kombinace a minifikace JavaScriptu se povedla!',  // Volitelný
					message: 'Jsi šikovný borec, jen tak dál!' // Povinný
				}
			},
			notify_sass: {
				options: {
					title: 'Sass se zkompilovalo na výbornou!',  // Volitelný
					message: 'Jsi šikovný borec, jen tak dál!' // Povinný
				}
			},
			notify_push: {
				options: {
					title: 'Push se povedl!',  // Volitelný
					message: 'Jsi šikovný borec, jen tak dál!' // Povinný
				}
			},
			notify_pull: {
				options: {
					title: 'Pull se povedl!',  // Volitelný
					message: 'Jsi šikovný borec, jen tak dál!' // Povinný
				}
			}
		},





		// Sleduj a konej
		watch: {
			configFiles: {
				files: ['gruntfile.js'] // Při aktualizace gruntfile.js jej znovu načti (netřeba watch exitovat a znovu spouštět)
			},
			js: {
				files: ['js/*.js'],
				tasks: ['concat:js', 'uglify:js', 'notify:notify_js'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			less: {
				files: ['scss/**/*.scss'],
				tasks: ['sass:style', 'autoprefixer:file', 'notify:notify_sass'],
				options: {
					spawn: false,
					livereload: true
				}
			}
		},





		// Hashres
		hashres: {
			options: {
				encoding: 'utf8',
				fileNameFormat: '${name}.${ext}?${hash}',
				renameFiles: false
			},
			prod: {
				options: {
				},
				src: ['../web/assets/css/style.min.css', '../web/assets/js/main.min.js'],
				dest: ['../app/Resources/views/base.html.twig'],
			}
		},


	});





	// Naloaduj tasky
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-copy');
	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-hashres');





	// Registruj spouštějící úlohy pro terminál - pro defaultní stačí volat "grunt"
	grunt.registerTask('default', [ 'watch' ]);


};