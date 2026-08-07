<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FactureController extends Controller
{
    /**
     * Afficher la liste des factures.
     */
    public function index()
    {
        $factures = Facture::orderBy('created_at', 'desc')->get();
        
        // Statistiques
        $totalFactures = Facture::count();
        $totalPayees = Facture::paid()->count();
        $totalEnAttente = Facture::pending()->count();
        $totalCA = Facture::paid()->sum('total_amount');
        
        $nextInvoiceNumber = Facture::generateInvoiceNumber();
        return view('dash.factures.index', compact(
            'factures',
            'totalFactures',
            'totalPayees',
            'totalEnAttente',
            'totalCA',
            'nextInvoiceNumber'
        ));
    }

    /**
     * Afficher le formulaire de création.
     */
   public function create()
    {
        $nextInvoiceNumber = Facture::generateInvoiceNumber();

        // dd($nextInvoiceNumber);

        return view('dash.new-facture', compact('nextInvoiceNumber'));
    }

    /**
     * Enregistrer une nouvelle facture.
     */
    public function store(Request $request)
    {
        // Log des données reçues pour déboguer
        Log::info('Données reçues pour la facture :', $request->all());

        // Validation des données
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'client' => 'required|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'object' => 'required|string',
            'lines' => 'required|array|min:1',
            'lines.*.designation' => 'required|string|max:255',
            'lines.*.quantity' => 'required|string',
            'lines.*.days' => 'required|numeric|min:0',
            'lines.*.unit_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:payée,en attente,en retard',
        ], [
            'lines.required' => 'Ajoutez au moins une ligne de facture.',
            'lines.*.designation.required' => 'La désignation est requise pour chaque ligne.',
            'lines.*.quantity.required' => 'La quantité est requise pour chaque ligne.',
            'lines.*.days.required' => 'Le nombre de jours est requis pour chaque ligne.',
            'lines.*.unit_price.required' => 'Le prix unitaire est requis pour chaque ligne.',
        ]);

        if ($validator->fails()) {
            Log::error('Erreurs de validation :', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Récupérer les lignes validées
            $lines = $request->lines;

            // Calculer le montant total à partir des lignes
            $totalAmount = Facture::calculateTotalFromLines($lines);

            // Générer le montant en lettres (convertir en int)
            $amountInWords = Facture::numberToWords((int) $totalAmount) . ' FRANCS CFA';

            // Préparer les données pour la création
            $data = [
                'date' => $request->date,
                'invoice_number' => Facture::generateInvoiceNumber(),
                'client' => $request->client,
                'order_number' => $request->order_number,
                'object' => $request->object,
                'lines' => $lines, // Le cast 'array' va gérer la conversion automatiquement
                'total_amount' => $totalAmount,
                'amount_in_words' => $amountInWords,
                'status' => $request->status ?? 'en attente',
            ];

            Log::info('Données préparées pour la création :', $data);

            // Créer la facture
            $facture = Facture::create($data);

            DB::commit();

            Log::info('Facture créée avec succès :', ['id' => $facture->id, 'invoice_number' => $facture->invoice_number]);

            return redirect()
                ->route('factures.index')
                ->with('success', 'Facture ' . $facture->invoice_number . ' générée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la création de la facture :', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la création de la facture : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher une facture spécifique.
     */
    public function show($id)
    {
        $facture = Facture::findOrFail($id);
        
        // Informations statiques de l'agence
        $agence = [
            'nom' => 'MOUNOUO',
            'lieu' => 'Lomé, Togo',
            'banque' => 'ORABANK',
            'code_banque' => 'TG 116',
            'code_agence' => '01101',
            'swift' => 'ORBKTGTG',
            'compte' => 'MOUNOUO',
            'responsable' => 'Le responsable de l\'agence MOUNOUO',
        ];
        
        return view('dash.factures.show', compact('facture', 'agence'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit($id)
    {
        $facture = Facture::findOrFail($id);
        
        return view('dash.factures.edit', compact('facture'));
    }

    /**
     * Mettre à jour une facture.
     */
    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail($id);

        Log::info('Mise à jour de la facture :', ['id' => $id, 'data' => $request->all()]);

        // Validation des données
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'invoice_number' => 'required|string|unique:factures,invoice_number,' . $id,
            'client' => 'required|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'object' => 'required|string',
            'lines' => 'required|array|min:1',
            'lines.*.designation' => 'required|string|max:255',
            'lines.*.quantity' => 'required|string',
            'lines.*.days' => 'required|numeric|min:0',
            'lines.*.unit_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:payée,en attente,en retard',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Récupérer les lignes validées
            $lines = $request->lines;

            // Calculer le montant total à partir des lignes
            $totalAmount = Facture::calculateTotalFromLines($lines);

            // Générer le montant en lettres (convertir en int)
            $amountInWords = Facture::numberToWords((int) $totalAmount) . ' FRANCS CFA';

            // Mettre à jour la facture
            $facture->update([
                'date' => $request->date,
                'invoice_number' => $request->invoice_number,
                'client' => $request->client,
                'order_number' => $request->order_number,
                'object' => $request->object,
                'lines' => $lines,
                'total_amount' => $totalAmount,
                'amount_in_words' => $amountInWords,
                'status' => $request->status ?? $facture->status,
            ]);

            DB::commit();

            return redirect()
                ->route('factures.index')
                ->with('success', 'Facture ' . $facture->invoice_number . ' modifiée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la modification de la facture :', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la modification de la facture.')
                ->withInput();
        }
    }

    /**
     * Supprimer une facture.
     */
    public function destroy($id)
    {
        try {
            $facture = Facture::findOrFail($id);
            $invoiceNumber = $facture->invoice_number;
            
            $facture->delete();

            return redirect()
                ->route('factures.index')
                ->with('success', 'Facture ' . $invoiceNumber . ' supprimée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la facture :', [
                'message' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression de la facture.');
        }
    }

    /**
     * Mettre à jour le statut d'une facture.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:payée,en attente,en retard',
        ]);

        try {
            $facture = Facture::findOrFail($id);
            $facture->update([
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'status' => $request->status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue.',
            ], 500);
        }
    }

    /**
     * Exporter une facture en PDF
     */
   public function exportPDF($id)
    {
        $facture = Facture::findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dash.factures.pdf', compact('facture'));

        $pdf->setPaper('a4', 'portrait');

        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'Times New Roman',
            'isPhpEnabled' => true,
            'chroot' => public_path(),
        ]);

        return $pdf->download('facture_' . $facture->invoice_number . '.pdf');
    }

    /**
     * Récupérer les statistiques pour le tableau de bord.
     */
    public function getStats()
    {
        return response()->json([
            'total' => Facture::count(),
            'paid' => Facture::paid()->count(),
            'pending' => Facture::pending()->count(),
            'overdue' => Facture::overdue()->count(),
            'total_amount' => Facture::paid()->sum('total_amount'),
        ]);
    }

    /**
     * Récupérer les factures pour DataTable.
     */
    public function getDataTable()
    {
        $factures = Facture::orderBy('created_at', 'desc')->get();
        
        return response()->json($factures->map(function ($facture) {
            return [
                'id' => $facture->id,
                'invoice_number' => $facture->invoice_number,
                'date' => $facture->formatted_date,
                'client' => $facture->client,
                'object' => $facture->short_object ?? substr($facture->object, 0, 50),
                'total_amount' => $facture->total_amount,
                'formatted_total' => $facture->formatted_total,
                'status' => $facture->status,
                'status_label' => ucfirst($facture->status),
                'status_badge' => $this->getStatusBadge($facture->status),
                'created_at' => $facture->created_at->format('d/m/Y H:i'),
            ];
        }));
    }

    /**
     * Obtenir le badge HTML pour le statut.
     */
    private function getStatusBadge($status)
    {
        $classes = [
            'payée' => 'status-paid',
            'en attente' => 'status-pending',
            'en retard' => 'status-overdue',
        ];
        
        $class = $classes[$status] ?? 'status-pending';
        
        return '<span class="status-badge ' . $class . '">' . ucfirst($status) . '</span>';
    }
}