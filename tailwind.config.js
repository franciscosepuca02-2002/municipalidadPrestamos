/** @type {import('tailwindcss').Config} */
module.exports = {
      content: [
              "./application/views/**/*.php",
              "./application/views/**/*.html",
              "./application/controllers/**/*.php",
              "./application/models/**/*.php",
              "./application/config/**/*.php",
              "./assets/js/**/*.js",
      ],
      theme: {
              extend: {
                      colors: {
                              fondo: "#EFF7FF",
                              suave: "#DCEDFD",
                              borde: "#C0E0FD",
                              boton: "#2973E7",
                              hover: "#215DD4",
                              texto: "#204388",
                              titulo: "#182A53",
                      },
              },
      },
      plugins: [],
};