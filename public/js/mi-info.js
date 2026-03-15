/**
 * Script independiente para mostrar información del usuario
 * No depende de Filament, funciona por sí solo
 */

document.addEventListener('DOMContentLoaded', function() {
    // Hacer petición a nuestra API interna
    fetch('/api/usuario-actual')
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo obtener la información del 
usuario');
            }
            return response.json();
        })
        .then(data => {
            // Crear el contenedor principal
            const contenedor = document.createElement('div');
            
            // Estilos del contenedor (exactamente como en la imagen)
            contenedor.style.backgroundColor = '#d1fae5';      // Verde 
claro
            contenedor.style.padding = '12px 20px';            // 
Espaciado interno
            contenedor.style.borderRadius = '12px';            // Bordes 
redondeados
            contenedor.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)'; // 
Sombra suave
            contenedor.style.position = 'fixed';               // Posición 
fija
            contenedor.style.top = '10px';                     // A 10px 
del borde superior
            contenedor.style.right = '20px';                   // A 20px 
del borde derecho
            contenedor.style.zIndex = '9999';                  // Por 
encima de todo
            contenedor.style.fontFamily = 'system-ui, -apple-system, 
sans-serif';
            
            // Contenido HTML con los datos
            contenedor.innerHTML = `
                <div style="font-size:11px; color:#047857; 
font-weight:600; letter-spacing:0.5px;">
                    BIENVENIDO:
                </div>
                <div style="font-weight:700; color:#111827; 
font-size:16px;">
                    ${data.nombre}
                </div>
                <div style="font-size:13px; color:#047857; 
font-weight:500; margin-top:2px;">
                    ${data.puesto}
                </div>
            `;
            
            // Agregar el contenedor al cuerpo de la página
            document.body.appendChild(contenedor);
        })
        .catch(error => {
            // Si hay error, solo lo registramos en consola (no mostramos 
nada)
            console.log('Información de usuario no disponible:', 
error.message);
        });
});
