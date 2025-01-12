/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      keyframes: {
        wiggle: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        }, 
        shake: {
          '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
          '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
          '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
          '40%, 60%': { transform: 'translate3d(4px, 0, 0)' },
        },
      },
      animation: {
        wiggle: 'wiggle 1s ease-in-out infinite',
        shake: 'shake 0.82s cubic-bezier(.36,.07,.19,.97) both',
      },
      colors: {
        'pg': '#53A548', // pigment green
        'sg': '#4C934C', // sea green
        'c': '#AFE1AF', // very light green
        'notif': '#FFF2D0', // very light yellow
        'text-notif': "#937E43", // dark yellow
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
        '23': '5.8rem',
        '38': '9.4rem',
        '5.5': '22px',
        '42': '10.8rem',
        '50': '204px', 
        '54': '13.225rem', 
        '76': '19rem',
        '100': '34rem',
      },
      boxShadow: {
        'max': '2px 2px 10px 1000px rgba(0, 0, 0, 0.5)',
        '3xl': '2px 2px 15px -5px rgba(0, 0, 0, 0.5)'
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

