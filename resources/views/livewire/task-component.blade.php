<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <h1>ESTO ES EL COMPONENTE LIVEWIRE PARA LISTAR LAS TAREAS</h1>
    <button type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">NUEVO</button>
    <table class="w-full text-sm text-center rtl:text-right text-blue-100 dark:text-blue-100">
        <thead class="text-xs text-white uppercase bg-purple-600 dark:text-white">
            <tr>
                <th scope="col" class="px-6 py-3">
                    TITULO
                </th>
                <th scope="col" class="px-6 py-3">
                    DESCRIPCIÓN
                </th>
                <th scope="col" class="px-6 py-3">
                    ACCIONES
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="bg-slate-400 border-b border-blue-400">
                    <td class="px-4 py-4">
                        {{ $task->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $task->description }}
                    </td>
                    <td class="px-6 py-4">
                        <button type="button"
                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">
                            Editar
                        </button>
                        <button type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
