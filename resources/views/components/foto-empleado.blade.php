@props(['empleado' => null])
@php
    if (!$empleado && method_exists($this, 'getRecord')) {
        $empleado = $this->getRecord();
    }
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border 
border-gray-200 dark:border-gray-700 p-6 mb-4">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Columna izquierda: Visualización -->
        <div class="flex-shrink-0 md:w-48 text-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white 
mb-3">
                Foto del Empleado
            </h3>
            
            @if($empleado && $empleado->foto_url)
                <img src="{{ $empleado->foto_url }}" 
                     alt="Foto de {{ $empleado->nombre_completo }}"
                     class="w-32 h-32 mx-auto rounded-full object-cover 
border-4 border-primary-500 shadow-lg"
                     id="foto-empleado-preview">
            @else
                <div class="w-32 h-32 mx-auto rounded-full 
bg-gradient-to-br from-primary-400 to-primary-600 flex items-center 
justify-center border-4 border-primary-300 shadow-lg">
                    <span class="text-4xl font-bold text-white">
                        {{ $empleado ? substr($empleado->nombres, 0, 1) : 
'?' }}
                    </span>
                </div>
            @endif

            @if($empleado && $empleado->foto)
                <p class="text-xs text-gray-500 mt-2">
                    {{ $empleado->foto }}
                </p>
            @endif
        </div>

        <!-- Columna derecha: Acciones y formulario -->
        <div class="flex-1">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 
text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 
text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 
text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario para subir foto -->
            <form action="{{ route('employees.photo.update', 
$empleado->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="mb-4">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 
dark:text-gray-300 mb-2">
                        Seleccionar nueva foto
                    </label>
                    <input type="file" 
                           name="foto" 
                           accept="image/jpeg,image/png,image/gif"
                           class="block w-full text-sm text-gray-500 
file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm 
file:font-semibold file:bg-primary-50 file:text-primary-700 
hover:file:bg-primary-100"
                           required>
                    <p class="mt-1 text-xs text-gray-500">
                        Formatos: JPG, PNG, GIF. Máx 2MB
                    </p>
                </div>

                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 
bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium 
rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" 
stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" 
stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 
003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Subir Foto
                </button>
            </form>

            <!-- Botón eliminar -->
            @if($empleado && $empleado->foto)
            <form action="{{ route('employees.photo.destroy', 
$empleado->id) }}" 
                  method="POST" 
                  class="mb-4"
                  onsubmit="return confirm('¿Eliminar foto 
permanentemente?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 
bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg 
transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" 
stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" 
stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 
0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 
00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Eliminar Foto
                </button>
            </form>
            @endif

            <!-- Notas -->
            <div class="text-xs text-gray-500 bg-gray-50 
dark:bg-gray-900/50 p-3 rounded-lg">
                <p>💡 Los cambios se guardan inmediatamente al subir o 
eliminar la foto.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.querySelector('input[name="foto"]');
    const preview = document.getElementById('foto-empleado-preview');
    
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Crear preview si no existe
                        const container = 
document.querySelector('.flex-shrink-0');
                        if (container) {
                            const newImg = document.createElement('img');
                            newImg.src = e.target.result;
                            newImg.className = 'w-32 h-32 mx-auto 
rounded-full object-cover border-4 border-primary-500 shadow-lg';
                            newImg.id = 'foto-empleado-preview';
                            
                            const oldDiv = 
container.querySelector('div.w-32');
                            if (oldDiv) {
                                oldDiv.replaceWith(newImg);
                            } else {
                                container.insertBefore(newImg, 
container.children[1]);
                            }
                        }
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});
</script>
