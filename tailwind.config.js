module.exports = {
	purge: {
		content: ['./resources/**/*.blade.php'],
		options: {
			safelist: [
				'bg-blue-800', 'bg-red-800',
				'hover:bg-blue-900', 'hover:bg-red-900',
				'focus:bg-blue-900', 'focus:bg-red-900',
				'ring-blue-400', 'ring-red-400'
			]
		}
	},
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
