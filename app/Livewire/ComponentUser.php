<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentUser extends Component
{
    use WithPagination;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $user;
    public $name;
    public $email;

    public $user_id;

    public $deleteModal;

    public function mount()
    {
        $this->user = auth()->user();;
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->search = "";
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $users = $Query->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-user', compact('users'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:200',
            'email' => 'required|min:3|max:200',
        ]);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt('123456789');
        $user->save();

        $user->assignRole('admin');

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->user_id = $id;

        $this->activity = 'edit';

        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update()
    {
        $user = User::find($this->user_id);

        $this->validate([
            'name' => 'required|min:3|max:200',
            'email' => 'required|min:3|max:200',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        $this->clear();

        toast()
            ->success('Se actualizó correctamente')
            ->push();
    }

    public function destroy($id)
    {
        $this->clear();

        $this->user_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $user = User::find($this->user_id);
        $user->delete();

        $this->deleteModal = false;
    }

    public function clear()
    {
        $this->reset(['name', 'email', 'user_id']);
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
