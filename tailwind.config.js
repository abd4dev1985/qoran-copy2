const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  darkMode: 'class',
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      screens: {
          'shortMobile': {'raw': '(max-height:750px)'},
           // => @media (max-width: 400px) { ... }
          'mobile': {'max': '900px'},
          // => @media (max-width: 900px) { ... }
          'tab': {'min': '480px'},
          // => @media (min-width: 800px) { ... }
          'larg': {'min': '901px'},
          // => @media (min-width: 1000px) { ... }
          }
      ,    
      fontFamily: {
          sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      backgroundImage:  {
        'qurancover': "url('/img/qurancover.png')",  
        'pagecover': "url('/img/copy.png')",  
              },
  }, 


  },
  plugins: [],
}
