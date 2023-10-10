<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentProduct extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $user;
    public $category_id;
    public $name;
    public $description;
    public $price;
    public $photo;
    public $photoBefore;

    public $product_id;

    public $deleteModal;

    public $categories;

    public function mount()
    {
        $this->user = auth()->user();;
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->search = "";
        $this->deleteModal = false;
        $this->categories = Category::all();
    }

    public function render()
    {
        $Query = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $products = $Query->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-product', compact('products'));
    }

    public function store()
    {
        $this->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:200',
            'description' => 'required|min:3|max:200',
            'price' => 'required|decimal:0,2|min:1|max:10000',
            'photo' => 'required|image|max:2048',
        ]);

        $product = new Product();
        $product->category_id = $this->category_id;
        $product->name = $this->name;
        $product->description = $this->description;
        $product->price = $this->price;
        $product->photo = $this->photo->store('public');
        $product->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->product_id = $id;

        $this->activity = 'edit';

        $product = Product::find($id);
        $this->category_id = $product->category_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->photoBefore = $product->photo;
    }

    public function update()
    {
        $product = Product::find($this->product_id);

        if ($this->photo != null) {
            Storage::delete($product->photo);

            $this->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
                'price' => 'required|decimal:0,2|min:1|max:10000',
                'photo' => 'required|image|max:2048',
            ]);

            $product->category_id = $this->category_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->price = $this->price;
            $product->photo = $this->photo->store('public');
            $product->save();
        } else {
            $this->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
                'price' => 'required|decimal:0,2|min:1|max:10000',
            ]);

            $product->category_id = $this->category_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->price = $this->price;
            $product->save();
        }

        $this->clear();

        toast()
            ->success('Se actualizó correctamente')
            ->push();
    }

    public function destroy($id)
    {
        $this->clear();

        $this->product_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $product = Product::find($this->product_id);
        $product->delete();

        $this->deleteModal = false;
    }

    public function clear()
    {
        $this->reset(['category_id', 'name', 'description', 'price', 'photo', 'product_id']);
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
