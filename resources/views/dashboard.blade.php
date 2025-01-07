<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <h1 class="text-3xl">BIENVENIDOS AL GESTOR DE TAREAS</h1>
                <h2>{{ Auth::user()->name ?? '' }} con el id {{ Auth::user()->id ?? '' }} con
                    {{ Auth::user()->tasks->count() }} tarea/s registrada/s</h2>

                @foreach ($tasks as $task)
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-2xl">Nombre de la tarea:</h2>
                        <p>{{ $task->title }}</p>
                        <h2 class="text-2xl">Contenido de la tarea:</h2>
                        <p>{{ $task->description }}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
