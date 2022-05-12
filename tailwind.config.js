module.exports = {
  mode:'jit',
  content: [ './template-parts/*.php','./functions/*.php'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
      'sans': ['ui-sans-serif', 'system-ui'],
      'serif': ['ui-serif', 'Georgia'],
      'mono': ['ui-monospace', 'SFMono-Regular'],
      'intro': ['Inspiration'],
      'body': ['"Nunito"'],
      },
      fontSize: {
        '7xl': '5rem',
      }
    },
      container: {
        center: true,
        padding: '2rem',
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
        }
    },
  },
  variants: {
    extend: {
      opacity: ['group-hover'],
    }
  },
  plugins: [
    require('@tailwindcss/forms'),

  ],
}