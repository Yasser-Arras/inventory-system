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
        // SURFACES
        surface: "#f8f9ff",
        "surface-dim": "#cbdbf5",
        "surface-bright": "#f8f9ff",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#eff4ff",
        "surface-container": "#e5eeff",
        "surface-container-high": "#dce9ff",
        "surface-container-highest": "#d3e4fe",

        // TEXT
        "on-surface": "#0b1c30",
        "on-surface-variant": "#3c4a42",

        // INVERSE
         "inverse-on-surface": "#eaf1ff",
        "inverse-surface": "#213145",
  
        "inverse-primary": "#4edea3",

        // OUTLINE
        outline: "#6c7a71",
        "outline-variant": "#bbcabf",
 quandale: "#16ad48",
        // PRIMARY (GREEN)
        primary: "#006c49",
        "primary-container": "#10b981",
        "on-primary": "#ffffff",
        "on-primary-container": "#00422b",
        "primary-fixed": "#6ffbbe",
        "primary-fixed-dim": "#4edea3",
        "on-primary-fixed": "#002113",
        "on-primary-fixed-variant": "#005236",

        // SECONDARY (BLUE)
        secondary: "#0058be",
        "secondary-container": "#2170e4",
        "on-secondary": "#ffffff",
        "on-secondary-container": "#fefcff",
        "secondary-fixed": "#d8e2ff",
        "secondary-fixed-dim": "#adc6ff",
        "on-secondary-fixed": "#001a42",
        "on-secondary-fixed-variant": "#004395",

        // TERTIARY (RED)
        tertiary: "#a43a3a",
        "tertiary-container": "#fc7c78",
        "on-tertiary": "#ffffff",
        "on-tertiary-container": "#711419",
        "tertiary-fixed": "#ffdad7",
        "tertiary-fixed-dim": "#ffb3af",
        "on-tertiary-fixed": "#410005",
        "on-tertiary-fixed-variant": "#842225",

        // ERROR
        error: "#ba1a1a",
        "error-container": "#ffdad6",
        "on-error": "#ffffff",
        "on-error-container": "#93000a",

        // BACKGROUND
        background: "#f8f9ff",
        "on-background": "#0b1c30",
      },

      spacing: {
        gutter: "24px",
        "margin-desktop": "32px",
        "margin-mobile": "16px",
        unit: "4px",
        "container-max-width": "1440px",
      },

      fontSize: {
        "headline-lg": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em" }],
        "headline-lg-mobile": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em" }],
        "headline-md": ["20px", { lineHeight: "28px" }],

        "body-md": ["16px", { lineHeight: "24px" }],
        "body-sm": ["14px", { lineHeight: "20px" }],

        "label-md": ["14px", { lineHeight: "20px", fontWeight: "500" }],
        "label-caps": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "700" }],
      },

      borderRadius: {
        sm: "0.25rem",
        DEFAULT: "0.5rem",
        md: "0.75rem",
        lg: "1rem",
        xl: "1.5rem",
        full: "9999px",
      },
    },
  },

  plugins: [require("@tailwindcss/forms")],
};