import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { webcrypto as crypto } from "node:crypto";

if (!globalThis.crypto) {
    globalThis.crypto = crypto;
}

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
