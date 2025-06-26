/** @type {import('tailwindcss').Config} */
export default {
  content: ["./src/views/**/*.php", "./src/views/**/*.html", "./public/**/*.js"],
  theme: {
    extend: {
      colors: {
        "regular-gradient-dark-cl": "var(--vcn-regular-gradient-dark-cl)",
        "regular-blue-1": "var(--vcn-regular-blue-1)",
        "regular-blue-2": "var(--vcn-regular-blue-2)",
        "regular-blue-3": "var(--vcn-regular-blue-3)",
        "regular-blue-4": "var(--vcn-regular-blue-4)",
        "regular-blue-cl": "var(--vcn-regular-blue-cl)",
      },
    },
  },
  plugins: [],
}
