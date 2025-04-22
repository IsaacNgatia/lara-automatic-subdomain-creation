<?php

namespace App\Livewire\Admins\Expenses\Modals;

use App\Livewire\Forms\Admin\Expenses\ExpenseTypeForm;
use Livewire\Component;

class CreateExpenseType extends Component
{
    public ExpenseTypeForm $expenseType;
    /**
     * Submits the expense type form and handles the save operation.
     *
     * @return void
     */
    public function submitExpenseType()
    {
        // Validate the expense type form
        $this->expenseType->validate();

        // Save the expense type
        $saveResult = $this->expenseType->save();

        // Check the save result and display appropriate flash message
        if ($saveResult) {
            session()->flash('success', 'Expense type created successfully.');
            $this->expenseType->reset();
            $this->dispatch('expense-type-created');
        } else {
            session()->flash('error', 'Failed to create expense type.');
        }
    }
    public function render()
    {
        return view('livewire.admins.expenses.modals.create-expense-type');
    }
}
