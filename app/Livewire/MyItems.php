<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class MyItems extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function markAsGifted($itemId)
    {
        $item = Item::findOrFail($itemId);
        
        if (auth()->id() !== $item->user_id) {
            abort(403);
        }

        $item->update(['status' => Item::STATUS_GIFTED]);
        
        session()->flash('status', 'Обявата беше маркирана като подарена.');
    }

    public function markAsAvailable($itemId)
    {
        $item = Item::findOrFail($itemId);
        
        if (auth()->id() !== $item->user_id) {
            abort(403);
        }

        $item->update(['status' => Item::STATUS_AVAILABLE]);
        
        session()->flash('status', 'Обявата беше маркирана като налична.');
    }

    public function render()
    {
        $items = Item::where('user_id', auth()->id())
            ->with(['category', 'images', 'votes', 'comments'])
            ->withCount(['votes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.my-items', [
            'items' => $items,
        ]);
    }
}
