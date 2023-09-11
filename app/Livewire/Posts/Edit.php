<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use WithFileUploads;

    public $postId;

    public $image;

    #[Rule('required', message: 'Masukkan Judul Post')]
    public $title;

    #[Rule('required', message: 'Masukkan Isi Post')]
    #[Rule('min:3', message: 'Isi Post Minimal 3 Karakter')]
    public $content;

    public function mount($id)
    {
        //get post
        $post = Post::find($id);

        //assign
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
    }

    public function update()
    {
        $this->validate();

        $post = Post::find($this->postId);

        //check if image
        if ($this->image) {
            # code...
            //store image in storage/app/public/posts
            $this->image->storeAs('public/posts', $this->image->hashName());

            $post->update([
                'image' => $this->image->hashName(),
                'title' => $this->title,
                'content' => $this->content,
            ]);
        } else {
            //update post
            $post->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        }

        session()->flash('message','Data updated successfully!');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }
}
