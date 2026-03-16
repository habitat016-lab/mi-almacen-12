// public/js/foto-empleado.js
console.log('✅ JS CARGADO');

window.initFotoEmpleado = function(empleadoId, fotoActual) {
    console.log('FUNCIÓN LLAMADA para empleado:', empleadoId);
    
    const container = 
document.getElementById(`foto-empleado-container-${empleadoId}`);
    if (!container) {
        console.error('❌ Container no encontrado');
        return;
    }
    
    container.innerHTML = `
        <div style="background: green; color: white; padding: 20px; 
border-radius: 8px; text-align: center; font-size: 18px;">
            ✅ FUNCIONA - Empleado ID: ${empleadoId}
        </div>
    `;
};
