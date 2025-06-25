/** @type {import('tailwindcss').Config} */
export const content = ["./public/*.php", "./src/templates/*.php"]
export const theme = {
  extend: {
    colors: {
      "regular-gradient-dark-cl": "var(--vcn-regular-gradient-dark-cl)",
      "regular-blue-1": "var(--vcn-regular-blue-1)",
      "regular-blue-2": "var(--vcn-regular-blue-2)",
      "regular-blue-3": "var(--vcn-regular-blue-3)",
      "regular-blue-4": "var(--vcn-regular-blue-4)",
      "regular-blue-5": "var(--vcn-regular-blue-5)",
      "regular-blue-6": "var(--vcn-regular-blue-6)",
      "regular-blue-cl": "var(--vcn-regular-blue-cl)",
    },
  },
}
export const plugins = []
