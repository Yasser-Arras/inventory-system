/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/View/Components/**/*.php",
    ],

    theme: {
        extend: {
            colors: {
                surface: "#f8f9ff",
                "on-surface": "#0b1c30",
                "surface-variant": "#bcc9c0",
                "on-surface-variant": "#3c4a42",
                primary: "#006c49",
                "on-primary": "#ffffff",
                "primary-container": "#a0f0d8",
                "on-primary-container": "#002117",
                "primary-fixed": "#006c49",
                "primary-fixed-dim": "#09eda4",
                secondary: "#0058be",
                "on-secondary": "#ffffff",
                tertiary: "#a43a3a",
                error: "#ba1a1a",
                "inverse-surface": "#0f1410",
                "inverse-on-surface": "#f1f5f1",
                "surface-container": "#e5eeff",
                "surface-container-low": "#eff4ff",
                "surface-container-high": "#dce9ff",
                "surface-container-lowest": "#ffffff",
                "outline-variant": "#bbcabf",
                "surface-bright": "#ffffff",
            },
            spacing: {
                gutter: "24px",
                "margin-desktop": "32px",
            },
            fontSize: {
                "headline-lg": ["30px", { lineHeight: "38px" }],
                "label-md": ["14px", { lineHeight: "20px" }],
                "body-md": ["16px", { lineHeight: "24px" }],
            },
            borderRadius: {
                xl: "0.75rem",
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
}