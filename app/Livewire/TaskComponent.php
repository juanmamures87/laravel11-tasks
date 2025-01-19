<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskComponent extends Component
{
    public $tasks = [];
    public $title;
    public $description;
    public $modal = false;
    public $isUpdating = false; // Determina si estás en modo edición
    public $updatingTaskId = null; // ID de la tarea que se está actualizando
    public $showConfirmationModal = false; // Mostrar modal de confirmación para eliminar tarea
    public $taskToDelete = null; // ID de la tarea que se va a eliminarF

    protected $fields = [ // arreglo para los campos que deben ser limpiados
        'title' => '',
        'description' => '',
    ];

    public function mount()
    {
        $this->tasks = $this->getTaskForUser();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    public function getTaskForUser()
    {
        return Task::where('user_id', Auth::id())->get();
    }

    public function clearFields()
    {
        $this->title = $this->fields['title'];
        $this->description = $this->fields['description'];
        $this->updatingTaskId = null; // Limpiar el ID de la tarea actual
        $this->isUpdating = false;
    }

    public function openCreateModal()
    {
        $this->clearFields();
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
    }

    public function createTask()
    {

        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $newTask = new Task();
        $newTask->title = $this->title; //Datos del campo title
        $newTask->description = $this->description; //Datos del campo description
        $newTask->user_id = Auth::id();
        $newTask->save();

        $this->tasks[] = $newTask; // Agrega la nueva tarea al arreglo existente
        $this->clearFields(); //Limpiar campos
        $this->modal = false;
    }

    public function openUpdateModal($taskId)
    {
        $task = Task::find($taskId);

        if ($task && $task->user_id === Auth::id()) {
            $this->title = $task->title;
            $this->description = $task->description;
            $this->updatingTaskId = $task->id; // Guardar el ID de la tarea en edición
            $this->isUpdating = true; // Cambiar a modo edición
            $this->modal = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'No tienes permiso para editar esta tarea.',
            ]);
        }
    }

    public function updateTask()
    {
        if (!$this->updatingTaskId) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'No se pudo encontrar la tarea para actualizar.',
            ]);
            return;
        }

        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $task = Task::find($this->updatingTaskId);

        if ($task && $task->user_id === Auth::id()) {
            $task->title = $this->title;
            $task->description = $this->description;
            $task->save();

            $this->tasks = $this->getTaskForUser(); // Refrescar la lista de tareas
            $this->clearFields();
            $this->modal = false;

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Tarea actualizada correctamente.',
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'No tienes permiso para actualizar esta tarea.',
            ]);
        }
    }

    public function deleteTask($taskId)
    {
        // Verificar si el usuario es el propietario de la tarea
        $task = Task::find($taskId);

        if ($task && $task->user_id === Auth::id()) {

            // Mostrar el modal de confirmación
            $this->taskToDelete = $task;
            $this->showConfirmationModal = true;
        } else {

            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'No tienes permiso para eliminar esta tarea.',
            ]);
        }
    }

    public function confirmDeleteTask()
    {
        if ($this->taskToDelete) {
            $this->taskToDelete->delete();  // Elimina la tarea
            $this->tasks = $this->getTaskForUser();  // Refrescar la lista de tareas
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Tarea eliminada correctamente.',
            ]);
            $this->showConfirmationModal = false;  // Cerrar el modal
        }
    }

    public function cancelDeleteTask()
    {
        $this->showConfirmationModal = false;  // Cerrar el modal sin hacer nada
        $this->taskToDelete = null;  // Limpiar la tarea almacenada para eliminar
    }
}
