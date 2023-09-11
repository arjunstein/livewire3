<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function destroy($id)
    {
        Post::destroy($id);

        session()->flash('message','Data deleted successfully!');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.index', [
            'posts' => Post::latest()->paginate(5)
        ]);
    }
}
