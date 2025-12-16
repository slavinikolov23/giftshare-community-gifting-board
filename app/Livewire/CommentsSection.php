<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Item;
use Livewire\Component;

class CommentsSection extends Component
{
    public Item $item;
    public $newComment = '';

    public function mount(Item $item)
    {
        $this->item = $item;
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|min:3|max:1000',
        ], [
            'newComment.required' => 'Коментарът не може да бъде празен.',
            'newComment.min' => 'Коментарът трябва да е поне 3 символа.',
            'newComment.max' => 'Коментарът не може да надхвърля 1000 символа.',
        ]);

        Comment::create([
            'content' => $this->newComment,
            'user_id' => auth()->id(),
            'item_id' => $this->item->id,
        ]);

        $this->newComment = '';
        $this->item->refresh();
        
        session()->flash('comment_added', 'Коментарът беше добавен успешно!');
    }

    public function render()
    {
        $comments = $this->item->comments()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.comments-section', [
            'comments' => $comments,
        ]);
    }
}
