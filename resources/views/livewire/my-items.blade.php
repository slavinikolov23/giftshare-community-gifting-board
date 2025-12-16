<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="bi bi-person-lines-fill me-2"></i>Моите обяви
                </h1>
                
                @if($items->count() > 0)
                    <div class="row">
                        @foreach($items as $item)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    @if($item->images->count() > 0)
                                        <a href="{{ route('items.show', $item) }}">
                                            <img src="{{ asset('storage/' . $item->images->first()->filepath) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $item->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                        </a>
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2">
                                            @if($item->status === 'gifted')
                                                <span class="badge bg-danger mb-2">
                                                    <i class="bi bi-gift-fill me-1"></i>Подарено
                                                </span>
                                            @else
                                                <span class="badge bg-success mb-2">
                                                    <i class="bi bi-check-circle me-1"></i>Налично
                                                </span>
                                            @endif
                                            <span class="badge bg-secondary">{{ $item->category->name }}</span>
                                        </div>
                                        
                                        <h5 class="card-title">
                                            <a href="{{ route('items.show', $item) }}" class="text-decoration-none text-dark">
                                                {{ Str::limit($item->title, 50) }}
                                            </a>
                                        </h5>
                                        
                                        <p class="card-text flex-grow-1">{{ Str::limit($item->description, 100) }}</p>
                                        
                                        <div class="mt-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $item->city }}
                                            </small>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-hand-thumbs-up me-1"></i>{{ $item->votes_score }}
                                                    <i class="bi bi-chat-dots ms-3 me-1"></i>{{ $item->comments_count }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-white">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('items.show', $item) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Виж детайли
                                            </a>
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Редактирай
                                            </a>
                                            @if($item->status === 'available')
                                                <button wire:click="markAsGifted({{ $item->id }})" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Сигурни ли сте, че искате да маркирате обявата като подарена?')">
                                                    <i class="bi bi-gift me-1"></i>Маркирай като подарена
                                                </button>
                                            @else
                                                <button wire:click="markAsAvailable({{ $item->id }})" 
                                                        class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Маркирай като налична
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>Все още нямате публикувани обяви.
                        <a href="{{ route('items.create') }}" class="alert-link">Създайте първата обява</a>!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
