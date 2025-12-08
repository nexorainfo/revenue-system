<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class InvoiceFormLivewire extends Component
{
    public $particulars = [];

    public $revenueCategories = [];

    public $revenues = [];

    public $form = [
        'quantity' => 1,
        'rate' => 0,
        'remarks' => '',

    ];

    public $index = null;

    public function mount(array $formDetail = []): void
    {
        $this->revenueCategories = get_revenue_categories(all: true);
        foreach ($formDetail as $value) {
            $this->particulars[] = $value;
        }

        //        dd($this->particulars);
    }

    protected $rules = [
        'form.revenue_category_id' => ['required', 'exists:revenue_categories,id,deleted_at,NULL'],
        'form.revenue_id' => ['required', 'exists:revenues,id,deleted_at,NULL'],
        'form.quantity' => ['required', 'numeric', 'min:0'],
        'form.rate' => ['required', 'numeric', 'min:0'],
        'form.remarks' => ['nullable', 'string'],
    ];

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function addDetail(): void
    {
        $this->validate();
        if ($this->index !== null) {
            $this->particulars[$this->index] = $this->form;
            $this->index = null;
        } else {
            $this->particulars[] = $this->form;
        }

        $this->reset('form');
    }

    public function editDetail(int $index): void
    {
        $this->index = $index;
        $this->form = $this->particulars[$index];
    }

    public function removeDetail(int $index): void
    {
        unset($this->particulars[$index]);
        $this->particulars = array_values($this->particulars);
    }

    public function setRate(): void
    {
        if (! empty($this->form['revenue_id'])) {
            $this->form['rate'] = get_revenues(revenueId: $this->form['revenue_id'])->amount;
        }
    }

    public function render(): Factory|View
    {
        if (! empty($this->form['revenue_category_id'])) {
            $this->revenues = get_revenues(revenueCategories: $this->form['revenue_category_id']);

        }
        return view('livewire.invoice-form-livewire');
    }
}
