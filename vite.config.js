import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // Konfigurasi server ini opsional, tapi boleh dibiarkan jika sebelumnya ada
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
