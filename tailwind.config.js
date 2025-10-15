/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
                'custom-green': '#7fdea0', // Adicione esta linha
                'custom-green-hover': '#94f4a6', // E esta para o hover
            },
    },
  },
  plugins: [],
}