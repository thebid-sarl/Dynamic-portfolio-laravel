<div>

<div class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i wire:click="rate({{ $i }})"
                               class="fa fa-star star-icon"
                               style="color: {{ $i <= $userRating ? 'gold' : 'gray' }}; cursor: pointer; font-size: 24px;">
                            </i>
                        @endfor
                    </div>

                    <p class="mt-2">Votre note : <strong>{{ $userRating }} / 5</strong></p>
</div>