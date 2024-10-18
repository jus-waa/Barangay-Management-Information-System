/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        'pg': '#53A548', // pigment green
        'sg': '#4C934C', // sea green
        'c': '#AFE1AF'
      },
      fontFamily: {
        serif: ['"Georgia"'],
      },
      translate: {
        '13.5': '3.3rem',
      },
      screens: {
        'll': '1440px',
        'st': '1366px',
      }
    },
  },
  plugins: [],
}

