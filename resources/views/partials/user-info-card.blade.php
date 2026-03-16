@php
    $userData = auth()->user()?->getDisplayData();
@endphp

@if($userData)
<div class="user-info-card" style="background: linear-gradient(135deg, 
#f5f7fa 0%, #e8f5e9 100%); border-left: 4px solid #4caf50; border-radius: 
8px; padding: 16px; margin-bottom: 20px; box-shadow: 0 2px 4px 
rgba(0,0,0,0.1);">
    <div style="display: flex; align-items: center;">
        <!-- Avatar -->
        <div style="margin-right: 16px;">
            @if($userData['foto'])
                <img src="{{ asset('storage/fotos/' . $userData['foto']) 
}}" 
                     alt="Foto" 
                     style="width: 56px; height: 56px; border-radius: 50%; 
object-fit: cover; border: 2px solid #4caf50;">
            @else
                <div style="width: 56px; height: 56px; border-radius: 50%; 
background: linear-gradient(135deg, #4caf50, #2e7d32); display: flex; 
align-items: center; justify-content: center; color: white; font-weight: 
bold; font-size: 24px; border: 2px solid #fff;">
                    {{ substr($userData['nombre'], 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Información -->
        <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; 
align-items: center;">
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 
600; color: #2e3b4e;">
                        {{ $userData['nombre'] }}
                    </h3>
                    <p style="margin: 4px 0; color: #5f6b7a; font-size: 
14px;">
                        {{ $userData['email'] }}
                    </p>
                </div>
                <div>
                    <span style="background-color: #4caf50; color: white; 
padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 
500;">
                        {{ $userData['rol'] }}
                    </span>
                </div>
            </div>

            <!-- Barra de estado (opcional) -->
            <div style="margin-top: 8px; font-size: 12px; color: #5f6b7a; 
display: flex; gap: 16px;">
                <span>🔹 ID: {{ $userData['empleado_id'] }}</span>
                <span>🔹 Última actividad: {{ 
auth()->user()->last_activity?->diffForHumans() ?? 'Ahora' }}</span>
            </div>
        </div>
    </div>
</div>
@endif
