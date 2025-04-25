import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react"; // Remove if not using React

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js", // or app.jsx for React
            ],
            refresh: true,
        }),
        react(), // Remove if not using React
    ],
});
