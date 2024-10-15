/** @type {import('tailwindcss').Config} */
export default {
  theme: {
    extend: {
      colors: {
        "primary": "#22c55e",
        "primary-light": "#3c9c5e",
        "primary-dark": "#1f4d2b",
        "secondary": {
          100: "#E2E2D5",
          200: "#888883",
        },
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