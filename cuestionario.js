document.addEventListener("DOMContentLoaded", () => {

  const form = document.getElementById("formCuestionario");

  form.addEventListener("submit", (e) => {
    e.preventDefault(); // Evita recargar la página

    const usuario = document.getElementById("usuario").value.trim();
    const edad = document.getElementById("edad").value.trim();
    const nacionalidad = document.getElementById("nacionalidad").value.trim();
    const opinion = document.getElementById("opinion").value.trim();
    const calificacion = document.getElementById("calificacion").value;
    const reporte = document.getElementById("reporte").checked;

    // Validaciones básicas
    if (!usuario || !edad || !nacionalidad || !opinion) {
      alert("Por favor completa todos los campos obligatorios.");
      return;
    }

    if (usuario.length > 15) {
      alert("El usuario no puede tener más de 15 caracteres.");
      return;
    }

    if (edad < 13) {
      alert("Debes tener al menos 13 años.");
      return;
    }

    // Crear objeto final para usarlo luego o enviarlo a un servidor
    const datos = {
      usuario,
      edad,
      nacionalidad,
      opinion,
      calificacion: calificacion || "Sin calificar",
      reporte: reporte ? "Sí reportó" : "No reportó"
    };

    console.log("Datos enviados:", datos);

    alert("¡Gracias por enviar tu opinión!");

    form.reset(); // Limpia el formulario
  });

});
