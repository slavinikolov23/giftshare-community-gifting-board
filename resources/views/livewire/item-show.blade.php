<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Back Button -->
                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-arrow-left me-1"></i>Назад към списъка
                </a>
                
                <!-- Item Header -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="card-title mb-2">{{ $item->title }}</h1>
                                <div class="mb-2">
                                    @if($item->status === 'gifted')
                                        <span class="badge bg-danger fs-6">
                                            <i class="bi bi-gift-fill me-1"></i>Подарено
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6">
                                            <i class="bi bi-check-circle me-1"></i>Налично
                                        </span>
                                    @endif
                                    <span class="badge bg-secondary fs-6">{{ $item->category->name }}</span>
                                    <span class="badge bg-info text-dark fs-6">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $item->city }}
                                    </span>
                                </div>
                            </div>
                            
                            @if(auth()->id() === $item->user_id)
                                <div>
                                    <a href="{{ route('items.edit', $item) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Редактирай
                                    </a>
                                    @if($item->status === 'available')
                                        <button wire:click="markAsGifted" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-gift me-1"></i>Маркирай като подарена
                                        </button>
                                    @else
                                        <button wire:click="markAsAvailable" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Маркирай като налична
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i>Публикувано от: <strong>{{ $item->user->name }}</strong>
                                <span class="ms-3">
                                    <i class="bi bi-calendar me-1"></i>{{ $item->created_at->format('d.m.Y H:i') }}
                                </span>
                            </small>
                        </div>
                        
                        <!-- Vote Buttons -->
                        <div class="mb-3">
                            @livewire('vote-buttons', ['item' => $item])
                        </div>
                    </div>
                </div>
                
                <!-- Images Gallery -->
                @if($item->images->count() > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="bi bi-images me-2"></i>Снимки</h5>
                            <div class="row">
                                @foreach($item->images as $index => $image)
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <img src="{{ asset('storage/' . $image->filepath) }}" 
                                             class="img-fluid rounded shadow-sm image-gallery-thumb" 
                                             alt="{{ $item->title }}"
                                             data-bs-toggle="modal"
                                             data-bs-target="#imageGalleryModal"
                                             data-image-index="{{ $index }}"
                                             style="cursor: pointer; max-height: 300px; object-fit: cover; width: 100%;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Image Gallery Modal -->
                    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title text-white" id="imageGalleryModalLabel">
                                        <i class="bi bi-images me-2"></i>Галерия снимки
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div id="imageGalleryCarousel" class="carousel slide h-100">
                                        <div class="carousel-inner h-100">
                                            @foreach($item->images as $index => $image)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                                                    <div class="d-flex align-items-center justify-content-center h-100" style="min-height: 80vh;">
                                                        <img src="{{ asset('storage/' . $image->filepath) }}" 
                                                             class="d-block img-fluid" 
                                                             alt="{{ $item->title }} - Снимка {{ $index + 1 }}"
                                                             style="max-height: 90vh; max-width: 100%; object-fit: contain;">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($item->images->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Предишна</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#imageGalleryCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Следваща</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer border-0 justify-content-center">
                                    <small class="text-white-50">
                                        Снимка <span id="currentImageNumber">1</span> от {{ $item->images->count() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const modal = document.getElementById('imageGalleryModal');
                            const carousel = document.getElementById('imageGalleryCarousel');
                            const currentImageNumber = document.getElementById('currentImageNumber');
                            let carouselInstance = null;
                            
                            // Initialize carousel only once, without auto-slide
                            if (!carouselInstance && carousel) {
                                carouselInstance = new bootstrap.Carousel(carousel, {
                                    interval: false,
                                    wrap: true
                                });
                            }
                            
                            // Handle thumbnail clicks
                            document.querySelectorAll('.image-gallery-thumb').forEach(function(thumb) {
                                thumb.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const imageIndex = parseInt(this.getAttribute('data-image-index'));
                                    
                                    // Set the active slide BEFORE opening the modal (without animation)
                                    const carouselItems = carousel.querySelectorAll('.carousel-item');
                                    carouselItems.forEach(function(item, index) {
                                        if (index === imageIndex) {
                                            item.classList.add('active');
                                        } else {
                                            item.classList.remove('active');
                                        }
                                    });
                                    
                                    // Update image number immediately
                                    updateImageNumber(imageIndex + 1);
                                });
                            });

                            // Update image number on carousel slide
                            if (carousel) {
                                carousel.addEventListener('slid.bs.carousel', function(event) {
                                    updateImageNumber(event.to + 1);
                                });
                            }

                            function updateImageNumber(number) {
                                if (currentImageNumber) {
                                    currentImageNumber.textContent = number;
                                }
                            }
                            
                            // Reset carousel to first image when modal is closed
                            if (modal) {
                                modal.addEventListener('hidden.bs.modal', function() {
                                    // Reset to first image without animation
                                    const carouselItems = carousel.querySelectorAll('.carousel-item');
                                    carouselItems.forEach(function(item, index) {
                                        if (index === 0) {
                                            item.classList.add('active');
                                        } else {
                                            item.classList.remove('active');
                                        }
                                    });
                                    updateImageNumber(1);
                                });
                            }
                        });
                    </script>
                @endif
                
                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="bi bi-info-circle me-2"></i>Описание</h5>
                        <p class="card-text" style="white-space: pre-wrap;">{{ $item->description }}</p>
                        
                        @if($item->weight || $item->dimensions)
                            <hr>
                            <div class="row">
                                @if($item->weight)
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-rulers me-1"></i>Тегло:</strong> {{ $item->weight }} кг
                                    </div>
                                @endif
                                @if($item->dimensions)
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-aspect-ratio me-1"></i>Размери:</strong> {{ $item->dimensions }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-chat-dots me-2"></i>Коментари
                        </h5>
                        @livewire('comments-section', ['item' => $item])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
