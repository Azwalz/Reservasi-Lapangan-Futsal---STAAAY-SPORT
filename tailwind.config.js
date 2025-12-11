/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        navy: '#0B1D3A',
        pinklight: '#F472B6',
        pinkstrong: '#EC4899',
        lightgray: '#F3F4F6',
        darkgray: '#374151',
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
    },
  },
  plugins: [],
}
