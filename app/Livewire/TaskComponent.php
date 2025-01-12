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

    public function getTask()
    {
        return Task::where('user_id', Auth::id())->get();
    }

    public function mount()
    {
        $this->tasks = $this->getTask();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    public function clearFields()
    {
        $this->title = '';
        $this->description = '';
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
        $newTask = new Task();
        $newTask->title = $this->title;
        $newTask->description = $this->description;
        $newTask->user_id = Auth::id();
        $newTask->save();
        $this->clearFields();
        $this->modal = false;
        $this->tasks = $this->getTask();
    }
}
