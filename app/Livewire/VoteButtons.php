<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Vote;
use Livewire\Component;

class VoteButtons extends Component
{
    public Item $item;
    public $userVote = null;
    public $votesScore = 0;

    public function mount(Item $item)
    {
        $this->item = $item;
        $this->loadVotes();
    }

    public function loadVotes()
    {
        $this->votesScore = $this->item->votes_score;
        
        if (auth()->check()) {
            $vote = Vote::where('user_id', auth()->id())
                ->where('item_id', $this->item->id)
                ->first();
            
            $this->userVote = $vote ? $vote->value : null;
        }
    }

    public function voteUp()
    {
        if (!auth()->check()) {
            return;
        }

        $vote = Vote::firstOrNew([
            'user_id' => auth()->id(),
            'item_id' => $this->item->id,
        ]);

        if ($vote->value === Vote::UPVOTE) {
            // Remove vote if already upvoted
            $vote->delete();
        } else {
            $vote->value = Vote::UPVOTE;
            $vote->save();
        }

        $this->item->refresh();
        $this->loadVotes();
    }

    public function voteDown()
    {
        if (!auth()->check()) {
            return;
        }

        $vote = Vote::firstOrNew([
            'user_id' => auth()->id(),
            'item_id' => $this->item->id,
        ]);

        if ($vote->value === Vote::DOWNVOTE) {
            // Remove vote if already downvoted
            $vote->delete();
        } else {
            $vote->value = Vote::DOWNVOTE;
            $vote->save();
        }

        $this->item->refresh();
        $this->loadVotes();
    }

    public function render()
    {
        return view('livewire.vote-buttons');
    }
}
