<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

final class Address extends Component
{
    public ?int $province_id = null;
    public ?int $district_id = null;
    public ?int $local_body_id = null;
    public ?int $ward_no = null;

    public $provinces = [];
    public $districts = [];
    public $localBodies = [];
    public $wardCount = 0; // Changed from string to int

    public function mount(?array $address = null): void
    {
        $this->provinces = get_provinces();

        if ($address) {
            $this->province_id = $address['province_id'] ?? null;
            $this->district_id = $address['district_id'] ?? null;
            $this->local_body_id = $address['local_body_id'] ?? null;
            $this->ward_no = $address['ward_no'] ?? null;
            if (!empty($this->province_id)){
                $this->districts = get_districts($this->province_id);
            }
            if (!empty($this->district_id)){
                $this->localBodies = get_local_bodies($this->district_id);
            }
            if (!empty($this->local_body_id)){
                $this->wardCount = get_local_bodies(localBodyId: $this->local_body_id)->first()?->wards;
            }
        }
    }

    // Listen to province change
    public function updatedProvinceId(int $value): void
    {
        $this->district_id = null;
        $this->local_body_id = null;
        $this->ward_no = null;
        $this->wardCount = 0;

        if ($value) {
            $this->districts = get_districts($value);
        } else {
            $this->districts = [];
        }
        $this->localBodies = [];
    }

    // Listen to district change
    public function updatedDistrictId(int $value): void
    {
        $this->local_body_id = null;
        $this->ward_no = null;
        $this->wardCount = 0;

        if ($value) {
            $this->localBodies = get_local_bodies($value);
        } else {
            $this->localBodies = [];
        }
    }

    // Listen to local body change
    public function updatedLocalBodyId(int $value): void
    {
        $this->ward_no = null;
        $this->wardCount = 0;

        if ($value) {
            $localBody = get_local_bodies(localBodyId: $value)->first(); // or find()
            $this->wardCount = $localBody?->wards ?? 0;
        }
    }

    public function render(): View
    {
        return view('livewire.address');
    }
}
