<div>
    <div class="d-flex align-items-center gap-2">
        <button wire:click="voteUp" 
                class="btn {{ $userVote === 1 ? 'btn-success' : 'btn-outline-success' }} btn-sm"
                title="Харесай">
            <i class="bi bi-hand-thumbs-up{{ $userVote === 1 ? '-fill' : '' }}"></i>
        </button>
        
        <span class="badge bg-secondary fs-6 px-3 py-2">
            {{ $votesScore }}
        </span>
        
        <button wire:click="voteDown" 
                class="btn {{ $userVote === -1 ? 'btn-danger' : 'btn-outline-danger' }} btn-sm"
                title="Не харесай">
            <i class="bi bi-hand-thumbs-down{{ $userVote === -1 ? '-fill' : '' }}"></i>
        </button>
        
        <small class="text-muted ms-2">
            <i class="bi bi-people me-1"></i>{{ $item->votes->count() }} гласа
        </small>
    </div>
</div>
