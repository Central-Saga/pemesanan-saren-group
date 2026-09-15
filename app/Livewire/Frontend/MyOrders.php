<?php

namespace App\Livewire\Frontend;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class MyOrders extends Component
{
    #[Computed]
    public function orders(): Collection
    {
        return auth()->user()->orders()->latest()->with('items.product')->get();
    }

    public function render()
    {
        return view('livewire.frontend.my-orders');
    }
}
