<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCompany extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $user;
    public $name;
    public $description;
    public $nit;
    public $logo;
    public $logoBefore;

    public $company_id;

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
        $Query = Company::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        $companies = $Query->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-company', compact('companies'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:200',
            'description' => 'required|min:3|max:200',
            'nit' => 'required|min:10|max:12',
            'logo' => 'required|image|max:2048',
        ]);

        $company = new Company();
        $company->user_id = $this->user->id;
        $company->name = $this->name;
        $company->description = $this->description;
        $company->nit = $this->nit;
        $company->logo = $this->logo->store('public');
        $company->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->company_id = $id;

        $this->activity = 'edit';

        $company = Company::find($id);
        $this->name = $company->name;
        $this->description = $company->description;
        $this->nit = $company->nit;
        $this->logoBefore = $company->logo;
    }

    public function update()
    {
        $company = Company::find($this->company_id);

        if ($this->logo != null) {
            Storage::delete($company->logo);

            $this->validate([
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
                'nit' => 'required|min:10|max:12',
                'logo' => 'required|image|max:2048',
            ]);

            $company->name = $this->name;
            $company->description = $this->description;
            $company->nit = $this->nit;
            $company->logo = $this->logo->store('public');
            $company->save();
        } else {
            $this->validate([
                'name' => 'required|min:3|max:200',
                'description' => 'required|min:3|max:200',
                'nit' => 'required|min:10|max:12',
            ]);

            $company->name = $this->name;
            $company->description = $this->description;
            $company->nit = $this->nit;
            $company->save();
        }

        $this->clear();

        toast()
            ->success('Se actualizó correctamente')
            ->push();
    }

    public function destroy($id)
    {
        $this->clear();

        $this->company_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $company = Company::find($this->company_id);
        $company->delete();

        $this->deleteModal = false;
    }

    public function clear()
    {
        $this->reset(['name', 'description', 'nit', 'logo', 'company_id']);
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
