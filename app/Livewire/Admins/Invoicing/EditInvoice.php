<?php

namespace App\Livewire\Admins\Invoicing;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ServicePlan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class EditInvoice extends Component
{
    public $customers = [];
    public $fields = [];
    public $servicePlans = [];

    public $customer_id;
    public $reference_number;
    public $invoice_date;
    public $due_date;
    public $title;
    public $notes;
    public $total = 0;
    public $invoice;
    public $generated_by;
    public $account_id;
    

    public function mount(?int $id = null)
    {
        $this->customers = Customer::all();
        $this->servicePlans = ServicePlan::all();
        $new_field = [
            ['id' => null, 'service_plan_id' => '', 'quantity' => '', 'rate' => '', 'sub_total' => '', 'from' => '', 'to' => '', 'uuid' => strval(Str::uuid())],
        ];

        $this->invoice = $id ? Invoice::findOrFail($id) : new Invoice;
        $this->customer_id = $this->invoice->customer_id;
        $this->invoice_date = $this->invoice->invoice_date;
        $this->due_date = $this->invoice->due_date;
        $this->title = $this->invoice->title;
        $this->notes = $this->invoice->notes;
        $this->total = $this->invoice->total;

        $this->fields = count($this->invoice->items) > 0
            ? $this->invoice->items->map(fn(InvoiceItem $item) => [
                'id' => $item->id,
                'service_plan_id' => $item->service_plan_id,
                'quantity' => $item->quantity,
                'rate' => $item->rate,
                'sub_total' => $item->sub_total,
                'from' => $item->from,
                'to' => $item->to,
                'uuid' => strval(Str::uuid()),
            ])->toArray() : $new_field;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'title' => 'nullable|string',
            'notes' => 'nullable|string',
            'fields' => 'required|array',
            'fields.*.service_plan_id' => 'required|integer',
            'fields.*.quantity' => 'required|integer',
            'fields.*.rate' => 'required|numeric',
            'fields.*.sub_total' => 'required|numeric',
            'fields.*.from' => 'required|date',
            'fields.*.to' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'This field is required',
            'invoice_date.required' => 'This field is required',
            'due_date.required' => 'This field is required',
            'fields.*.service_plan_id.required' => 'This field is required',
            'fields.*.quantity.required' => 'This field is required',
            'fields.*.rate.required' => 'This field is required',
            'fields.*.sub_total.required' => 'This field is required',
            'fields.*.from.required' => 'This field is required',
            'fields.*.to.required' => 'This field is required',
        ];
    }

    public function submit()
    {
        // $this->validate();
        try {
            DB::beginTransaction();

            $count = Invoice::count();
            $rno = $count + (int)$this->customer_id;
            $this->reference_number = 'INV0' . $rno;
            $this->generated_by = auth()->guard('admin')->user()->id;
            $this->invoice->customer_id = $this->customer_id;
            $this->invoice->reference_number ??= $this->reference_number;
            $this->invoice->invoice_date = $this->invoice_date;
            $this->invoice->due_date = $this->due_date ? $this->due_date : null;
            $this->invoice->title = $this->title;
            $this->invoice->total = $this->total;
            $this->invoice->account_id = $this->account_id;
            $this->invoice->notes = $this->notes;
            $this->invoice->generated_by = $this->generated_by;
            $this->invoice->save();

            $this->invoice->items()->delete();
            $this->invoice->items()->createMany($this->fields);

            DB::commit();
            return redirect()->route('admin.invoicing.invoices')->with('message.success', 'Invoice created successfully!');

        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
    }


    public function addField(): void
    {
        $this->fields[] = ['id' => null, 'package_id' => '', 'quantity' => '', 'rate' => '', 'sub_total' => '', 'from' => '', 'to' => '', 'uuid' => strval(Str::uuid())];
    }

    public function removeField(int $id): void
    {
        array_splice($this->fields, $id, 1);
    }

    public function updated($property)
    {
        if (preg_match("/^fields\.(\d+)\.[a-zA-Z]+$/", $property, $matches)) {
            $index = $matches[1];
            $this->fields[$index]['quantity'] = empty($this->fields[$index]['quantity'])
                ? 0
                : intval($this->fields[$index]['quantity']);
            $this->fields[$index]['rate'] = empty($this->fields[$index]['rate'])
                ? 0
                : intval($this->fields[$index]['rate']);
            $this->fields[$index]['sub_total'] = $this->fields[$index]['quantity'] * $this->fields[$index]['rate'];
            $this->calculate_totals();
        }
    }

    public function calculate_totals()
    {
        $sum = 0;
        foreach ($this->fields as $field) {
            $sum += (int) $field['sub_total'];
        }
        $this->total = $sum;
    }
    public function render()
    {
        return view('livewire.admins.invoicing.edit-invoice');
    }
}
