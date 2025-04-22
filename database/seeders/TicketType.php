<?php

namespace Database\Seeders;

use App\Models\TicketType as ModelsTicketType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketTypes = [
            [
                'name' => 'Technical Support',
                'description' => 'Tickets related to system errors, bugs, or technical issues.',
            ],
            [
                'name' => 'Billing and Payment',
                'description' => 'Tickets concerning invoices, refunds, and payment issues.',
            ],
            [
                'name' => 'Feature Request',
                'description' => 'Suggestions for new features or improvements.',
            ],
            [
                'name' => 'Account Management',
                'description' => 'Issues related to user accounts, such as password resets or profile updates.',
            ],
            [
                'name' => 'Service Request',
                'description' => 'Requests for upgrades, customizations, or additional services.',
            ],
            [
                'name' => 'Complaints or Feedback',
                'description' => 'Complaints about service or product quality, or general feedback.',
            ],
            [
                'name' => 'General Inquiry',
                'description' => 'Questions about products, services, or policies.',
            ],
            [
                'name' => 'Incident Report',
                'description' => 'Reports of critical issues such as security breaches or data loss.',
            ],
            [
                'name' => 'Sales or Pre-Sales',
                'description' => 'Inquiries about product pricing, discounts, or demos.',
            ],
            [
                'name' => 'Other',
                'description' => 'Tickets that do not fit predefined categories.',
            ],
        ];

        foreach($ticketTypes as $ticketType){
            ModelsTicketType::create($ticketType);
        }
    }
}
