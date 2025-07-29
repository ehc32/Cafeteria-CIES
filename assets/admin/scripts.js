"use strict";

const pathname = window.location.pathname;
const base_url = document.getElementById("base_url").value;

// Función para cambiar el estado Notificaciones
function change(e) {
    e.nextElementSibling.nextElementSibling.value = e.checked ? 1 : 0;
}

// llamar al dialogo de pregunta (eliminar)
function delete_item(url, id, text, sede = null) {
	let data = {
		url: url,
		id: id,
		icon: "success",
		title: text,
	};

	if (sede) {
		data.sede = sede;
	}
	swalConfirmation(data);
	console.log(data)
}



// definir el Swal
const swalWithBootstrapButtons = Swal.mixin({
	customClass: {
		confirmButton: "btn btn-success",
		cancelButton: "btn btn-danger",
	},
	buttonsStyling: false,
});

// Alert de confirmación
function swalConfirmation(data) {
	swalWithBootstrapButtons
		.fire({
			title: "¿Estás seguro de eliminar los datos?",
			text: "¡Tenga en cuenta que esta acción en irreversible!",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Si, Eliminar",
			cancelButtonText: "No, Cancelar",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				// ejecutar el POST
				executePost(data);
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				/* poner evento */
				/* Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            }) */
			}
		});
}
function executePost({
	url = "url",
	id = "",
	value = "",
	icon = "success",
	title = "",
	sede = null 
}) {
	let data = {
		id: id,
		value: value,
	};

	if (sede) {
		data.sede = sede;
	}
	console.log(data)
	fetch(url, {
		headers: {
			"Content-Type": "application/json",
		},
		method: "POST",
		body: JSON.stringify(data),
	})
		.then((response) => response.json())
		.then(function (result) {
			console.log(result);

			if (result["status"]) {
				swalTop(icon, title, 3000);
			} else {
				swalTop("error", "¡Error, no está permitida esta acción!", 3000);
			}
			setTimeout(function () {
				window.location.reload(); 
			}, 3000);
		})
		.catch(function (error) {
			console.log(error);
		});
}



// Ejecutar un swal al borde superior derecho
function swalTop(icon, title, timer) {
	Swal.fire({
		position: "top-end",
		icon: icon,
		title: title,
		showConfirmButton: false,
		timer: timer,
	});
}








