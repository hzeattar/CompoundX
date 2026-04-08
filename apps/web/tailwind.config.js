/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,ts}"],
  theme: {
    extend: {
      colors: {
        ink: "#0e1a22",
        paper: "#edf2ef",
        sand: "#e4b363",
        mint: "#4fb0a7",
        "deep-teal": "#123745"
      }
    }
  },
  plugins: []
};
