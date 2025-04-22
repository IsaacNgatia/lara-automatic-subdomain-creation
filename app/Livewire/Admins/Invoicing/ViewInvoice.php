<?php

namespace App\Livewire\Admins\Invoicing;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class ViewInvoice extends Component
{

    public $invoice;
    public $difference;

    public function mount($id)
    {
        $this->invoice = Invoice::findOrFail($id);

        $dueDate = Carbon::parse($this->invoice->due_date);
        $now = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'));

        // Check if the invoice is past due
        $this->difference = $dueDate->isPast()
            ? $dueDate->diffForHumans($now)
            : null; // Show null or a custom message if not past due

    }
    public function render()
    {
        return view('livewire.admins.invoicing.view-invoice');
    }

    public function printInvoice($id)
    {
        $this->invoice = Invoice::findOrFail($id);

        $pdfContent = Pdf::loadView('printables.invoices.invoice', [
            'invoice' => $this->invoice,
        ])->output();

        return response()->streamDownload(fn() => print $pdfContent, 'Invoice' . $this->invoice->id . '.pdf');
    }
}
