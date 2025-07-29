function Login() {
  const nombre = document.getElementById("nombre").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("nombre", nombre);
  formData.append("password", password);




  fetch("../Controller/LoginC.php", {
    method: "POST",
    body: formData
  })
    .then(response => {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error('Error en la solicitud');
      }
    }).then(data => {
      const response = JSON.parse(data); // Analiza la respuesta JSON
      if (response.success) {
        Swal.fire({
          title: 'Bienvenido',
          icon: 'success',
          timer: 3000,
          showConfirmButton: false
        }).then(() => {
          window.location.href = "../views/Dashboard.php";
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: 'Nombre de usuario o contraseña incorrectos',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      }
    })
    .catch(error => {
      console.error("Error:", error);
      Swal.fire({
        title: 'Error',
        text: 'Error en la solicitud',
        icon: 'error',
        confirmButtonText: 'Aceptar'
      });
    });
}