<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class ItemShow extends Component
{
    public Item $item;

    public function mount(Item $item)
    {
        $this->item = $item->load(['category', 'user', 'images', 'votes', 'comments.user']);
    }

    public function markAsGifted()
    {
        if (auth()->id() !== $this->item->user_id) {
            abort(403);
        }

        $this->item->update(['status' => Item::STATUS_GIFTED]);
        $this->item->refresh();
        
        session()->flash('status', 'Обявата беше маркирана като подарена.');
    }

    public function markAsAvailable()
    {
        if (auth()->id() !== $this->item->user_id) {
            abort(403);
        }

        $this->item->update(['status' => Item::STATUS_AVAILABLE]);
        $this->item->refresh();
        
        session()->flash('status', 'Обявата беше маркирана като налична.');
    }

    public function render()
    {
        return view('livewire.item-show');
    }
}
