import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: 'media',
    theme: {
        extend: {
            colors: {
                green: "#34a72a",
                orange: "#c9812f",
                red: "#ca3737",
                blue: "#129bbd",
                primary: {
                    "50": "#E5F6F5",
                    "100": "#CCEDEB",
                    "200": "#99DBD7",
                    "300": "#66C9C4",
                    "400": "#33B7B1",
                    "500": "#0E7C7B",
                    "600": "#0A6364",
                    "700": "#07524D",
                    "800": "#053F3A",
                    "900": "#032C27",
                    "950": "#021E1B"
                },
            }
        },
        fontFamily: {
            sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
