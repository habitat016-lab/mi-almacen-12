@php
    use App\Models\Puesto;
    use App\Models\CatPuesto;
    
    $user = auth()->user();
    $nombreCompleto = $user->name ?? 'Usuario';
    $puestoNombre = 'Sin puesto asignado';
    
    if ($user && $user->empleado) {
        $ultimoPuesto = Puesto::where('employee_id', $user->empleado->id)
            ->latest()
            ->first();
        
        if ($ultimoPuesto && $ultimoPuesto->cat_puesto_id) {
            $catPuesto = CatPuesto::find($ultimoPuesto->cat_puesto_id);
            $puestoNombre = $catPuesto->nombre_puesto ?? 'Sin puesto 
asignado';
        }
    }
@endphp

<div style="background-color: #d1fae5; padding: 8px 16px; border-radius: 
12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-block; 
margin-right: 15px;">
    <div style="font-size:11px; color:#047857; font-weight:600; 
letter-spacing:0.5px;">BIENVENIDO:</div>
    <div style="font-weight:700; color:#111827; font-size:15px;">{{ 
$nombreCompleto }}</div>
    <div style="font-size:12px; color:#047857; font-weight:500; 
margin-top:1px;">{{ $puestoNombre }}</div>
</div>
