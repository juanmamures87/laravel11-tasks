<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    {{-- Este div es para mostrar alertas al eliminar una tarea --}}
    <div x-data="{ showAlert: false, message: '', type: '' }"
        @alert.window="
            showAlert = true;
            message = $event.detail[0].message;
            type = $event.detail[0].type;
            setTimeout(() => showAlert = false, 3000)
         ">

        <div x-show="showAlert"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'"
             class="fixed top-4 right-4 border-l-4 p-4 rounded shadow-lg">
            <span x-text="message"></span>
        </div>
    </div>
    {{-- Fin del div para mostrar alertas al eliminar una tarea --}}

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
                        <button wire:click.prevent="openUpdateModal({{ $task->id }})" type="button"
                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">
                            Editar
                        </button>
                        <button wire:click.prevent="deleteTask({{ $task->id }})" type="button"
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
                            <form wire:submit.prevent="{{ $isUpdating ? 'updateTask' : 'createTask' }}" class="my-8 w-80 max-w-screen-lg sm:w-96">
                                <div class="mb-1 flex flex-col gap-6">
                                    <div class="w-full max-w-sm min-w-[200px]">
                                        <label for="title" class="block mb-2 text-sm text-slate-600">
                                            Título
                                        </label>
                                        <input wire:model.defer="title" id="title" name="title" type="text"
                                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                            placeholder="Título de tu tarea" required />
                                    </div>
                                    <div class="w-full max-w-sm min-w-[200px]">
                                        <label for="description" class="block mb-2 text-sm text-slate-600">
                                            Email
                                        </label>
                                        <textarea wire:model.defer="description" id="description" name="description" cols="10" rows="5"
                                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                            placeholder="Descripción de la tarea" required></textarea>
                                    </div>
                                    <div class="flex justify-between space-x-4">
                                        <button type="submit"
                                            class="p-3 bg-blue-400 rounded-full text-white w-full font-semibold">
                                            {{ $isUpdating ? 'Actualizar Tarea' : 'Crear Tarea' }}
                                            </button>
                                        <button wire:click.prevent="closeCreateModal"
                                            class="p-3 bg-red-200 border rounded-full w-full font-semibold">Cancelar</button>
                                    </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div> @endif

        <!-- Modal de confirmación -->
    @if ($showConfirmationModal)
    <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center bg-gray-500 bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h3 class="text-lg font-medium text-gray-900">
                ¿Estás seguro de que deseas eliminar esta tarea?
            </h3>
            <div class="mt-4 flex justify-end space-x-4">
                <button wire:click="confirmDeleteTask" type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded text-sm px-4 py-2">
                    Sí, Eliminar
                </button>
                <button wire:click="cancelDeleteTask" type="button"
                    class="text-gray-500 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded text-sm px-4 py-2">
                    Cancelar
                </button>
            </div>
        </div>
    </div> @endif
</div>
