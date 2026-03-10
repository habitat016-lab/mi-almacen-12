<?php

namespace App\Services;

class PermisoService
{
    /**
     * Obtiene todos los módulos del sistema de forma dinámica
     */
    public static function getModulos(): array
    {
        $modulos = [];
        $modelosVistos = [];
        
        // 1. OBTENER TODOS LOS MODELOS
        $rutaModelos = app_path('Models');
        if (is_dir($rutaModelos)) {
            $archivos = scandir($rutaModelos);
            
            foreach ($archivos as $archivo) {
                if ($archivo === '.' || $archivo === '..') continue;
                
                $nombreModelo = pathinfo($archivo, PATHINFO_FILENAME);
                
                // Excluir modelos del sistema
                if (in_array($nombreModelo, ['User', 'Rol'])) {
                    continue;
                }
                
                $modelosVistos[] = $nombreModelo;
                
                // Verificar si tiene recurso Filament
                $tieneRecurso = file_exists(app_path("Filament/Resources/{$nombreModelo}Resource.php"));
                
                $modulos[] = [
                    'modelo' => $nombreModelo,
                    'label' => self::getLabelAmigable($nombreModelo),
                    'tipo' => $tieneRecurso ? 'modelo' : 'modelo_sin_recurso',
                ];
            }
        }
        
        // 2. OBTENER RECURSOS ADICIONALES
        $rutaRecursos = app_path('Filament/Resources');
        if (is_dir($rutaRecursos)) {
            $archivos = scandir($rutaRecursos);
            
            foreach ($archivos as $archivo) {
                if ($archivo === '.' || $archivo === '..') continue;
                
                if (strpos($archivo, 'Resource.php') !== false) {
                    $nombreRecurso = str_replace('Resource.php', '', $archivo);
                    
                    if (!in_array($nombreRecurso, $modelosVistos)) {
                        if (!in_array($nombreRecurso, ['Rol', 'CatPuesto'])) {
                            $modulos[] = [
                                'modelo' => $nombreRecurso,
                                'label' => self::getLabelAmigable($nombreRecurso),
                                'tipo' => 'recurso',
                            ];
                        }
                    }
                }
            }
        }
        
        // 3. FILTRAR MÓDULOS NO DESEADOS (MÉTODO EXPLÍCITO)
        $modulosFiltrados = [];
        foreach ($modulos as $modulo) {
            // Excluir Departamento específicamente
            if ($modulo['modelo'] === 'Departamento') {
                continue;
            }
            
            // También excluir si el label contiene "Ocultar"
            if (strpos($modulo['label'], 'Ocultar') !== false) {
                continue;
            }
            
            $modulosFiltrados[] = $modulo;
        }
        
        // 4. ORDENAR ALFABÉTICAMENTE
        usort($modulosFiltrados, fn($a, $b) => $a['label'] <=> $b['label']);
        
        return $modulosFiltrados;
    }
    
    /**
     * Convierte nombre de clase a texto amigable
     */
    protected static function getLabelAmigable(string $nombre): string
    {
        $nombreConEspacios = preg_replace('/(?<!^)[A-Z]/', ' $0', $nombre);
        
        $mapeos = [
            'Asignacion Credencial' => 'Asignación Credencial',
            'Cat Area' => 'Catálogo de Área',
            'Cat Departamento' => 'Catálogo de Departamento',
            'Cat Gerencia' => 'Catálogo de Gerencia',
            'Cat Motivo' => 'Catálogo de Motivo',
            'Cat Puesto' => 'Catálogo de Puesto',
            'Employee' => 'Empleados',
            'Puesto' => 'Asignación de Puestos',
            'Departamento' => 'Departamentos (Ocultar)',
        ];
        
        return $mapeos[$nombreConEspacios] ?? $nombreConEspacios;
    }
    
    public static function getDefaultPermisos(): array
    {
        $modulos = self::getModulos();
        $permisos = [];
        
        foreach ($modulos as $modulo) {
            $permisos[$modulo['modelo']] = [
                'view' => false,
                'create' => false,
                'update' => false,
                'delete' => false,
            ];
        }
        
        return $permisos;
    }
    
    public static function getAdminPermisos(): array
    {
        $modulos = self::getModulos();
        $permisos = [];
        
        foreach ($modulos as $modulo) {
            $permisos[$modulo['modelo']] = [
                'view' => true,
                'create' => true,
                'update' => true,
                'delete' => true,
            ];
        }
        
        return $permisos;
    }
    
    public static function getConsultorPermisos(): array
    {
        $modulos = self::getModulos();
        $permisos = [];
        
        foreach ($modulos as $modulo) {
            $permisos[$modulo['modelo']] = [
                'view' => true,
                'create' => false,
                'update' => false,
                'delete' => false,
            ];
        }
        
        return $permisos;
    }
}