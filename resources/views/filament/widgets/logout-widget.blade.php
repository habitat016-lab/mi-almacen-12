<div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
    <form method="POST" action="{{ url('/logout') }}">
        @csrf
        <button type="submit" 
                class="w-full px-4 py-2 bg-red-600 text-white rounded 
hover:bg-red-700 transition">
            Cerrar Sesión
        </button>
    </form>
</div>
