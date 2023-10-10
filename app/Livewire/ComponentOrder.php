<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentOrder extends Component
{
    use WithPagination;
    use WireToast;

    public $search;

    public $order_id;

    public $deleteModal;

    public function mount()
    {
        $this->search = "";
        $this->deleteModal = false;
    }

    public function render()
    {
        $Query = Order::query()
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($query){
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            });
        $orders = $Query->where('is_delivered', "!=", true)->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-order', compact('orders'));
    }

    public function finish($id)
    {
        $order = Order::find($id);
        $order->is_delivered = true;
        $order->save();

        $this->deleteModal = false;
    }

    public function destroy($id)
    {
        $this->order_id = $id;

        $this->deleteModal = true;
    }

    public function delete()
    {
        $order = Order::find($this->order_id);
        $order->delete();

        $this->deleteModal = false;
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
