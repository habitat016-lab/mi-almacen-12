<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 1.2em;
        }
        li:last-child {
            border-bottom: none;
        }
        .vacio {
            text-align: center;
            color: #999;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👥 Lista de Empleados</h1>
        
        @if($empleados->isEmpty())
            <div class="vacio">No hay empleados registrados</div>
        @else
            <ul>
                @foreach($empleados as $empleado)
                    <li>
                        {{ trim($empleado->nombres . ' ' . 
$empleado->apellido_paterno . ' ' . $empleado->apellido_materno) }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
