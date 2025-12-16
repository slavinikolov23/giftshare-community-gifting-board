<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil me-2"></i>Редактирай обява
                        </h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="update">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Заглавие <span class="text-danger">*</span></label>
                                <input type="text" 
                                       wire:model="title" 
                                       id="title" 
                                       class="form-control @error('title') is-invalid @enderror">
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
                                          rows="5"></textarea>
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
                                       class="form-control @error('city') is-invalid @enderror">
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
                                           class="form-control @error('weight') is-invalid @enderror">
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
                                           class="form-control @error('dimensions') is-invalid @enderror">
                                    @error('dimensions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Existing Images -->
                            @if($existingImages->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Текущи снимки</label>
                                    <div class="row">
                                        @foreach($existingImages as $image)
                                            <div class="col-md-3 mb-2 position-relative">
                                                <div class="position-relative" style="display: inline-block; width: 100%;">
                                                    <img src="{{ asset('storage/' . $image->filepath) }}" 
                                                         class="img-thumbnail" 
                                                         alt="Съществуваща снимка"
                                                         style="width: 100%; height: 150px; object-fit: cover;">
                                                    <button type="button"
                                                            wire:click="deleteImage({{ $image->id }})"
                                                            wire:confirm="Сигурни ли сте, че искате да изтриете тази снимка?"
                                                            class="position-absolute top-0 end-0 btn btn-danger btn-sm p-1"
                                                            style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                        <i class="bi bi-x-lg" style="font-size: 14px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- New Photos -->
                            <div class="mb-3">
                                <label for="photos" class="form-label">Добави нови снимки</label>
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
                                    Можете да добавите допълнителни снимки. Максимален размер: 2MB на файл.
                                </small>
                                
                                @if($photos)
                                    <div class="mt-3">
                                        <p class="mb-2">Преглед на новите снимки:</p>
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
                                <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Отказ
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Запази промените
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
