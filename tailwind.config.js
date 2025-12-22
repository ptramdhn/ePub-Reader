import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    // Bagian ini menggantikan @source yang ada di CSS tadi
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                // Menggunakan font bawaan Laravel (Figtree) atau fallback ke sans
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Palet Warna UIN FST
                uin: {
                    yellow: "#FFC700",
                    blue: "#0F265C",
                    green: "#009B4C",
                    light: "#F3F4F6",
                    dark: "#111827",
                },
            },
        },
    },
    plugins: [],
};
