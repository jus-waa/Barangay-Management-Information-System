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
        '2.1': '9.5px',
        '4.5': '18px',
        '13': '3.25rem',
        '18': '4.5rem',
        '26': '6.6rem',
        '22': '5.6rem',
        '38': '9.4rem',
        '5.5': '22px',
        '50': '204px', 
        '54': '13.225rem', 
        '76': '19rem',
        '100': '34rem',
      },
      boxShadow: {
        'max': '2px 2px 10px 1000px rgba(0, 0, 0, 0.5)',
      }
    },
  },
  plugins: [function ({ addUtilities }) {
    addUtilities({
      /* Hide scrollbar for Chrome, Safari, and Edge */
      '.no-scrollbar::-webkit-scrollbar': {
        display: 'none',
      },
      /* Hide scrollbar for Firefox */
      '.no-scrollbar': {
        scrollbarWidth: 'none',
      },
    });
  },],
}

