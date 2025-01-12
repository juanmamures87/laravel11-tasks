<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <h1>ESTO ES EL COMPONENTE LIVEWIRE PARA LISTAR LAS TAREAS</h1>
    <button wire:click="openCreateModal" data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">NUEVO
    </button>
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

    @if ($modal)
        <!-- Modal para crear usuario -->
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
            <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
                <div class="w-full">
                    <div class="m-8 my-20 max-w-[400px] mx-auto">
                        <div class="mb-8">
                            <h1 class="mb-4 text-3xl font-extrabold">Crear nueva tarea</h1>
                            <form class="my-8 w-80 max-w-screen-lg sm:w-96">
                                <div class="mb-1 flex flex-col gap-6">
                                    <div class="w-full max-w-sm min-w-[200px]">
                                        <label for="title" class="block mb-2 text-sm text-slate-600">
                                            Título
                                        </label>
                                        <input wire:model="title" id="title" name="title" type="text"
                                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                            placeholder="Título de tu tarea" required />
                                    </div>
                                    <div class="w-full max-w-sm min-w-[200px]">
                                        <label for="description" class="block mb-2 text-sm text-slate-600">
                                            Email
                                        </label>
                                        <textarea wire:model="description" id="description" name="description" cols="10" rows="5"
                                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                            placeholder="Descripción de la tarea" required></textarea>
                                    </div>
                            </form>
                        </div>
                        <div wire:click.prevent="createTask" class="flex justify-between space-x-4">
                            <button class="p-3 bg-blue-400 rounded-full text-white w-full font-semibold">Crear
                                tarea</button>
                            <button wire:click.prevent="closeCreateModal"
                                class="p-3 bg-red-200 border rounded-full w-full font-semibold">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
