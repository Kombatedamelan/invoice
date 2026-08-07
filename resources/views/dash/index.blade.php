@extends("dash.layout.base")

@section("main")
<style>
    /* ===== STYLES SPÉCIFIQUES ===== */
    
    .content-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        animation: fadeUp 0.8s ease-out;
    }

    .welcome-text h1 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .welcome-text h1 i {
        color: #00f2fe;
        font-size: 1.8rem;
    }

    .welcome-text p {
        color: #a0aec0;
        font-size: 0.95rem;
        font-weight: 300;
    }

    .welcome-text p i {
        color: #00f2fe;
        margin-right: 6px;
    }

    .btn-create-invoice {
        background: linear-gradient(135deg, #0072ff, #00f2fe);
        border: none;
        padding: 14px 28px;
        border-radius: 14px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 25px rgba(0, 242, 254, 0.25);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
    }

    .btn-create-invoice:hover {
        box-shadow: 0 8px 35px rgba(0, 242, 254, 0.4);
        transform: translateY(-3px) scale(1.02);
    }

    .btn-create-invoice:active {
        transform: translateY(0) scale(0.98);
    }

    /* ===== STATISTIQUES ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 20px 25px;
        transition: all 0.3s;
    }

    .stat-card:hover {
        border-color: rgba(0, 242, 254, 0.15);
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card .stat-label {
        color: #a0aec0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        margin-top: 5px;
    }

    .stat-card .stat-value.blue { color: #4facfe; }
    .stat-card .stat-value.green { color: #2ed573; }
    .stat-card .stat-value.orange { color: #ffa502; }
    .stat-card .stat-value.red { color: #ff6b6b; }

    /* ===== LISTE DES FACTURES ===== */
    .invoice-list-section {
        width: 100%;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 30px;
        transition: all 0.3s;
    }

    .invoice-list-section:hover {
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-header h2 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h2 i {
        color: #00f2fe;
    }

    .card-header .badge-count {
        background: rgba(0, 242, 254, 0.1);
        color: #00f2fe;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .invoice-table th {
        color: #a0aec0;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 12px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .invoice-table td {
        padding: 14px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        color: #e2e8f0;
        vertical-align: middle;
    }

    .invoice-table tbody tr {
        transition: all 0.3s ease;
    }

    .invoice-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .invoice-table td:first-child {
        font-weight: 600;
        color: #00f2fe;
    }

    .invoice-table .invoice-number {
        font-weight: 600;
        color: #00f2fe;
    }

    .invoice-table .client-name {
        font-weight: 500;
    }

    .invoice-table .vehicle-name {
        color: #a0aec0;
    }

    .invoice-table .amount {
        font-weight: 600;
        color: #2ed573;
    }

    /* ===== BOUTONS D'ACTION ===== */
    .actions-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: #a0aec0;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-action.view:hover {
        background: rgba(0, 242, 254, 0.12);
        border-color: rgba(0, 242, 254, 0.2);
        color: #00f2fe;
        box-shadow: 0 4px 15px rgba(0, 242, 254, 0.15);
    }

    .btn-action.edit:hover {
        background: rgba(255, 165, 0, 0.12);
        border-color: rgba(255, 165, 0, 0.2);
        color: #ffa502;
        box-shadow: 0 4px 15px rgba(255, 165, 0, 0.15);
    }

    .btn-action.delete:hover {
        background: rgba(255, 107, 107, 0.12);
        border-color: rgba(255, 107, 107, 0.2);
        color: #ff6b6b;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.15);
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .status-paid {
        background: rgba(46, 213, 115, 0.12);
        color: #2ed573;
    }

    .status-pending {
        background: rgba(255, 165, 0, 0.12);
        color: #ffa502;
    }

    .status-overdue {
        background: rgba(255, 107, 107, 0.12);
        color: #ff6b6b;
    }

    /* ===== TOAST ===== */
    .toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #0a2647;
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 12px;
        transform: translateY(120px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 999;
        border-left: 4px solid #2ed573;
        font-size: 0.9rem;
    }

    .toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast.error {
        border-left-color: #ff6b6b;
    }

    .toast i {
        font-size: 1.2rem;
    }

    .toast .toast-close {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0 5px;
        transition: color 0.2s;
    }

    .toast .toast-close:hover {
        color: #fff;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: #0a0f24;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 35px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        animation: modalFade 0.3s ease;
    }

    @keyframes modalFade {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .modal-content h3 {
        font-size: 1.3rem;
        color: #e2e8f0;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-content h3 i {
        color: #ff6b6b;
    }

    .modal-content p {
        color: #a0aec0;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .modal-content .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .modal-content .btn-modal-cancel {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 10px 24px;
        border-radius: 10px;
        color: #a0aec0;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    .modal-content .btn-modal-cancel:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .modal-content .btn-modal-delete {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border: none;
        padding: 10px 28px;
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-content .btn-modal-delete:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 850px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .btn-create-invoice {
            width: 100%;
            justify-content: center;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .invoice-list-section {
            padding: 20px 15px;
        }
        .invoice-table {
            font-size: 0.8rem;
        }
        .invoice-table th,
        .invoice-table td {
            padding: 10px 8px;
        }
        .actions-group {
            gap: 4px;
        }
        .btn-action {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }
        .modal-content {
            padding: 25px 20px;
        }
    }

    @media (max-width: 480px) {
        .welcome-text h1 {
            font-size: 1.5rem;
        }
        .stat-card .stat-value {
            font-size: 1.4rem;
        }
        .invoice-table {
            font-size: 0.7rem;
        }
        .invoice-table th,
        .invoice-table td {
            padding: 8px 6px;
        }
        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }
        .card-header h2 {
            font-size: 1rem;
        }
        .modal-content {
            padding: 20px 15px;
        }
        .modal-content .modal-actions {
            flex-direction: column;
        }
        .modal-content .btn-modal-cancel,
        .modal-content .btn-modal-delete {
            width: 100%;
            justify-content: center;
        }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- ===== EN-TÊTE ===== -->
<section class="content-header">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-file-invoice"></i> Gestion des Factures
        </h1>
        <p><i class="fa-regular fa-circle-check"></i> Suivez et gérez toutes vos facturations de location de voiture.</p>
    </div>
    <a href="{{ route('factures.create') }}" class="btn-create-invoice">
        <i class="fa-solid fa-plus"></i> Créer une nouvelle facture
    </a>
</section>

<!-- ===== STATISTIQUES ===== -->
<section class="stats-grid">
    <div class="stat-card">
        <div class="stat-label"><i class="fa-regular fa-file"></i> Total factures</div>
        <div class="stat-value blue">{{ $totalFactures ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fa-regular fa-circle-check"></i> Payées</div>
        <div class="stat-value green">{{ $totalPayees ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fa-regular fa-clock"></i> En attente</div>
        <div class="stat-value orange">{{ $totalEnAttente ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"><i class="fa-solid fa-coins"></i> Chiffre d'affaires</div>
        <div class="stat-value green">{{ isset($totalCA) ? number_format($totalCA, 0, ',', ' ') : '0' }} FCFA</div>
    </div>
</section>

<!-- ===== LISTE DES FACTURES ===== -->
<section class="invoice-list-section">
    <div class="card-header">
        <h2><i class="fa-solid fa-list"></i> Liste des Factures</h2>
        <span class="badge-count">{{ isset($factures) ? $factures->count() : 0 }} factures</span>
    </div>
    <div class="table-responsive">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>N° Facture</th>
                    <th>Client</th>
                    <th>Véhicule</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures ?? [] as $facture)
                    <tr>
                        <td class="invoice-number">{{ $facture->invoice_number }}</td>
                        <td class="client-name">{{ $facture->client }}</td>
                        <td class="vehicle-name">
                            @if($facture->lines && count($facture->lines) > 0)
                                {{ $facture->lines[0]['designation'] ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="amount">{{ number_format($facture->total_amount, 0, ',', ' ') }} FCFA</td>
                        <td>
                            @php
                                $statusClass = $facture->status === 'payée' ? 'status-paid' : 
                                              ($facture->status === 'en retard' ? 'status-overdue' : 'status-pending');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($facture->status) }}</span>
                        </td>
                        <td>
                            <div class="actions-group">
                                <!-- Voir PDF -->
                                <a href="{{ route('factures.show', $facture->id) }}" class="btn-action view" title="Voir la facture">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                
                                <!-- Modifier -->
                                <a href="{{ route('factures.edit', $facture->id) }}" class="btn-action edit" title="Modifier la facture">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                
                                <!-- Supprimer -->
                                <button class="btn-action delete" onclick="confirmDelete('{{ $facture->id }}', '{{ $facture->invoice_number }}')" title="Supprimer la facture">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px 20px; color: #5a6a7e;">
                            <i class="fa-regular fa-file" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                            Aucune facture trouvée
                            <br>
                            <small style="font-size: 0.85rem;">Commencez par créer une nouvelle facture</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<!-- ===== MODAL DE CONFIRMATION SUPPRESSION ===== -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-content">
        <h3><i class="fa-solid fa-triangle-exclamation"></i> Confirmer la suppression</h3>
        <p>
            Êtes-vous sûr de vouloir supprimer la facture <strong id="deleteInvoiceNumber" style="color: #00f2fe;"></strong> ?
            <br><br>
            Cette action est <strong style="color: #ff6b6b;">irréversible</strong> et supprimera définitivement la facture de votre système.
        </p>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeDeleteModal()">Annuler</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-delete">
                    <i class="fa-solid fa-trash-can"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ===== TOAST NOTIFICATION ===== -->
<div class="toast" id="toast">
    <i class="fa-solid fa-check-circle" style="color: #2ed573;"></i>
    <span id="toastMessage">Facture supprimée avec succès</span>
    <button class="toast-close" onclick="closeToast()"><i class="fa-solid fa-times"></i></button>
</div>

<script>
    // ===== MODAL DE SUPPRESSION =====
    function confirmDelete(id, invoiceNumber) {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteInvoiceNumber = document.getElementById('deleteInvoiceNumber');
        
        deleteInvoiceNumber.textContent = invoiceNumber;
        deleteForm.action = "{{ route('factures.destroy', '') }}/" + id;
        modal.classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // ===== TOAST =====
    let toastTimeout;

    function showToast(message, isError = false) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = toast.querySelector('i');
        
        toastMessage.textContent = message;
        toast.classList.remove('error');
        
        if (isError) {
            toast.classList.add('error');
            toastIcon.className = 'fa-solid fa-circle-exclamation';
            toastIcon.style.color = '#ff6b6b';
        } else {
            toastIcon.className = 'fa-solid fa-check-circle';
            toastIcon.style.color = '#2ed573';
        }
        
        toast.classList.add('show');
        
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    function closeToast() {
        document.getElementById('toast').classList.remove('show');
        clearTimeout(toastTimeout);
    }

    // ===== AFFICHER LES MESSAGES DE SUCCÈS/ERREUR DEPUIS LA SESSION =====
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('success') }}");
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('error') }}", true);
        });
    @endif

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ $errors->first() }}", true);
        });
    @endif

    // ===== RECHERCHE / FILTRE (optionnel) =====
    // Vous pouvez ajouter des fonctionnalités de recherche ici si besoin

    console.log('📊 Tableau de bord MOUNOUO - Gestion des factures');
    console.log('📝 Nombre de factures : {{ isset($factures) ? $factures->count() : 0 }}');
</script>
@endsection