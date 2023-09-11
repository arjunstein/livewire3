<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use WithFileUploads;

    #[Rule('required', message: 'Masukkan Gambar Post')]
    #[Rule('image', message: 'File Harus Gambar')]
    #[Rule('max:1024', message: 'Ukuran File Maksimal 1MB')]
    public $image;

    #[Rule('required', message: 'Masukkan Judul Post')]
    public $title;

    #[Rule('required', message: 'Masukkan Isi Post')]
    #[Rule('min:3', message: 'Isi Post Minimal 3 Karakter')]
    public $content;

    public function store()
    {
        $this->validate();

        $this->image->storeAs('public/posts', $this->image->hashName());

        Post::create([
            'image' => $this->image->hashName(),
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message','Data saved successfully!');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.create');
    }
}
