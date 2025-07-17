<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'request_id',
        'festival_id',
        'prompt_text',
        'response_text',
        'total_price',
        'status',
        'quotation_pdf',
        'send_email_at',
        'email_read_at',
        'rejection_reason',
        'airtable_id'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }

    public function details()
    {
        return $this->hasMany(ProposalDetail::class);
    }

    /**
     * Vérifie si la facture PDF existe
     *
     * @return bool
     */
    public function hasInvoice(): bool
    {
        return $this->quotation_pdf && file_exists(storage_path('app/public/invoices/' . $this->quotation_pdf));
    }
}
