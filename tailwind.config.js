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
                "ungu-muda": "#4D5083",
                "ungu-keputihan": "#ACAEC9",
                "biru-tua": "#1A2254",
                "biru-tua2": "#1A2C54",
                "hijau-tua": "#1A5421",
                "abu-abu-keunguan": "#BAC5E9",
                "merah-tua": "#541A1A",
                "abu-abu2": "#BFBAE9",
                "abu-abu3": "#AC9FB5",
                "abu-abu4": "#BABCE9",
                "biru-tua3": "#271A54",
                "putih": "#fefefe",


            },
            fontFamily: {
                "im-fell-english": ["IM Fell English", "serif"],
            },
        },
    },
    plugins: [],
};
