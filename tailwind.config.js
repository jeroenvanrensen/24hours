module.exports = {
    mode: 'jit',
    purge: {
        content: ['./resources/**/*.blade.php'],
    },
    darkMode: false,
    theme: {
        extend: {
            fontFamily: {
                sans: '"Poppins", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            },
            spacing: {
                18: '4.5rem',
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/aspect-ratio')],
};
