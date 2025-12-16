<div>
    <!-- Comments List -->
    @if($comments->count() > 0)
        <div class="mb-4">
            @foreach($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong class="text-primary">
                                    <i class="bi bi-person-circle me-1"></i>{{ $comment->user->name }}
                                </strong>
                                <small class="text-muted ms-2">
                                    <i class="bi bi-clock me-1"></i>{{ $comment->created_at->format('d.m.Y H:i') }}
                                </small>
                            </div>
                        </div>
                        <p class="card-text mb-0" style="white-space: pre-wrap;">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>Все още няма коментари. Бъдете първият!
        </div>
    @endif
    
    <!-- Add Comment Form -->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title mb-3">Добави коментар</h6>
            <form wire:submit.prevent="addComment">
                <div class="mb-3">
                    <textarea wire:model="newComment" 
                              class="form-control @error('newComment') is-invalid @enderror" 
                              rows="3" 
                              placeholder="Напишете вашия коментар тук..."></textarea>
                    @error('newComment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Публикувай коментар
                </button>
            </form>
        </div>
    </div>
</div>
