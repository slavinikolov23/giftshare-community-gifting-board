<div>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-4"><i class="bi bi-grid-3x3-gap me-2"></i>Всички обяви</h1>
                
                <!-- Filters and Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form wire:submit.prevent class="row g-3">
                            <!-- Category Filter -->
                            <div class="col-md-3">
                                <label for="category" class="form-label">Категория</label>
                                <select wire:model.live="selectedCategory" id="category" class="form-select">
                                    <option value="">Всички категории</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- City Filter -->
                            <div class="col-md-2">
                                <label for="city" class="form-label">Град</label>
                                <input type="text" wire:model.live.debounce.300ms="selectedCity" id="city" class="form-control" placeholder="Град">
                            </div>
                            
                            <!-- Status Filter -->
                            <div class="col-md-2">
                                <label for="status" class="form-label">Статус</label>
                                <select wire:model.live="statusFilter" id="status" class="form-select">
                                    <option value="all">Всички</option>
                                    <option value="available">Налични</option>
                                    <option value="gifted">Подарени</option>
                                </select>
                            </div>
                            
                            <!-- Search -->
                            <div class="col-md-3">
                                <label for="search" class="form-label">Търсене</label>
                                <input type="text" wire:model.live.debounce.300ms="searchQuery" id="search" class="form-control" placeholder="Търси по заглавие или описание...">
                            </div>
                            
                            <!-- Sort -->
                            <div class="col-md-2">
                                <label for="sort" class="form-label">Сортиране</label>
                                <select wire:model.live="sortBy" id="sort" class="form-select">
                                    <option value="newest">Най-нови</option>
                                    <option value="popular">Най-популярни</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Items Grid -->
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
                                        <a href="{{ route('items.show', $item) }}" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-eye me-1"></i>Виж детайли
                                        </a>
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
                        <i class="bi bi-info-circle me-2"></i>Няма намерени обяви с избраните филтри.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
