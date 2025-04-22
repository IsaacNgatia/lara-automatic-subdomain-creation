<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DummyController extends Controller
{
    public function adminProfile()
    {
        return "The admin profile is coming up soon";
    }
    public function clientProfile()
    {
        return "The client profile is coming up soon";
    }

    public function storeClientTicket(Request $request)
    {
        try {
            $tn = Complaint::count() + 1;
            $ticket = Complaint::create([
                // TODO::Add Type
                // 'type' => $request->type,
                'topic'  => $request->title,
                'description'  => $request->description,
                'customer_id'  => auth()->guard('client')->user()->id,
                'case_number' => "TKT-".$tn,
            ]);
    
            return redirect()->back()->with(['success' => 'Ticket sent successfully']);
        } catch (\Throwable $th) {
            dd($th);
            // return redirect()->back()->with(['error' => 'Error sending ticket']);
            //throw $th;
        }
    }
}
