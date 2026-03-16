@props(['empleado' => null])

@php
    // Si empleado es un Closure, lo ejecutamos
    if ($empleado instanceof \Closure) {
        $empleado = $empleado();
    }
@endphp

<div {{ $attributes->merge(['class' => 'foto-empleado-container']) }}>
    <div style="margin: 20px 0; padding: 20px; border: 2px dashed #d1d5db; 
border-radius: 12px; text-align: center; background: #f9fafb;">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; 
font-weight: 600; color: #374151;">Foto del Empleado</h3>
        
        <div id="foto-preview" style="margin-bottom: 20px;">
            @if($empleado && $empleado->foto)
                <img src="{{ Storage::url($empleado->foto) }}" 
                     style="width: 150px; height: 150px; border-radius: 
50%; object-fit: cover; border: 3px solid #d1fae5; box-shadow: 0 4px 6px 
rgba(0,0,0,0.1);">
            @else
                <div style="width: 150px; height: 150px; border-radius: 
50%; background: #e5e7eb; margin: 0 auto; display: flex; align-items: 
center; justify-content: center; color: #6b7280; border: 3px dashed 
#9ca3af;">
                    <span style="font-size: 14px;">Sin foto</span>
                </div>
            @endif
        </div>

        <input type="file" id="foto-input" accept="image/*" 
style="display: none;">

        <div style="display: flex; gap: 10px; justify-content: center;">
            <button 
onclick="document.getElementById('foto-input').click()" 
                    style="padding: 8px 20px; background: #10b981; color: 
white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; 
font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" 
fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Subir foto
            </button>
            
            <button id="eliminar-foto" 
                    style="padding: 8px 20px; background: #ef4444; color: 
white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; 
font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" 
fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 
4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
            </button>
        </div>

        <p style="margin-top: 15px; font-size: 12px; color: #6b7280; 
margin-bottom: 0;">
            Formatos: JPG, PNG. Tamaño máximo: 2MB. 150x150px.
        </p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('foto-input');
        const eliminarBtn = document.getElementById('eliminar-foto');
        const preview = document.getElementById('foto-preview');
        const empleadoId = {{ $empleado->id ?? 'null' }};

        input?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen no debe exceder 2MB');
                return;
            }

            if (!file.type.match('image.*')) {
                alert('Solo se permiten imágenes JPG o PNG');
                return;
            }

            const formData = new FormData();
            formData.append('foto', file);
            formData.append('empleado_id', empleadoId);

            preview.innerHTML = '<div style="width: 150px; height: 150px; 
border-radius: 50%; background: #e5e7eb; margin: 0 auto; display: flex; 
align-items: center; justify-content: center; color: 
#6b7280;">Subiendo...</div>';

            fetch('/api/subir-foto', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    preview.innerHTML = `<img 
src="${data.url}?t=${Date.now()}" style="width: 150px; height: 150px; 
border-radius: 50%; object-fit: cover; border: 3px solid #d1fae5; 
box-shadow: 0 4px 6px rgba(0,0,0,0.1);">`;
                } else {
                    alert('Error al subir la foto');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al subir la foto');
                location.reload();
            });
        });

        eliminarBtn?.addEventListener('click', function() {
            if (!confirm('¿Estás seguro de eliminar la foto?')) return;

            fetch('/api/eliminar-foto', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ empleado_id: empleadoId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    preview.innerHTML = `<div style="width: 150px; height: 
150px; border-radius: 50%; background: #e5e7eb; margin: 0 auto; display: 
flex; align-items: center; justify-content: center; color: #6b7280; 
border: 3px dashed #9ca3af;">Sin foto</div>`;
                } else {
                    alert('Error al eliminar la foto');
                }
            });
        });
    });
    </script>
</div>
