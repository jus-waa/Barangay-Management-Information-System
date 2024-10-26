/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        'dg': '#579656', // pigment green
        'lg': '#76D174', // sea green
      },
      translate: {
        '13.5': '3.3rem',
      },
      screens: {
        'll': '1440px',
        'st': '1366px',
      },
      spacing: {
        '13': '3.25rem',
        '18': '4.5rem',
      },
    },
  },
  plugins: [],
}

