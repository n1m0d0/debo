<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCategory extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $user;
    public $parent_id;
    public $name;
    public $description;
    public $photo;
    public $photoBefore;

    public $category_id;

    public $deleteModal;

    public $parents;

    public function mount()
    {
        $this->user = auth()->user();;
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->search = "";
        $this->deleteModal = false;
        $this->parents = Category::whereNull('category_id')->get();
    }

    public function render()
    {
        $Query = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $categories = $Query->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-category', compact('categories'));
    }

    public function store()
    {
        $this->validate([
            'parent_id' => 'nullable',
            'name' => 'required|min:3|max:200',
            'description' => 'required|min:3|max:200',
            'photo' => 'required|image|max:2048',
        ]);

        if($this->parent_id == "null")
        {
            $this->parent_id = null;
        }

        $category = new Category();
        $category->category_id = $this->parent_id;
        $category->name = $this->name;
        $category->description = $this->description;
        $category->photo = $this->photo->store('public');
        $category->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->category_id = $id;

        $this->activity = 'edit';

        $category = Category::find($id);
        $this->parent_id = $category->category_id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->photoBefore = $category->photo;
    }

    public function update()
    {
        $category = Category::find($this->category_id);

        
        if($this->parent_id == "null")
        {
            $this->parent_id = null;
        }

        if ($this->photo != null) {
            Storage::delete($category->photo);

            $this->validate([
                'parent_id' => 'nullable',
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
                'photo' => 'required|image|max:2048',
            ]);

            $category->category_id = $this->parent_id;
            $category->name = $this->name;
            $category->description = $this->description;
            $category->photo = $this->photo->store('public');
            $category->save();
        } else {
            $this->validate([
                'parent_id' => 'nullable',
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
            ]);

            $category->category_id = $this->parent_id;
            $category->name = $this->name;
            $category->description = $this->description;
            $category->save();
        }

        $this->clear();

        toast()
            ->success('Se actualizó correctamente')
            ->push();
    }

    public function destroy($id)
    {
        $this->clear();

        $this->category_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $category = Category::find($this->category_id);
        $category->delete();

        $this->deleteModal = false;
    }

    public function clear()
    {
        $this->reset(['parent_id', 'name', 'description', 'photo', 'category_id']);
        $this->activity = "create";
    }

    public function resetSearch()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
