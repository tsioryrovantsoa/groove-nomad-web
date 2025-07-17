<?php

namespace App\Console\Commands;

use App\Models\Request;
use App\Observers\RequestObserver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestRequestAirtableSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:request-airtable-sync {--id= : ID de la demande à tester}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste la synchronisation Airtable avec une demande existante';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $requestId = $this->option('id');
        
        if ($requestId) {
            $request = Request::with('user')->find($requestId);
        } else {
            $request = Request::with('user')->first();
        }

        if (!$request) {
            $this->error('Aucune demande trouvée dans la base de données.');
            return 1;
        }

        $this->info("Test de synchronisation pour la demande ID: {$request->id}");
        $this->info("Utilisateur: {$request->user->email}");
        $this->info("Budget: {$request->budget}");
        $this->info("Région: {$request->region}");
        $this->info("Status: {$request->status}");

        // Créer une instance de l'observateur
        $observer = new RequestObserver();
        
        // Simuler l'événement created
        $this->info("\n🔄 Test de l'événement 'created'...");
        $observer->created($request);

        $this->info("\n✅ Test terminé. Vérifiez les logs pour voir les détails de la synchronisation.");
        $this->info("Logs disponibles dans: storage/logs/laravel.log");

        return 0;
    }
} 