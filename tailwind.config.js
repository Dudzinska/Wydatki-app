import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {

                glamour: {
                    dark: '#0f172a',
                    gold: '#ca8a04',
                    light: '#f8fafc',
                }
            },
            fontFamily: {

                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {

                'soft': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            }
        },
    },

    plugins: [forms],
};
