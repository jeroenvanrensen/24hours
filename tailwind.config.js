module.exports = {
    mode: 'jit',
    purge: {
        content: ['./resources/**/*.blade.php'],
    },
    darkMode: 'media',
    theme: {
        extend: {
            fontFamily: {
                sans: '"Poppins", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            },
            colors: {
                blue: {
                    800: '#3c589f',
                },
                gray: {
                    100: '#ececec',
                },
            },
        },
    },
    variants: {
        extend: {
            opacity: ['group-focus', 'dark'],
            backgroundColor: ['group-focus'],
            display: ['group-hover', 'group-focus'],
        },
    },
    plugins: [],
};
