<div style="display: flex; align-items: center; gap: 8px;">
<i wire:click="toggleLike"
   class="fa fa-thumbs-up like-icon"
   style="color: {{ $hasLiked ? 'blue' : 'gray' }}; 
          font-size: 30px; 
          cursor: pointer; 
          transition: color 0.3s ease, transform 0.3s ease;
          transform: scale({{ $hasLiked ? 1.2 : 1 }})">
</i>
    <span style="font-size: 18px;">{{ $likeCount }}</span>
</div>

