/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./tailwind-compile-classes/**/*.html.twig",
        "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            colors: {
                pale: "#F9F9F9",
            },
            boxShadow: {
                main: "0 2px 2px 0 rgba(9, 9, 11, 0.05)",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
