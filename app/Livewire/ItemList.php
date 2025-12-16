<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class ItemList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedCategory = '';
    public $selectedCity = '';
    public $searchQuery = '';
    public $statusFilter = 'all'; // 'all', 'available', 'gifted'
    public $sortBy = 'newest'; // 'newest', 'popular'

    protected $queryString = [
        'selectedCategory' => ['except' => ''],
        'selectedCity' => ['except' => ''],
        'searchQuery' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'newest'],
    ];

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedCity()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Item::with(['category', 'user', 'images', 'votes', 'comments'])
            ->withCount(['votes', 'comments']);

        // Apply filters
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedCity) {
            $query->where('city', 'like', '%' . $this->selectedCity . '%');
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply search
        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
            });
        }

        // Apply sorting
        if ($this->sortBy === 'popular') {
            $query->withSum('votes', 'value')
                ->orderBy('votes_sum_value', 'desc')
                ->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $items = $query->paginate(9);
        $categories = Category::orderBy('name')->get();

        return view('livewire.item-list', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}
