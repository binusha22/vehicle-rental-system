<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerReg;

class CustomerTable extends Component
{
    public $search_cus;
    public $search_cus_id;
    public $search_cus_number;

    public function render()
    {
        $query = CustomerReg::query();

        if ($this->search_cus) {
            $query->where(function ($subquery) {
                $subquery->where('fname', 'like', "%{$this->search_cus}%")
                    ->orWhere('lname', 'like', "%{$this->search_cus}%");
            });
        }

        if ($this->search_cus_id) {
            $query->where(function ($subquery) {
                $subquery->where('idnumber', 'like', "%{$this->search_cus_id}%")
                    ->orWhere('passportnumber', 'like', "%{$this->search_cus_id}%");
            });
        }

        if ($this->search_cus_number) {
            $query->where('phonenumber', 'like', "%{$this->search_cus_number}%");
        }

        $cus = $query->get();

        return view('livewire.customer-table', ['cus' => $cus]);
    }
}

