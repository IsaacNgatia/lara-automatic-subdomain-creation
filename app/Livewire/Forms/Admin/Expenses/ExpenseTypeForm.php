<?php

namespace App\Livewire\Forms\Admin\Expenses;

use App\Models\ExpenseType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ExpenseTypeForm extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $description;

    public function save()
    {
        try {
            ExpenseType::create([
                'name' => $this->name,
                'description' => $this->description,
                'added_by' => auth()->id(),
            ]);
            return true;
        } catch (\Exception $e) {
            $this->addError('status', 'Failed to create expense type.');
            return $e->getMessage();
        }
    }
}
