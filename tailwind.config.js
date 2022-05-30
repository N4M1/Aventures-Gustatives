module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    letterSpacing: {
      'widest': '.25em',
    },
    extend: {
      colors: {
        'button-green': '#79a363',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
