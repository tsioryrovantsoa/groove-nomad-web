<?php

namespace App\Observers;

use App\Models\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RequestObserver
{
    protected string $apiKey;
    protected string $baseId;
    protected string $tableName = 'Requests';

    public function __construct()
    {
        $this->apiKey = config('services.airtable.api_key');
        $this->baseId = config('services.airtable.base_id');
    }

    /**
     * Handle the Request "created" event.
     */
    public function created(Request $request): void
    {
        Log::info("RequestObserver: created event triggered", ['request_id' => $request->id]);
        $this->syncToAirtable($request, 'create');
    }

    /**
     * Handle the Request "updated" event.
     */
    public function updated(Request $request): void
    {
        $this->syncToAirtable($request, 'update');
    }

    /**
     * Handle the Request "deleted" event.
     */
    public function deleted(Request $request): void
    {
        $this->syncToAirtable($request, 'delete');
    }

    /**
     * Synchronise avec Airtable
     */
    protected function syncToAirtable(Request $request, string $operation): void
    {
        try {
            Log::info("RequestObserver: Starting Airtable sync", [
                'request_id' => $request->id,
                'operation' => $operation,
                'api_key' => $this->apiKey ? 'set' : 'not_set',
                'base_id' => $this->baseId ? 'set' : 'not_set'
            ]);
            
            // Log des valeurs avant envoi
            Log::info("RequestObserver: Fields to send", [
                'budget' => $request->budget,
                'budget_type' => gettype($request->budget),
                'date_start' => $request->date_start,
                'date_end' => $request->date_end
            ]);
            
            $url = "https://api.airtable.com/v0/{$this->baseId}/{$this->tableName}";
            
            $fields = [
                'user_email' => $request->user->email,
                'budget' => (float) $request->budget, // Forcer en float pour l'argent
                'date_start' => $request->date_start ? $request->date_start->format('Y-m-d') : null,
                'date_end' => $request->date_end ? $request->date_end->format('Y-m-d') : null,
                'region' => $request->region,
                'people_count' => (int) $request->people_count, // Forcer le type integer
                'status' => $request->status,
            ];
            
            // Ajouter l'airtable_record_id de l'utilisateur s'il existe
            // Pour les champs "Link to another record", Airtable s'attend à un tableau d'IDs
            if ($request->user->airtable_record_id) {
                $fields['user_id'] = [$request->user->airtable_record_id];
            }
            
            // Ajouter les champs de type texte seulement si ils ne sont pas vides
            if (!empty($request->genres)) {
                $fields['genres'] = implode(', ', $request->genres);
            }
            if (!empty($request->cultural_tastes)) {
                $fields['cultural_tastes'] = implode(', ', $request->cultural_tastes);
            }
            if (!empty($request->phobias)) {
                $fields['phobias'] = implode(', ', $request->phobias);
            }
            if (!empty($request->allergies)) {
                $fields['allergies'] = implode(', ', $request->allergies);
            }

            switch ($operation) {
                case 'create':
                    $response = Http::withToken($this->apiKey)
                        ->post($url, ['fields' => $fields]);
                    
                    Log::info("RequestObserver: Airtable CREATE response", [
                        'request_id' => $request->id,
                        'status_code' => $response->status(),
                        'response_body' => $response->body(),
                        'success' => $response->successful()
                    ]);
                    
                    if ($response->successful()) {
                        $result = $response->json();
                        $request->airtable_id = $result['id'];
                        $request->saveQuietly();
                        Log::info("Demande créée dans Airtable", ['request_id' => $request->id, 'airtable_id' => $result['id']]);
                    }
                    break;

                case 'update':
                    if ($request->airtable_id) {
                        $response = Http::withToken($this->apiKey)
                            ->patch("{$url}/{$request->airtable_id}", ['fields' => $fields]);
                        
                        Log::info("RequestObserver: Airtable UPDATE response", [
                            'request_id' => $request->id,
                            'airtable_id' => $request->airtable_id,
                            'status_code' => $response->status(),
                            'response_body' => $response->body(),
                            'success' => $response->successful()
                        ]);
                        
                        if ($response->successful()) {
                            Log::info("Demande mise à jour dans Airtable", ['request_id' => $request->id, 'airtable_id' => $request->airtable_id]);
                        }
                    }
                    break;

                case 'delete':
                    if ($request->airtable_id) {
                        $response = Http::withToken($this->apiKey)
                            ->delete("{$url}/{$request->airtable_id}");
                        
                        Log::info("RequestObserver: Airtable DELETE response", [
                            'request_id' => $request->id,
                            'airtable_id' => $request->airtable_id,
                            'status_code' => $response->status(),
                            'response_body' => $response->body(),
                            'success' => $response->successful()
                        ]);
                        
                        if ($response->successful()) {
                            Log::info("Demande supprimée dans Airtable", ['request_id' => $request->id, 'airtable_id' => $request->airtable_id]);
                        }
                    }
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Erreur synchronisation Airtable Request", [
                'request_id' => $request->id,
                'operation' => $operation,
                'error' => $e->getMessage()
            ]);
        }
    }
} 