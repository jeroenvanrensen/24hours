module.exports = {
	purge: [
		'./resources/**/*.blade.php'
	],
	darkMode: 'media',
	theme: {
		extend: {
			colors: {
				blue: {
					800: '#3c589f'
				},
				gray: {
					100: '#ececec'
				}
			}
		}
	},
	variants: {
		extend: {
			opacity: ['group-focus', 'dark'],
			backgroundColor: ['group-focus'],
			display: ['group-hover', 'group-focus']
		}
	},
	plugins: []
}
