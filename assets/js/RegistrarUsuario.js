function registrarUsuario() {
    nombre = document.getElementById('usuario').value
    rol = document.getElementById('rol').value
    password = document.getElementById('password').value


    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("rol", rol);
    formData.append("password", password);

    fetch("./../Controller/registrarUsuarioC.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (response.ok) {
                return response.text(); // Obtener la respuesta como texto
            } else {
                throw new Error('Error en la solicitud');
            }
        }).then(data => {
            if (data.trim() === "true") {
                Swal.fire({
                    title: 'Usuario registrado con éxito',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Revise los datos y vuelva a intentarlo',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
            loadtable();
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

function loadtable() {

    fetch("./../Controller/registrarUsuarioC.php", {
        method: "GET",
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error en la solicitud');
            }
        })
        .then(data => {
            console.log(data)
            const tbody = document.getElementById('tablaUsuarios');
            tbody.innerHTML = '';
            data.forEach(usuario => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${usuario.id}</td><td>${usuario.nombre}</td><td>${usuario.rol}</td><td>${usuario.password}</td><td class="opcionesFila"><i class="bi bi-trash" onclick="confirmarEliminar(${usuario.id})"></i></td>`;
                tbody.appendChild(row);
            });

        })
        .catch(error => {
            console.error("Error encontrado:", error);
        });
} 

function confirmarEliminar(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llamar a la función para eliminar el usuario
            eliminarUsuario(userId);
        }
    });
}

function eliminarUsuario(userId) {
    // Crear un objeto con el ID del usuario
    var data = { id: userId };

    fetch("./../Controller/registrarUsuarioC.php", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (response.ok) {
                return response.text(); // Obtener la respuesta como texto
            } else {
                throw new Error('Error en la solicitud');
            }
        })
        .then(data => {
            if (data === "true") {
                Swal.fire({
                    title: 'Usuario eliminado con éxito',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'El usuario no pudo ser eliminado',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
            loadtable();
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
