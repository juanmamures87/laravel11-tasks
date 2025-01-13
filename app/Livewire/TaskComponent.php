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

    public function deleteTask($taskId)
    {
        // Verificar si el usuario es el propietario de la tarea
        $task = Task::find($taskId);

        if ($task && $task->user_id === Auth::id()) {
            $task->delete();  // Elimina la tarea
            $this->tasks = $this->getTaskForUser();  // Refrescar la lista de tareas
            session()->flash('success', 'Tarea eliminada correctamente.');
        } else {
            session()->flash('error', 'No tienes permiso para eliminar esta tarea.');
        }
    }
}
