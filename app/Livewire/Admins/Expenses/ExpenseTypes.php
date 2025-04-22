<?php

namespace App\Livewire\Admins\Expenses;

use App\Livewire\Forms\Admin\Expenses\ExpenseTypeForm;
use App\Models\ExpenseType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ExpenseTypes extends Component
{
    use WithPagination;
    public $id;
    public $addExpenseType;
    public $editingId;
    public $deletingId;
    public function mount()
    {
        $this->id = 1;
        $this->addExpenseType = false;
    }
    /**
     * This function triggers the modal to open.
     *
     * This function is responsible for dispatching an event to open the modal.
     * It is called when the user wants to add a new expense type or edit an existing one.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    private function showModal()
    {
        $this->dispatch('open-modal');
    }
    /**
     * This function handles the event when a new expense type is created.
     *
     * This function is triggered when the 'expense-type-created' event is dispatched.
     * It resets the component's state by calling the 'resetItems' method.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    #[On('expense-type-created')]
    public function doneSavingExpenseType()
    {
        $this->resetItems();
    }
    /**
     * Resets the component's state after a modal event.
     *
     * This function is triggered when the 'close-event' event is dispatched.
     * It closes the modal, resets the 'deletingId', 'editingId', and 'addExpenseType' properties,
     * and prepares the component for a new operation.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    #[On('close-event')]
    public function resetItems()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        $this->editingId = null;
        $this->addExpenseType = null;
    }

    /**
     * This function triggers the process of adding a new expense type.
     *
     * It sets the 'addExpenseType' property to true and calls the 'showModal' method
     * to open the modal for adding a new expense type.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    public function addingExpenseType()
    {
        $this->showModal();
        $this->addExpenseType = true;
    }

    /**
     * This function triggers the process of editing an existing expense type.
     *
     * It sets the 'editingId' property to the provided ID and calls the 'showModal' method
     * to open the modal for editing the expense type.
     *
     * @param int $id The ID of the expense type to be edited.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    public function editExpenseType($id)
    {
        $this->editingId = $id;
        $this->showModal();
    }
    /**
     * Deletes an expense type based on the provided ID.
     *
     * This function is triggered when the 'delete-expense-type' event is dispatched.
     * It retrieves the expense type using the ID stored in the 'deletingId' property,
     * deletes the expense type from the database, resets the component's state,
     * and re-renders the component.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    #[On('delete-expense-type')]
    public function deleteExpenseType()
    {
        $expenseType = ExpenseType::find($this->deletingId);
        $expenseType->delete();
        $this->resetItems();
        $this->render();
    }

    /**
     * Warns the user about the expense type to be deleted and opens the modal.
     *
     * This function sets the 'deletingId' property to the provided ID and calls the 'showModal' method
     * to open the modal for deleting the expense type. This function is typically called when the user
     * initiates the deletion process for a specific expense type.
     *
     * @param int $id The ID of the expense type to be deleted.
     *
     * @return void
     *
     * @throws NoExceptionThrown This function does not throw any exceptions.
     */
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->showModal();
    }
    public function render()
    {
        $expenseTypes = ExpenseType::paginate(10);
        return view('livewire.admins.expenses.expense-types', [
            'expenseTypes' => $expenseTypes
        ]);
    }
}
