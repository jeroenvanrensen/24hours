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
                mono: '"Source Code Pro", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
            },
            spacing: {
                18: '4.5rem',
            },
            typography(theme) {
                return {
                    dark: {
                        css: {
                            color: theme('colors.gray.200'),
                            '[class~="lead"]': { color: theme('colors.gray.400') },
                            a: { color: theme('colors.gray.100') },
                            strong: { color: theme('colors.gray.100') },
                            'ul > li::before': { backgroundColor: theme('colors.gray.400') },
                            hr: { borderColor: theme('colors.gray.800') },
                            blockquote: {
                                color: theme('colors.gray.100'),
                                borderLeftColor: theme('colors.gray.800'),
                            },
                            h1: { color: theme('colors.gray.100') },
                            h2: { color: theme('colors.gray.100') },
                            h3: { color: theme('colors.gray.100') },
                            h4: { color: theme('colors.gray.100') },
                            code: { color: theme('colors.gray.100') },
                            'a code': { color: theme('colors.gray.100') },
                            pre: {
                                color: theme('colors.gray.200'),
                                backgroundColor: theme('colors.gray.800'),
                            },
                            thead: {
                                color: theme('colors.gray.100'),
                                borderBottomColor: theme('colors.gray.700'),
                            },
                            'tbody tr': { borderBottomColor: theme('colors.gray.800') },
                        },
                    },
                };
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/aspect-ratio'), require('@tailwindcss/typography')],
};
