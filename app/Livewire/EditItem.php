<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditItem extends Component
{
    use WithFileUploads;

    public Item $item;
    public $title = '';
    public $description = '';
    public $categoryId = '';
    public $city = '';
    public $weight = null;
    public $dimensions = '';
    public $photos = [];
    public $existingImages = [];

    protected $rules = [
        'title' => 'required|string|min:5|max:150',
        'description' => 'required|string|min:10|max:5000',
        'categoryId' => 'required|exists:categories,id',
        'city' => 'required|string|max:100',
        'weight' => 'nullable|numeric|min:0|max:9999.99',
        'dimensions' => 'nullable|string|max:100',
        'photos.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ];

    protected $messages = [
        'title.required' => 'Заглавието е задължително.',
        'title.min' => 'Заглавието трябва да е поне 5 символа.',
        'title.max' => 'Заглавието не може да надхвърля 150 символа.',
        'description.required' => 'Описанието е задължително.',
        'description.min' => 'Описанието трябва да е поне 10 символа.',
        'description.max' => 'Описанието не може да надхвърля 5000 символа.',
        'categoryId.required' => 'Категорията е задължителна.',
        'categoryId.exists' => 'Избраната категория не съществува.',
        'city.required' => 'Градът е задължителен.',
        'city.max' => 'Градът не може да надхвърля 100 символа.',
        'weight.numeric' => 'Теглото трябва да е число.',
        'weight.min' => 'Теглото не може да е отрицателно.',
        'photos.*.image' => 'Файлът трябва да е изображение.',
        'photos.*.mimes' => 'Изображението трябва да е JPG, JPEG, PNG, GIF или WEBP.',
        'photos.*.max' => 'Изображението не може да надхвърля 2MB.',
    ];

    public function mount(Item $item)
    {
        if (auth()->id() !== $item->user_id) {
            abort(403);
        }

        $this->item = $item;
        $this->title = $item->title;
        $this->description = $item->description;
        $this->categoryId = $item->category_id;
        $this->city = $item->city;
        $this->weight = $item->weight;
        $this->dimensions = $item->dimensions;
        $this->existingImages = $item->images;
    }

    public function deleteImage($imageId)
    {
        if (auth()->id() !== $this->item->user_id) {
            abort(403);
        }

        $image = Image::find($imageId);
        
        if (!$image || $image->item_id !== $this->item->id) {
            return;
        }

        // Delete physical file
        if (Storage::disk('public')->exists($image->filepath)) {
            Storage::disk('public')->delete($image->filepath);
        }

        // Delete database record
        $image->delete();

        // Refresh existing images
        $this->item->refresh();
        $this->existingImages = $this->item->images;

        session()->flash('success', 'Снимката беше изтрита успешно!');
    }

    public function update()
    {
        $this->validate();

        $this->item->update([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'city' => $this->city,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
        ]);

        // Handle new image uploads
        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                // Store file in public disk
                $path = $photo->store('images', 'public');
                
                Image::create([
                    'item_id' => $this->item->id,
                    'filepath' => $path, // This will be 'images/filename.jpg'
                ]);
            }
        }

        $this->item->refresh();
        $this->existingImages = $this->item->images;

        session()->flash('success', 'Обявата беше обновена успешно!');
        
        return redirect()->route('items.show', $this->item);
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.edit-item', [
            'categories' => $categories,
        ]);
    }
}
