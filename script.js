// ===========================================
// script.js - Lógica para Cargar Datos
// ===========================================

document.addEventListener('DOMContentLoaded', () => {
    // Solo intenta cargar estudiantes si estamos en la página de administración de estudiantes
    if (document.getElementById('tabla-estudiantes-body')) {
        cargarEstudiantes();
    }
});

// Función para cargar los estudiantes desde el archivo JSON
function cargarEstudiantes() {
    const url = 'data.json'; // URL de tu archivo de datos

    fetch(url)
        .then(response => {
            if (!response.ok) {
                // Si el archivo no se encuentra (ej: error 404), lanzamos un error
                throw new Error(`No se pudo cargar el archivo ${url}. Código: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            renderizarTabla(data);
        })
        .catch(error => {
            console.error('Error al cargar los datos:', error);
            const tablaBody = document.getElementById('tabla-estudiantes-body');
            tablaBody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: #FF7043;">Error de carga: ${error.message}. Verifica que data.json existe y tiene formato JSON válido.</td></tr>`;
        });
}

// Función para insertar los datos en el HTML
function renderizarTabla(estudiantes) {
    const tablaBody = document.getElementById('tabla-estudiantes-body');
    tablaBody.innerHTML = ''; // Limpia el contenido actual

    estudiantes.forEach(estudiante => {
        const fila = document.createElement('tr');
        const estadoClase = estudiante.estado === 'Activo' ? 'estado-activo' : 'estado-inactivo';

        fila.innerHTML = `
            <td>${estudiante.id}</td>
            <td>${estudiante.nombre}</td>
            <td>${estudiante.curso}</td>
            <td class="${estadoClase}">${estudiante.estado}</td>
            <td><button class="btn-tabla editar" data-id="${estudiante.id}"><i class="fas fa-edit"></i></button></td>
        `;
        tablaBody.appendChild(fila);
    });
}
