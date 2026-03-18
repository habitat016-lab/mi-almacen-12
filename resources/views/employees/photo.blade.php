<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Foto - {{ $employee->nombre_completo }}</title>
    <link 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
rel="stylesheet">
    <style>
        .photo-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #4caf50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .photo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        .btn-action {
            min-width: 150px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Gestión de Foto - {{ 
$employee->nombre_completo }}</h3>
                    </div>

                    <div class="card-body">
                        <!-- Mensajes de éxito/error -->
                        @if(session('success'))
                            <div class="alert alert-success 
alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" 
data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger 
alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" 
data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Contenedor de la foto -->
                        <div class="photo-container">
                            @if($employee->foto_url)
                                <img src="{{ $employee->foto_url }}" 
                                     alt="Foto de {{ 
$employee->nombre_completo }}"
                                     class="photo-preview mb-3"
                                     id="foto-actual">
                                <p class="text-muted">Foto actual</p>
                            @else
                                <div class="photo-preview bg-light d-flex 
align-items-center justify-content-center mb-3">
                                    <span class="display-1 text-muted">{{ 
substr($employee->nombre, 0, 1) }}</span>
                                </div>
                                <p class="text-muted">Sin foto</p>
                            @endif
                        </div>

                        <!-- Formulario para subir foto NUEVA -->
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <form action="{{ 
route('employees.photo.update', $employee) }}" 
                                      method="POST" 
                                      enctype="multipart/form-data"
                                      id="form-foto">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="foto" 
class="form-label">Seleccionar nueva foto</label>
                                        <input type="file" 
                                               class="form-control 
@error('foto') is-invalid @enderror" 
                                               id="foto" 
                                               name="foto" 
                                               
accept="image/jpeg,image/png,image/gif"
                                               required>
                                        @error('foto')
                                            <div 
class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            Formatos: JPG, PNG, GIF. 
Tamaño máximo: 2MB
                                        </small>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn 
btn-primary btn-action">
                                            <svg 
xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
fill="currentColor" class="bi bi-upload me-2" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 
1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 
1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M7.646 1.146a.5.5 
0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 
0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                            </svg>
                                            Subir Nueva Foto
                                        </button>
                                    </div>
                                </form>

                                <!-- Botón para eliminar foto (solo si 
existe) -->
                                @if($employee->foto)
                                <form action="{{ 
route('employees.photo.destroy', $employee) }}" 
                                      method="POST" 
                                      class="mt-2"
                                      id="form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-grid gap-2">
                                        <button type="submit" 
                                                class="btn btn-danger 
btn-action"
                                                onclick="return 
confirm('¿Estás seguro de eliminar esta foto? Esta acción no se puede 
deshacer.')">
                                            <svg 
xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 
1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 
0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" 
d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 
1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 
1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 
4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                            Eliminar Foto Actual
                                        </button>
                                    </div>
                                </form>
                                @endif

                                <!-- Botón para regresar -->
                                <div class="mt-4 text-center">
                                    <a href="{{ url('/admin') }}" 
class="btn btn-secondary">
                                        <svg 
xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" 
d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 
0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                        </svg>
                                        Volver al Panel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Vista previa de la foto antes de subir
        document.getElementById('foto').addEventListener('change', 
function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('foto-actual') 
|| document.querySelector('.photo-preview');
                    if (preview) {
                        if (preview.tagName === 'IMG') {
                            preview.src = e.target.result;
                        } else {
                            // Si no hay foto, crear una nueva imagen
                            const newImg = document.createElement('img');
                            newImg.src = e.target.result;
                            newImg.className = 'photo-preview mb-3';
                            newImg.id = 'foto-actual';
                            preview.parentNode.replaceChild(newImg, 
preview);
                        }
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
