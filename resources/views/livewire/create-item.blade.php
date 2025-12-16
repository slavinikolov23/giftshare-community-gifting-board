<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Създай нова обява
                        </h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Заглавие <span class="text-danger">*</span></label>
                                <input type="text" 
                                       wire:model="title" 
                                       id="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Например: Стара холна маса">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание <span class="text-danger">*</span></label>
                                <textarea wire:model="description" 
                                          id="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="5" 
                                          placeholder="Опишете подробно вещта, която подарявате..."></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="categoryId" class="form-label">Категория <span class="text-danger">*</span></label>
                                <select wire:model="categoryId" 
                                        id="categoryId" 
                                        class="form-select @error('categoryId') is-invalid @enderror">
                                    <option value="">Изберете категория</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div class="mb-3">
                                <label for="city" class="form-label">Град <span class="text-danger">*</span></label>
                                <input type="text" 
                                       wire:model="city" 
                                       id="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       placeholder="Например: София">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <!-- Weight -->
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Тегло (кг)</label>
                                    <input type="number" 
                                           wire:model="weight" 
                                           id="weight" 
                                           step="0.01" 
                                           min="0" 
                                           class="form-control @error('weight') is-invalid @enderror" 
                                           placeholder="Например: 5.5">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Dimensions -->
                                <div class="col-md-6 mb-3">
                                    <label for="dimensions" class="form-label">Размери</label>
                                    <input type="text" 
                                           wire:model="dimensions" 
                                           id="dimensions" 
                                           class="form-control @error('dimensions') is-invalid @enderror" 
                                           placeholder="Например: 120x80x50 см">
                                    @error('dimensions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Photos -->
                            <div class="mb-3">
                                <label for="photos" class="form-label">Снимки</label>
                                <input type="file" 
                                       wire:model="photos" 
                                       id="photos" 
                                       class="form-control @error('photos.*') is-invalid @enderror" 
                                       multiple 
                                       accept="image/*">
                                @error('photos.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Можете да качите няколко снимки. Максимален размер: 2MB на файл.
                                </small>
                                
                                @if($photos)
                                    <div class="mt-3">
                                        <p class="mb-2">Преглед на качените снимки:</p>
                                        <div class="row">
                                            @foreach($photos as $index => $photo)
                                                <div class="col-md-3 mb-2">
                                                    <img src="{{ $photo->temporaryUrl() }}" 
                                                         class="img-thumbnail" 
                                                         alt="Преглед {{ $index + 1 }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('items.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Отказ
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Публикувай обява
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
