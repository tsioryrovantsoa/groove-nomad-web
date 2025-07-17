<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncUsersToAirtable extends Command
{
    protected $signature = 'users:sync-to-airtable';
    protected $description = 'Synchronise tous les utilisateurs vers Airtable';

    public function handle()
    {
        $apiKey = config('services.airtable.api_key');
        $baseId = config('services.airtable.base_id');
        $url = "https://api.airtable.com/v0/{$baseId}/Users";

        $users = User::whereNull('airtable_record_id')->get();
        
        $this->info("Synchronisation de {$users->count()} utilisateurs...");
        
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();
        
        foreach ($users as $user) {
            try {
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

                $response = Http::withToken($apiKey)
                    ->post($url, ['fields' => $fields]);

                if ($response->successful()) {
                    $result = $response->json();
                    $user->airtable_record_id = $result['id'];
                    $user->saveQuietly();
                }
            } catch (\Exception $e) {
                $this->error("\nErreur pour l'utilisateur {$user->email}: " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Synchronisation terminée !');
    }
} 