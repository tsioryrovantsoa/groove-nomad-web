<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    protected string $apiKey;
    protected string $baseId;
    protected string $tableName = 'Users';

    public function __construct()
    {
        $this->apiKey = config('services.airtable.api_key');
        $this->baseId = config('services.airtable.base_id');
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->syncToAirtable($user, 'create');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->syncToAirtable($user, 'update');
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->syncToAirtable($user, 'delete');
    }

    /**
     * Synchronise avec Airtable
     */
    protected function syncToAirtable(User $user, string $operation): void
    {
        try {
            $url = "https://api.airtable.com/v0/{$this->baseId}/{$this->tableName}";
            
            $fields = [
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'address' => $user->address,
                'city' => $user->city,
                'passport_country' => $user->passport_country,
                'nationality' => $user->nationality,
                'phone_number' => $user->phone_number,
                'gender' => $user->gender,
                'marital_status' => $user->marital_status,
                'email' => $user->email,
                'birth_date' => $user->birth_date ? $user->birth_date->format('Y-m-d') : null,
                'terms_accepted' => $user->terms_accepted,
            ];

            switch ($operation) {
                case 'create':
                    $response = Http::withToken($this->apiKey)
                        ->post($url, ['fields' => $fields]);
                    
                    if ($response->successful()) {
                        $result = $response->json();
                        $user->airtable_record_id = $result['id'];
                        $user->saveQuietly();
                        Log::info("Utilisateur créé dans Airtable", ['user_id' => $user->id, 'airtable_id' => $result['id']]);
                    }
                    break;

                case 'update':
                    if ($user->airtable_record_id) {
                        $response = Http::withToken($this->apiKey)
                            ->patch("{$url}/{$user->airtable_record_id}", ['fields' => $fields]);
                        
                        if ($response->successful()) {
                            Log::info("Utilisateur mis à jour dans Airtable", ['user_id' => $user->id, 'airtable_id' => $user->airtable_record_id]);
                        }
                    }
                    break;

                case 'delete':
                    if ($user->airtable_record_id) {
                        $response = Http::withToken($this->apiKey)
                            ->delete("{$url}/{$user->airtable_record_id}");
                        
                        if ($response->successful()) {
                            Log::info("Utilisateur supprimé dans Airtable", ['user_id' => $user->id, 'airtable_id' => $user->airtable_record_id]);
                        }
                    }
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Erreur synchronisation Airtable", [
                'user_id' => $user->id,
                'operation' => $operation,
                'error' => $e->getMessage()
            ]);
        }
    }
} 