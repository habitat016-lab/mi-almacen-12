protected $routeMiddleware = [
    // ... middlewares existentes ...
    'auth.credenciales' => 
\App\Http\Middleware\AutenticacionCredenciales::class,
];
