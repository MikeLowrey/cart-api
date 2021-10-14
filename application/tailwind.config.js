module.exports = {
    purge: {
        enabled: false,
        content: [
            './resources/views/**/*.blade.php',
            './resources/js/**/*.blade.php',
        ],
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}