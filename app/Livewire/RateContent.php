<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rating;
use Livewire\Component\AverageRating;
use Livewire\Attributes\On;

class RateContent extends Component
{
    public $averageRating; 
    public $userRating; 
    public $userIp;

    public function mount()
    {
        $this->userIp = '192.168.1.' . rand(1, 255); 
        $this->calculateAverageRating();     
         $userRating = Rating::where('user_ip', $this->userIp)->first();
         if ($userRating) {
             $this->rating = $userRating->rating;
         }

    }
 

    public function rate($rating)
    {    
        $existingRating = Rating::where('user_ip', $this->userIp)->first();
        if ($existingRating) {
            if ($existingRating->rating == $rating) {
                $newRating = $existingRating->rating - 1;
                if ($newRating < 0) {
                    $newRating = 0; 
                }
                $existingRating->update(['rating' => $newRating]);
                $this->userRating = $newRating; 
            } else {
                $existingRating->update(['rating' => $rating]);
                $this->userRating = $rating;
            }
        } else {
            Rating::create([
                'user_ip' => $this->userIp,
                'rating' => $rating
            ]);
            $this->userRating = $rating;
        }
        $this->calculateAverageRating();
        $this->dispatch('ratingUpdated');
    
    }
    public function calculateAverageRating()
    {
        $this->averageRating = round(Rating::avg('rating'), 1); 
    }
    public function render()
    {
        return view('livewire.rate-content');
    }

}
