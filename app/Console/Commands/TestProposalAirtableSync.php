<?php

namespace App\Console\Commands;

use App\Models\Proposal;
use App\Observers\ProposalObserver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestProposalAirtableSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:proposal-airtable-sync {--id= : ID de la proposal à tester}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste la synchronisation Airtable avec une proposal existante';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $proposalId = $this->option('id');
        
        if ($proposalId) {
            $proposal = Proposal::with(['request', 'festival'])->find($proposalId);
        } else {
            $proposal = Proposal::with(['request', 'festival'])->first();
        }

        if (!$proposal) {
            $this->error('Aucune proposal trouvée dans la base de données.');
            return 1;
        }

        $this->info("Test de synchronisation pour la proposal ID: {$proposal->id}");
        $this->info("Request ID: {$proposal->request_id}");
        $this->info("Festival ID: {$proposal->festival_id}");
        $this->info("Total Price: {$proposal->total_price}");
        $this->info("Status: {$proposal->status}");

        // Créer une instance de l'observateur
        $observer = new ProposalObserver();
        
        // Simuler l'événement created
        $this->info("\n🔄 Test de l'événement 'created'...");
        $observer->created($proposal);

        $this->info("\n✅ Test terminé. Vérifiez les logs pour voir les détails de la synchronisation.");
        $this->info("Logs disponibles dans: storage/logs/laravel.log");

        return 0;
    }
} 