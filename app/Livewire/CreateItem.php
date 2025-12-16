<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateItem extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $categoryId = '';
    public $city = '';
    public $weight = null;
    public $dimensions = '';
    public $photos = [];

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

    public function save()
    {
        $this->validate();

        $item = Item::create([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'city' => $this->city,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'status' => Item::STATUS_AVAILABLE,
            'user_id' => auth()->id(),
        ]);

        // Handle image uploads
        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                // Store file in public disk
                $path = $photo->store('images', 'public');
                
                Image::create([
                    'item_id' => $item->id,
                    'filepath' => $path, // This will be 'images/filename.jpg'
                ]);
            }
        }

        session()->flash('success', 'Обявата беше публикувана успешно!');
        
        return redirect()->route('items.show', $item);
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.create-item', [
            'categories' => $categories,
        ]);
    }
}
