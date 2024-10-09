// Cuando el documento esté listo, añade la clase para activar el efecto de zoom
jQuery(document).ready(function ($) {
  setTimeout(function () {
    $(".wb-whatsapp-button").addClass("show");
  }, 500); // Retardo de 500 ms antes de mostrar el efecto
});
