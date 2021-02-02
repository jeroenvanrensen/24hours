module.exports = {
	purge: [
		'./resources/**/*.blade.php'
	],
	darkMode: false,
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
			opacity: ['group-focus'],
			backgroundColor: ['group-focus'],
			display: ['group-hover', 'group-focus']
		}
	},
	plugins: []
}
