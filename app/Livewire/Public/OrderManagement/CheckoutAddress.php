<?php

namespace App\Livewire\Public\OrderManagement;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CheckoutAddress extends Component
{
    #[Layout('layouts.app')]

    public $addresses;
    public $selectedId;
    public $showForm = false;
    public $showTable = true;
    public $editing = null;
    public $isGuest = true;

    // Form fields
    public $first_name = '';
    public $last_name = '';
    public $address_line_1 = '';
    public $address_line_2 = '';
    public $city = '';
    public $state = '';
    public $postal_code = '';
    public $country = 'US';
    public $phone = '';
    public $is_default = false;

    protected $rules = [
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'city'           => 'required|string|max:255',
        'state'          => 'nullable|string|max:255',
        'postal_code'    => 'required|string|max:15',
        'country'        => 'required|string|size:2',
        'phone'          => 'nullable|string|max:25',
        'is_default'     => 'boolean',
    ];

    protected $messages = [
        'first_name.required'     => 'First name is required.',
        'last_name.required'      => 'Last name is required.',
        'address_line_1.required' => 'Address line 1 is required.',
        'city.required'           => 'City is required.',
        'postal_code.required'    => 'Postal code is required.',
        'country.required'        => 'Country is required.',
    ];

    public function mount()
    {
        $this->checkAuthStatus();

        if (!$this->isGuest) {
            $this->loadAddresses();
        }
    }

    private function checkAuthStatus()
    {
        $this->isGuest = !Auth::check();

        if (!$this->isGuest) {
            $this->showTable = true;
        } else {
            $this->showTable = false;
            $this->showForm = false;
        }
    }

    private function loadAddresses()
    {
        if ($this->isGuest) return;

        $this->addresses = Auth::user()->addresses;
        $defaultAddress = Auth::user()->defaultAddress;
        $this->selectedId = $defaultAddress?->id;
    }

    public function select($id)
    {
        if ($this->isGuest) return;

        $this->selectedId = $id;
        $this->dispatch('address-selected', addressId: $id);
    }

    public function add()
    {
        if ($this->isGuest) {
            session()->flash('error', 'Please login first to add an address.');
            return redirect()->route('login');
        }

        $this->resetForm();
        $this->showForm = true;
        $this->showTable = false;
        $this->editing = null;
    }

    public function edit(Address $address)
    {
        if ($this->isGuest) {
            session()->flash('error', 'Please login first to edit addresses.');
            return redirect()->route('login');
        }

        if ($address->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $this->fill([
            'first_name'     => $address->first_name,
            'last_name'      => $address->last_name,
            'address_line_1' => $address->address_line_1,
            'address_line_2' => $address->address_line_2,
            'city'           => $address->city,
            'state'          => $address->state,
            'postal_code'    => $address->postal_code,
            'country'        => $address->country,
            'phone'          => $address->phone,
            'is_default'     => $address->is_default,
        ]);

        $this->showForm = true;
        $this->showTable = false;
        $this->editing = $address;
    }

    public function delete($addressId)
    {
        if ($this->isGuest) {
            session()->flash('error', 'Please login first.');
            return redirect()->route('login');
        }

        $address = Address::where('id', $addressId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            session()->flash('error', 'Address not found or unauthorized.');
            return;
        }

        $address->delete();

        $this->loadAddresses();
        session()->flash('success', 'Address deleted successfully.');
    }

    public function setDefault($addressId)
    {
        if ($this->isGuest) return;

        $address = Address::where('id', $addressId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            session()->flash('error', 'Address not found or unauthorized.');
            return;
        }

        Auth::user()->addresses()->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        $this->loadAddresses();
        $this->selectedId = $addressId;

        session()->flash('success', 'Default address updated.');
    }

    public function save()
    {
        if (! Gate::allows('place-order', auth()->user())) {
            abort(403, 'Admins cannot place orders.');
        }
        if ($this->isGuest) {
            session()->flash('error', 'Please login first to save addresses.');
            return redirect()->route('login');
        }

        $this->validate();

        $data = [
            'user_id'        => Auth::id(),
            'first_name'     => $this->first_name,
            'last_name'      => $this->last_name,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city'           => $this->city,
            'state'          => $this->state,
            'postal_code'    => $this->postal_code,
            'country'        => $this->country,
            'phone'          => $this->phone,
            'is_default'     => $this->is_default,
        ];

        try {
            if ($this->editing) {
                if ($this->editing->user_id !== Auth::id()) {
                    session()->flash('error', 'Unauthorized action.');
                    return;
                }

                $this->editing->update($data);
                $address = $this->editing;
                session()->flash('success', 'Address updated successfully.');
            } else {
                if (Auth::user()->addresses()->count() === 0) {
                    $data['is_default'] = true;
                }

                $address = Address::create($data);
                session()->flash('success', 'Address added successfully.');
            }

            if ($this->is_default) {
                Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            }

            $this->resetForm();
            $this->showForm = false;
            $this->showTable = true;
            $this->loadAddresses();
            $this->select($address->id);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving the address. Please try again.');
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
        $this->showTable = true;
        $this->editing = null;
    }

    private function resetForm()
    {
        $this->reset([
            'first_name',
            'last_name',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code',
            'phone',
            'is_default'
        ]);
        $this->country = 'US';
        $this->editing = null;
    }

    public function render()
    {
        return view('livewire.public.order-management.checkout-address');
    }
}
