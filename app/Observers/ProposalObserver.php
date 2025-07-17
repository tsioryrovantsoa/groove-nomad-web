<?php

namespace App\Observers;

use App\Models\Proposal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProposalObserver
{
    protected string $apiKey;
    protected string $baseId;
    protected string $tableName = 'Proposals';

    public function __construct()
    {
        $this->apiKey = config('services.airtable.api_key');
        $this->baseId = config('services.airtable.base_id');
    }

    /**
     * Handle the Proposal "created" event.
     */
    public function created(Proposal $proposal): void
    {
        Log::info("ProposalObserver: created event triggered", ['proposal_id' => $proposal->id]);
        $this->syncToAirtable($proposal, 'create');
    }

    /**
     * Handle the Proposal "updated" event.
     */
    public function updated(Proposal $proposal): void
    {
        $this->syncToAirtable($proposal, 'update');
    }

    /**
     * Handle the Proposal "deleted" event.
     */
    public function deleted(Proposal $proposal): void
    {
        $this->syncToAirtable($proposal, 'delete');
    }

    /**
     * Synchronise avec Airtable
     */
    protected function syncToAirtable(Proposal $proposal, string $operation): void
    {
        try {
            Log::info("ProposalObserver: Starting Airtable sync", [
                'proposal_id' => $proposal->id,
                'operation' => $operation,
                'api_key' => $this->apiKey ? 'set' : 'not_set',
                'base_id' => $this->baseId ? 'set' : 'not_set'
            ]);
            
            // Log des valeurs avant envoi
            Log::info("ProposalObserver: Fields to send", [
                'total_price' => $proposal->total_price,
                'total_price_type' => gettype($proposal->total_price),
                'status' => $proposal->status
            ]);
            
            $url = "https://api.airtable.com/v0/{$this->baseId}/{$this->tableName}";
            
            $fields = [
                'total_price' => (float) $proposal->total_price, // Forcer en float pour l'argent
                'status' => $proposal->status,
                'prompt_text' => $proposal->prompt_text,
                'response_text' => $proposal->response_text,
                'quotation_pdf' => $proposal->quotation_pdf,
                'send_email_at' => $proposal->send_email_at ? $proposal->send_email_at->format('Y-m-d H:i:s') : null,
                'email_read_at' => $proposal->email_read_at ? $proposal->email_read_at->format('Y-m-d H:i:s') : null,
                'rejection_reason' => $proposal->rejection_reason,
            ];
            
            // Ajouter les liens vers les autres tables
            if ($proposal->request && $proposal->request->airtable_id) {
                $fields['request_id'] = [$proposal->request->airtable_id];
            }
            
            // if ($proposal->festival && $proposal->festival->airtable_id) {
            //     $fields['festival_id'] = [$proposal->festival->airtable_id];
            // }

            if ($proposal->request && $proposal->request->user && $proposal->request->user && $proposal->request->user->email) {
                $fields['request_user_email'] = $proposal->request->user->email;
            }
            

            switch ($operation) {
                case 'create':
                    $response = Http::withToken($this->apiKey)
                        ->post($url, ['fields' => $fields]);
                    
                    Log::info("ProposalObserver: Airtable CREATE response", [
                        'proposal_id' => $proposal->id,
                        'status_code' => $response->status(),
                        'response_body' => $response->body(),
                        'success' => $response->successful()
                    ]);
                    
                    if ($response->successful()) {
                        $result = $response->json();
                        $proposal->airtable_id = $result['id'];
                        $proposal->saveQuietly();
                        Log::info("Proposal créée dans Airtable", ['proposal_id' => $proposal->id, 'airtable_id' => $result['id']]);
                    }
                    break;

                case 'update':
                    if ($proposal->airtable_id) {
                        $response = Http::withToken($this->apiKey)
                            ->patch("{$url}/{$proposal->airtable_id}", ['fields' => $fields]);
                        
                        Log::info("ProposalObserver: Airtable UPDATE response", [
                            'proposal_id' => $proposal->id,
                            'airtable_id' => $proposal->airtable_id,
                            'status_code' => $response->status(),
                            'response_body' => $response->body(),
                            'success' => $response->successful()
                        ]);
                        
                        if ($response->successful()) {
                            Log::info("Proposal mise à jour dans Airtable", ['proposal_id' => $proposal->id, 'airtable_id' => $proposal->airtable_id]);
                        }
                    }
                    break;

                case 'delete':
                    if ($proposal->airtable_id) {
                        $response = Http::withToken($this->apiKey)
                            ->delete("{$url}/{$proposal->airtable_id}");
                        
                        Log::info("ProposalObserver: Airtable DELETE response", [
                            'proposal_id' => $proposal->id,
                            'airtable_id' => $proposal->airtable_id,
                            'status_code' => $response->status(),
                            'response_body' => $response->body(),
                            'success' => $response->successful()
                        ]);
                        
                        if ($response->successful()) {
                            Log::info("Proposal supprimée dans Airtable", ['proposal_id' => $proposal->id, 'airtable_id' => $proposal->airtable_id]);
                        }
                    }
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Erreur synchronisation Airtable Proposal", [
                'proposal_id' => $proposal->id,
                'operation' => $operation,
                'error' => $e->getMessage()
            ]);
        }
    }
} 