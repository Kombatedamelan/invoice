@extends("dash.layout.base")

@section("main")
<style>
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

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px 24px;
        border-radius: 12px;
        color: #a0aec0;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transform: translateX(-3px);
    }

    /* ===== FACTURE ===== */
    .invoice-wrapper {
        background: #ffffff;
        border-radius: 8px;
        padding: 50px 60px;
        max-width: 1100px;
        margin: 0 auto;
        color: #000000;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Times New Roman', Times, serif;
    }

    /* ===== EN-TÊTE AVEC LOGO ===== */
    .invoice-header {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .invoice-header .logo img {
        max-width: 200px;
        height: auto;
        display: block;
    }

    /* ===== INFOS LÉGALES (retrait gauche) ===== */
    .legal-info {
        margin-left: 120px;
        margin-top: -50px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
    }

    /* ===== DATE - ENTRE MILIEU ET DROITE ===== */
    .date-right {
        text-align: left;
        font-size: 0.9rem;
        margin-bottom: 20px;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
        padding-right: 30px;
        max-width: 55%;
        margin-left: 700px;
    }

    /* ===== CLIENT - À PARTIR DU MILIEU ===== */
    .client-line {
        text-align: left;
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
        word-wrap: break-word;
        max-width: 55%;
        margin-left: auto;
        padding-right: 30px;
    }

    .client-line .label {
        font-weight: 600;
    }

    /* ===== OBJET ===== */
    .object-line {
        font-size: 0.9rem;
        margin-bottom: 20px;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
    }

    .object-line .label {
        font-weight: 600;
    }

    /* ===== FACTURE N° CENTRÉ SOULIGNÉ ===== */
    .invoice-number-center {
        text-align: center;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: #000000;
        letter-spacing: 1px;
        font-family: 'Times New Roman', Times, serif;
        text-decoration: underline;
    }

    /* ===== TABLEAU ===== */
    .invoice-table-wrap {
        overflow-x: auto;
        margin: 20px 0;
    }

    .invoice-table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        border: 1px solid #000000;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
    }

    .invoice-table-custom thead th {
        background: transparent;
        color: #000000;
        padding: 10px 12px;
        text-align: left;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid #000000;
        font-family: 'Times New Roman', Times, serif;
    }

    .invoice-table-custom thead th:last-child {
        text-align: right;
    }

    .invoice-table-custom thead th:nth-child(3),
    .invoice-table-custom thead th:nth-child(4) {
        text-align: center;
    }

    .invoice-table-custom tbody td {
        padding: 10px 12px;
        border: 1px solid #000000;
        color: #000000;
        font-size: 0.85rem;
        font-family: 'Times New Roman', Times, serif;
    }

    .invoice-table-custom tbody td:last-child {
        text-align: right;
        font-weight: 600;
    }

    .invoice-table-custom tbody td:nth-child(3),
    .invoice-table-custom tbody td:nth-child(4) {
        text-align: center;
    }

    .invoice-table-custom .total-row td {
        font-weight: 700;
        border: 1px solid #000000;
        padding: 10px 12px;
        font-family: 'Times New Roman', Times, serif;
    }

    .invoice-table-custom .total-row td:last-child {
        font-size: 1rem;
        text-align: right;
    }

    .invoice-table-custom .total-row td:first-child {
        text-align: right;
    }

    /* ===== TOTAL EN LETTRES ===== */
    .amount-in-words {
        font-size: 0.9rem;
        margin: 20px 0 25px;
        color: #000000;
        line-height: 1.6;
        font-family: 'Times New Roman', Times, serif;
    }

    .amount-in-words strong {
        font-weight: 700;
    }

    /* ===== INFOS BANCAIRES ===== */
    .bank-info {
        font-size: 0.85rem;
        margin: 15px 0 25px;
        color: #000000;
        line-height: 1.8;
        font-family: 'Times New Roman', Times, serif;
    }

    .bank-info .bank-line {
        display: flex;
        gap: 10px;
    }

    .bank-info .bank-line .label {
        font-weight: 600;
        min-width: 160px;
    }

    .bank-info .bank-line .value {
        font-weight: 400;
    }

    /* ===== SIGNATURE - ENTRE MILIEU ET DROITE ===== */
    .signature-section {
        margin-top: 40px;
        margin-bottom: 30px;
        text-align: left;
        font-family: 'Times New Roman', Times, serif;
        padding-right: 30px;
        max-width: 55%;
        margin-left: 600px;
    }

    .signature-section .signature-title {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 30px;
        color: #000000;
    }

    .signature-section .signature-space {
        height: 60px;
        margin-bottom: 5px;
    }

    .signature-section .signature-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #000000;
    }

    /* ===== PIED DE PAGE SANS TITRES ===== */
    .footer-info {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
        padding-top: 15px;
        border-top: none;
        font-size: 0.75rem;
        color: #000000;
        font-family: 'Times New Roman', Times, serif;
    }

    .footer-info .item {
        display: flex;
        flex-direction: column;
    }

    .footer-info .item .value {
        font-weight: 400;
        word-break: break-word;
    }

    /* ===== BOUTONS D'ACTION ===== */
    .invoice-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .btn-pdf {
        background: #1a5494;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    .btn-pdf:hover {
        background: #0f3d6e;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #e67e22;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    .btn-edit:hover {
        background: #c96d1a;
        transform: translateY(-2px);
    }

    .btn-delete-action {
        background: #c0392b;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .btn-delete-action:hover {
        background: #a93226;
        transform: translateY(-2px);
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
        color: #fff;
        font-family: 'Poppins', sans-serif;
    }

    @keyframes modalFade {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
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
    @media (max-width: 850px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .invoice-wrapper {
            padding: 30px 25px;
        }
        .legal-info {
            margin-left: 20px;
        }
        .date-right {
            max-width: 100%;
            padding-right: 0;
            text-align: right;
        }
        .client-line {
            max-width: 100%;
            padding-right: 0;
            text-align: left;
        }
        .signature-section {
            max-width: 100%;
            padding-right: 0;
            text-align: right;
        }
        .footer-info {
            grid-template-columns: 1fr 1fr;
        }
        .invoice-actions {
            flex-direction: column;
        }
        .invoice-actions .btn-pdf,
        .invoice-actions .btn-edit,
        .invoice-actions .btn-delete-action {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .invoice-wrapper {
            padding: 20px 15px;
        }
        .legal-info {
            margin-left: 10px;
            font-size: 0.75rem;
        }
        .footer-info {
            grid-template-columns: 1fr;
        }
        .invoice-table-custom {
            font-size: 0.7rem;
        }
        .invoice-table-custom thead th,
        .invoice-table-custom tbody td {
            padding: 6px 8px;
        }
        .invoice-header .logo img {
            max-width: 120px;
        }
        .bank-info .bank-line {
            flex-wrap: wrap;
        }
        .bank-info .bank-line .label {
            min-width: 120px;
        }
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- ===== EN-TÊTE ===== -->
<section class="content-header">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-eye"></i> Détails de la facture
        </h1>
        <p><i class="fa-regular fa-circle-check"></i> Consultez les détails complets de la facture.</p>
    </div>
    <a href="{{ route('factures.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</section>

<!-- ===== FACTURE ===== -->
<div class="invoice-wrapper">

    <!-- ===== LOGO EN HAUT À GAUCHE ===== -->
    <div class="invoice-header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="MOUNOUO Logo">
        </div>
    </div>

    <!-- ===== INFOS LÉGALES (retrait gauche) ===== -->
    <div class="legal-info">
        RCCM: TG-LFW-01-2024-A10-06-156 / NIF 1001972055,<br>
        Adéticopé-Lomé préfecture d'AGOE NYIVE,<br>
        représentée par Madame SAMBIANI FARDJA DAMBOA,
    </div>

    <!-- ===== DATE - ENTRE MILIEU ET DROITE ===== -->
    <div class="date-right">
        Lomé, le {{ $facture->date->format('d') }} 
        {{ ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'][$facture->date->format('n')-1] }} 
        {{ $facture->date->format('Y') }}
    </div>

    <!-- ===== CLIENT - À PARTIR DU MILIEU ===== -->
    <div class="client-line">
        <span class="label">Client :</span> {{ $facture->client }}<br>
        {{ $facture->client_address ?? 'Avenue de Tervuren 36, 1040 Bruxelles, Belgique' }}<br>
        {{ $facture->client_tva ?? 'VAT n°BE 0452.263.785' }}
    </div>

    <!-- ===== OBJET ===== -->
    <div class="object-line">
        <span class="label">Objet :</span> {{ $facture->object }}
    </div>

    <!-- ===== FACTURE N° CENTRÉ SOULIGNÉ ===== -->
    <div class="invoice-number-center">
        Facture N° {{ $facture->invoice_number }}
    </div>

    <!-- ===== TABLEAU ===== -->
    <div class="invoice-table-wrap">
        <table class="invoice-table-custom">
            <thead>
                <tr>
                    <th style="width: 18%; text-align: center;">N° Bon de commande</th>
                    <th style="width: 32%; text-align: left;">Désignation</th>
                    <th style="width: 12%; text-align: center;">Nbre</th>
                    <th style="width: 13%; text-align: center;">Durée (jours)</th>
                    <th style="width: 12%; text-align: right;">PPU (FCFA)</th>
                    <th style="width: 13%; text-align: right;">Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                    $orderNumber = $facture->order_number ?? 'N° 0027-COMMUNICATION /DUE/ATI-AESA';
                @endphp
                @foreach($facture->lines as $index => $line)
                    @php
                        $qty = $line['quantity'] ?? 0;
                        $days = $line['days'] ?? 0;
                        $pu = $line['unit_price'] ?? 0;
                        $total = $qty * $days * $pu;
                        $grandTotal += $total;
                    @endphp
                    <tr>
                        @if($index === 0)
                            <td style="text-align: center;" rowspan="{{ count($facture->lines) }}">{{ $orderNumber }}</td>
                        @endif
                        <td>{{ $line['designation'] ?? '-' }}</td>
                        <td style="text-align: center;">{{ $qty }}</td>
                        <td style="text-align: center;">{{ $days }}</td>
                        <td style="text-align: right;">{{ number_format($pu, 0, ',', ' ') }}</td>
                        <td style="text-align: right;">{{ number_format($total, 0, ',', ' ') }}</td>
                    </tr>
                @endforeach
                <!-- Ligne totale avec fusion -->
                <tr class="total-row">
                    <td colspan="5" style="text-align: right; font-weight: 700; font-size: 0.9rem;">TOTAL</td>
                    <td style="text-align: right; font-weight: 700; font-size: 1rem;">
                        {{ number_format($grandTotal, 0, ',', ' ') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ===== MONTANT EN LETTRES AVEC CHIFFRES ===== -->
    <div class="amount-in-words">
        <strong>Arrêter la présente facture à la somme de :</strong> 
        {{ $facture->amount_in_words ?? 'Cinq cent soixante mille' }} ({{ number_format($grandTotal, 0, ',', ' ') }}) francs CFA
    </div>

    <!-- ===== INFOS BANCAIRES ===== -->
    <div class="bank-info">
        <div class="bank-line">
            <span class="label">Banque :</span>
            <span class="value">ORABANK</span>
        </div>
        <div class="bank-line">
            <span class="label">Intitulé du Compte :</span>
            <span class="value">MOUNOUO</span>
        </div>
        <div class="bank-line">
            <span class="label">Code Banque :</span>
            <span class="value">TG 116</span>
        </div>
        <div class="bank-line">
            <span class="label">Code Agence :</span>
            <span class="value">01101</span>
        </div>
        <div class="bank-line">
            <span class="label">Code Swift :</span>
            <span class="value">ORBKTGTG</span>
        </div>
        <div class="bank-line">
            <span class="label">Numéro de Compte :</span>
            <span class="value">084539200201</span>
        </div>
        <div class="bank-line">
            <span class="label">Clé RIB :</span>
            <span class="value">34</span>
        </div>
        <div class="bank-line">
            <span class="label">Code IBAN :</span>
            <span class="value">TG53TG1160110108453920020134</span>
        </div>
    </div>

    <!-- ===== SIGNATURE - ENTRE MILIEU ET DROITE ===== -->
    <div class="signature-section">
        <div class="signature-title">Le responsable</div>
        <div class="signature-space">&nbsp;</div>
        <div class="signature-name">SAMBIAAR DAMBOA</div>
    </div>

    <!-- ===== PIED DE PAGE SANS TITRES ===== -->
    <div class="footer-info">
        <div class="item">
            <span class="value">Lomé-Togo, Kladjamé non loin de l'antenne moor</span>
        </div>
        <div class="item">
            <span class="value">TG-LFW-01-2024-A10-06156 / 1001972055</span>
        </div>
        <div class="item">
            <span class="value">TPU / 193330</span>
        </div>
        <div class="item">
            <span class="value">mounouo2023@gmail.com / 90430202 / 90430702</span>
        </div>
    </div>

</div>

<!-- ===== BOUTONS D'ACTION ===== -->
<div class="invoice-actions">
    <a href="{{ route('factures.pdf', $facture->id) }}" class="btn-pdf">
        <i class="fa-solid fa-file-pdf"></i> Télécharger PDF
    </a>
    <a href="{{ route('factures.edit', $facture->id) }}" class="btn-edit">
        <i class="fa-solid fa-pen"></i> Modifier
    </a>
    <button class="btn-delete-action" onclick="confirmDelete('{{ $facture->id }}', '{{ $facture->invoice_number }}')">
        <i class="fa-solid fa-trash-can"></i> Supprimer
    </button>
</div>

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
            <form id="deleteForm" method="POST" action="{{ route('factures.destroy', $facture->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-delete">
                    <i class="fa-solid fa-trash-can"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, invoiceNumber) {
        document.getElementById('deleteInvoiceNumber').textContent = invoiceNumber;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endsection