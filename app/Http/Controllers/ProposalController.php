<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateProposalJob;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class ProposalController extends Controller
{
    public function acceptAndRedirectToStripe(Request $request, Proposal $proposal)
    {
        // Vérification que la proposition est bien en état 'generated'
        abort_unless($proposal->status === 'generated', 403);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Paiement proposition #' . $proposal->id,
                    ],
                    'unit_amount' => intval($proposal->total_price * 100), // en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('proposals.payment.success', $proposal),
            'cancel_url' => route('request.index'),
            'metadata' => [
                'proposal_id' => $proposal->id,
            ],
        ]);

        return redirect($session->url);
    }
    public function handleStripeSuccess(Proposal $proposal)
    {
        // if ($proposal->status !== 'generated') {
        //     return redirect()->route('proposals.show', $proposal)->with('info', 'Déjà traité.');
        // }

        $proposal->update([
            'status' => 'accepted',
        ]);

        // Générer la facture seulement si elle n'existe pas déjà
        if (!$proposal->hasInvoice()) {
            $filename = $this->generateInvoice($proposal);
            $proposal->update(['quotation_pdf' => $filename]);
        }

        // ... Tu peux aussi envoyer un email ici.

        return redirect()->route('request.index')->with('success', 'Proposition acceptée et payée ! Facture générée.');
    }

    /**
     * Génère une facture PDF pour une proposition acceptée
     *
     * @param Proposal $proposal
     * @return string
     */
    private function generateInvoice(Proposal $proposal): string
    {
        $request = $proposal->request;
        $festival = $proposal->festival;
        $proposalDetails = $proposal->details;
        $user = $request->user;

        // Calculer les totaux
        $subtotal = $proposalDetails->sum('price');
        $total = $proposal->total_price;

        // Générer le PDF
        $pdf = Pdf::loadView('pdf.invoice', [
            'proposal' => $proposal,
            'request' => $request,
            'festival' => $festival,
            'proposalDetails' => $proposalDetails,
            'user' => $user,
            'subtotal' => $subtotal,
            'total' => $total,
            'invoiceNumber' => 'INV-' . str_pad($proposal->id, 6, '0', STR_PAD_LEFT),
            'invoiceDate' => now()->format('d/m/Y'),
        ]);

        // Sauvegarder le PDF
        $filename = 'facture_proposition_' . $proposal->id . '.pdf';
        $path = storage_path('app/public/invoices/' . $filename);
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        $pdf->save($path);

        return $filename;
    }

    /**
     * Télécharge la facture PDF d'une proposition
     *
     * @param Proposal $proposal
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice(Proposal $proposal)
    {
        // Vérifier que l'utilisateur est autorisé à voir cette proposition
        if ($proposal->request->user_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier que la proposition est acceptée
        if ($proposal->status !== 'accepted') {
            abort(404, 'Facture non disponible pour cette proposition.');
        }

        // Si la facture n'existe pas encore, la générer
        if (!$proposal->hasInvoice()) {
            $filename = $this->generateInvoice($proposal);
            $proposal->update(['quotation_pdf' => $filename]);
        }

        // Retourner le fichier PDF
        $filePath = storage_path('app/public/invoices/' . $proposal->quotation_pdf);
        return response()->download($filePath, 'facture_proposition_' . $proposal->id . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function reject(Request $request, Proposal $proposal)
    {
        // Vérification que la proposition est bien en état 'generated'
        abort_unless($proposal->status === 'generated', 403);

        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:1000'
        ]);

        $proposal->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        GenerateProposalJob::dispatch($proposal->request);

        return redirect()->route('request.index')->with('success', 'Proposition refusée ! Nouvelle proposition en cours de génération...');
    }
}
