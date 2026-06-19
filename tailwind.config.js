/** @type {import('tailwindcss').Config} */

// ── alshaafionline brand palette ──────────────────────────────────────────────
// The guest UI historically used a generic blue → purple → pink "rainbow".
// To deliver a cohesive, branded look without touching any page logic we remap
// those legacy color families to a harmonious, health-oriented brand scheme:
//   blue/indigo → emerald (primary)   purple → teal (secondary)   pink → cyan (accent)
// Real green / red / amber accents are intentionally left untouched.
const brandEmerald = {
  50: "#ecfdf5", 100: "#d1fae5", 200: "#a7f3d0", 300: "#6ee7b7", 400: "#34d399",
  500: "#10b981", 600: "#059669", 700: "#047857", 800: "#065f46", 900: "#064e3b", 950: "#022c22",
};
const brandTeal = {
  50: "#f0fdfa", 100: "#ccfbf1", 200: "#99f6e4", 300: "#5eead4", 400: "#2dd4bf",
  500: "#14b8a6", 600: "#0d9488", 700: "#0f766e", 800: "#115e59", 900: "#134e4a", 950: "#042f2e",
};
const brandCyan = {
  50: "#ecfeff", 100: "#cffafe", 200: "#a5f3fc", 300: "#67e8f9", 400: "#22d3ee",
  500: "#06b6d4", 600: "#0891b2", 700: "#0e7490", 800: "#155e75", 900: "#164e63", 950: "#083344",
};

export default {
  darkMode: 'class', // Enable class-based dark mode
  theme: {
    extend: {
      colors: {
        "primary": "#059669",
        "primary-light": "#10b981",
        "primary-dark": "#065f46",
        "hover": "#e2e8f0",
        "secondary": {
          100: "#E2E2D5",
          200: "#888883",
        },
        // Brand wordmark / utility tokens
        "brand": brandEmerald,
        "brand-teal": brandTeal,
        "brand-cyan": brandCyan,
        // Minimalist rebrand: collapse the legacy multi-hue families to a single
        // emerald accent so all the old rainbow gradients/cards render as one
        // calm brand color over neutral surfaces.
        "blue": brandEmerald,
        "indigo": brandEmerald,
        "purple": brandEmerald,
        "pink": brandEmerald,
      },
    },
  },
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],

  plugins: [],
}