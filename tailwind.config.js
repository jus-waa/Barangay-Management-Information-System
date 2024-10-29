/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        'pg': '#53A548', // pigment green
        'sg': '#4C934C', // sea green
        'c': '#AFE1AF', // very light green
        'lg': '#9ccc65',
        'dg': '#689f38',
      },
      translate: {
        '13.5': '3.3rem',
      },
      screens: {
        'll': '1450px',
        'st': '1366px',
      },
      spacing: {
        '13': '3.25rem',
        '18': '4.5rem',
        '26': '6.6rem',
        '22': '5.6rem',
        '38': '9.4rem',
        '5.5': '22px',
      },
      boxShadow: {
        'max': '2px 2px 10px 1000px rgba(0, 0, 0, 0.5)',
      }
    },
  },
  plugins: [],
}

