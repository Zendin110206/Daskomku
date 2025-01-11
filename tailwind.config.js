import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            cursor: {
                'Wand': "url('../../public/assets/Wand.cur'), default",
            },
            backgroundImage: {
                'PlaceHolder': "url('../../public/images/login-placeholder.png')",
                'Button': "url('../../public/assets/Button Pink.png')",
                'LoginAdmin': "url('../../public/assets/Background 1.png')",
                'LoginCaAs': "url('../../public/assets/Background 2.png')",
                'HomePageCaAs': "url('../../public/assets/Background 2.png')",
                'ChangePassword' : "url('../../public/assets/Background 2.png')",
                'AssistantsPage' : "url('../../public/assets/Background 3.png')",
                'Announcement' : "url('../../public/assets/Background 4.png')",
                'StoneModel' : "url('../../public/assets/Stone Model.png')",
                'BlackLayer' : "url('../../public/assets/Black Layer.png')",
                'Profile': "url('../../public/assets/Background 2.png')",
            },
            fontFamily: {
                'im-fell-english': ['"IM Fell English"', 'serif'],
                'crimson-text': ['"Crimson Text"', 'serif'],
                'rye' : ['"Rye"', 'serif'],
            },
            colors: {
                'primary': '#1A2254',
                'scrollbar-thumb': '#3b82f6', // Tailwind blue-500
                'scrollbar-track': '#e5e7eb', // Tailwind gray-200
                'profile': '#270750',
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
            screens: {
                'sm': '576px',
          
                'md': '960px',
          
                'lg': '1440px',
            },
        },
    },
    plugins: [],
};
