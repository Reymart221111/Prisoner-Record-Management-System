<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Component;

class ViewFeedBackDetails extends Component
{
    public $feedback;

    public function mount(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function render()
    {
        return view('livewire.view-feed-back-details', ['feedback' => $this->feedback]);
    }
}
