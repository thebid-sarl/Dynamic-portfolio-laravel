<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rating;


class AverageRating extends Component
{
    public $averageRating; 
    protected $listeners = ['ratingUpdated' => 'calculateAverage'];

    public function mount()
    {
        $this->calculateAverage();
    }

    public function calculateAverage()
    {
        $this->averageRating = round(Rating::avg('rating'), 1) ?? 0;   
     }

    public function render()
    {
        return view('livewire.average-rating');
    }
}
