<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveType;

class Leavefiling extends Component
{
    public $leaveTypes;

    public function mount() {
        $this->leaveTypes = LeaveType::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.leavefiling');
    }
}
