<?php

namespace App\Traits;

use App\Models\Address\District;
use App\Models\Address\LocalBody;
use App\Models\Address\Province;

trait AddressHelperTrait
{
    public function getDependentAddressData(): void
    {
        if (!empty($this->form['province_id'])) {
            $this->districts = Province::with('districts')->findOrFail($this->form['province_id'])->districts;
        }
        if (!empty($this->form['district_id'])) {
            $this->localBodies = District::with('localBodies')->findOrFail($this->form['district_id'])->localBodies;
        }
        if (!empty($this->form['local_body_id'])) {
            $this->wards = LocalBody::findOrFail($this->form['local_body_id'])->ward_no;
        }
    }
}
