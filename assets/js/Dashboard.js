function cerrar_sesion() {
  Swal.fire({
    title: '¿Deseas cerrar sesión?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, cerrar sesión'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '../Controller/logout.php';
;
    } else {
      console.log('Cierre de sesión cancelado');
    }
  });
}