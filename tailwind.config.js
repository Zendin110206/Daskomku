import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "custom-gray": "#D9D9D9",
                "custom-blue": "#1A2254",
                "footer-gray": "#BBBBBB",
                "text-color": "#1A2254",
                'custom-green': '#52541A',
            },
            fontFamily: {
                "im-fell-english": ['"IM Fell English"', "serif"],
            },
        },
    },
    plugins: [],
};
