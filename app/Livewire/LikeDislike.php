<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Like;
use Illuminate\Support\Facades\Request;

class LikeDislike extends Component
{
    public $hasLiked;
    public $userIp;
    public $likeCount;

    public function mount()
    {
        $this->userIp = '192.168.1.' . rand(1, 255); 
        $this->loadLikeStatus();
        $this->updateLikeCount();
    }

    public function loadLikeStatus()
    {
        $like = Like::where('ip_address', $this->userIp)->first();
        $this->hasLiked = $like ? $like->has_liked : false;
    }

    public function updateLikeCount()
    {
        $this->likeCount = Like::where('has_liked', true)->count();
    }

    public function toggleLike()
    {
        $like = Like::where('ip_address', $this->userIp)->first();

        if ($like) {
            $like->update(['has_liked' => !$like->has_liked]);
        } else {
            Like::create([
                'ip_address' => $this->userIp,
                'has_liked' => true
            ]);
        }
        $this->loadLikeStatus();
        $this->updateLikeCount(); 
    }

    public function render()
    {
        return view('livewire.like-dislike');
    }
}
