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

    /* ===== LAYOUT 2 COLONNES ===== */
    .invoice-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        animation: fadeUp 1s ease-out 0.2s both;
    }

    @media (max-width: 1024px) {
        .invoice-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ===== CARTES ===== */
    .card-section {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 30px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .card-section:hover {
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: #00f2fe;
    }

    .card-subtitle {
        color: #a0aec0;
        font-size: 0.8rem;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* ===== FORMULAIRE GAUCHE ===== */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #a0aec0;
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-group label i {
        color: #00f2fe;
        margin-right: 6px;
        width: 16px;
    }

    .form-group label .required {
        color: #ff6b6b;
        margin-left: 4px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        color: #fff;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #5a6a7e;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #00f2fe;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 20px rgba(0, 242, 254, 0.05);
    }

    .form-group input[type="date"] {
        color-scheme: dark;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.7);
        cursor: pointer;
    }

    .form-group .input-hint {
        color: #5a6a7e;
        font-size: 0.65rem;
        margin-top: 3px;
        font-weight: 300;
    }

    /* ===== LIGNES DE FACTURE (DROITE) ===== */
    .lines-section {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .lines-table-wrap {
        flex: 1;
        overflow-x: auto;
        margin-bottom: 15px;
    }

    .lines-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .lines-table th {
        color: #a0aec0;
        font-weight: 500;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 10px 8px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .lines-table td {
        padding: 8px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        vertical-align: middle;
    }

    .lines-table input {
        width: 100%;
        padding: 8px 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 8px;
        color: #fff;
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        outline: none;
    }

    .lines-table input:focus {
        border-color: #00f2fe;
        background: rgba(255, 255, 255, 0.08);
    }

    .lines-table input.line-total {
        background: rgba(0, 242, 254, 0.05);
        border-color: rgba(0, 242, 254, 0.1);
        color: #00f2fe;
        font-weight: 600;
        text-align: right;
    }

    .btn-remove-line {
        background: rgba(255, 107, 107, 0.08);
        border: none;
        color: #ff6b6b;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-remove-line:hover {
        background: rgba(255, 107, 107, 0.2);
    }

    /* ===== LIGNE AJOUTER + TOTAL (dans la carte de droite) ===== */
    .lines-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        margin-top: 5px;
        flex-shrink: 0;
    }

    .btn-add-line {
        background: rgba(0, 242, 254, 0.08);
        border: 1px dashed rgba(0, 242, 254, 0.2);
        color: #00f2fe;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .btn-add-line:hover {
        background: rgba(0, 242, 254, 0.15);
        border-color: #00f2fe;
        transform: translateY(-1px);
    }

    .total-invoice {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .total-invoice label {
        color: #a0aec0;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .total-invoice label i {
        color: #00f2fe;
        margin-right: 8px;
    }

    .total-invoice input {
        width: 180px;
        padding: 10px 16px;
        background: rgba(0, 242, 254, 0.08);
        border: 1px solid rgba(0, 242, 254, 0.15);
        border-radius: 10px;
        color: #00f2fe;
        font-size: 1.2rem;
        font-weight: 700;
        text-align: right;
        font-family: 'Poppins', sans-serif;
        outline: none;
    }

    .total-invoice input:read-only {
        cursor: default;
    }

    /* ===== BOUTONS EN BAS A GAUCHE ===== */
    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        align-items: center;
    }

    .btn-submit {
        background: linear-gradient(135deg, #0072ff, #00f2fe);
        border: none;
        padding: 14px 40px;
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 25px rgba(0, 242, 254, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Poppins', sans-serif;
    }

    .btn-submit:hover {
        box-shadow: 0 8px 35px rgba(0, 242, 254, 0.35);
        transform: translateY(-2px);
    }

    .btn-submit:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-cancel {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 14px 30px;
        border-radius: 12px;
        color: #a0aec0;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    /* ===== BADGE ===== */
    .badge-lines {
        background: rgba(0, 242, 254, 0.1);
        color: #00f2fe;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .invoice-layout {
            grid-template-columns: 1fr;
        }
        .card-section {
            padding: 25px 20px;
        }
    }

    @media (max-width: 850px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .form-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .form-group.full-width {
            grid-column: 1;
        }
        .lines-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .total-invoice {
            justify-content: space-between;
        }
        .total-invoice input {
            width: 140px;
        }
        .form-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
        .lines-table {
            font-size: 0.75rem;
        }
        .lines-table input {
            font-size: 0.75rem;
            padding: 6px 8px;
        }
        .btn-add-line {
            justify-content: center;
            padding: 10px 16px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .welcome-text h1 {
            font-size: 1.5rem;
        }
        .btn-back {
            padding: 10px 18px;
            font-size: 0.8rem;
        }
        .card-section {
            padding: 18px 15px;
        }
        .card-title {
            font-size: 1rem;
        }
        .btn-submit {
            padding: 12px 20px;
            font-size: 0.9rem;
        }
        .btn-cancel {
            padding: 12px 20px;
            font-size: 0.9rem;
        }
        .total-invoice input {
            width: 120px;
            font-size: 1rem;
        }
    }
</style>

<!-- ===== EN-TÊTE ===== -->
<section class="content-header">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-plus-circle"></i> Nouvelle Facture
        </h1>
    </div>
    <a href="{{ route('factures.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</section>

<!-- ===== FORMULAIRE UNIQUE ===== -->
<form id="invoiceForm" action="{{ route('factures.store') }}" method="POST">
    @csrf

    <!-- ===== LAYOUT 2 COLONNES ===== -->
    <div class="invoice-layout">

        <!-- ===== COLONNE GAUCHE : INFORMATIONS ===== -->
        <div class="card-section">
            <div class="card-title">
                <i class="fa-solid fa-file-invoice"></i> Informations de la facture
            </div>
            <div class="card-subtitle">
                Les champs marqués d'un <span style="color: #ff6b6b;">*</span> sont obligatoires.
            </div>

            <div class="form-grid">
                <!-- Date -->
                <div class="form-group">
                    <label for="date"><i class="fa-solid fa-calendar-days"></i> Date <span class="required">*</span></label>
                    <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                    @error('date')
                        <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- N° Facture (incrémentation automatique) -->
                <!-- N° Facture (incrémentation automatique) -->
                <div class="form-group">
                    <label for="invoice_number"><i class="fa-solid fa-hashtag"></i> N° Facture <span class="required">*</span></label>
                    <input type="text" id="invoice_number" name="invoice_number" 
                        placeholder="001/MM/MOU/AAAA" 
                        value="{{ old('invoice_number', $nextInvoiceNumber) }}" 
                        required readonly 
                        style="background: rgba(0, 242, 254, 0.05); border-color: rgba(0, 242, 254, 0.1); color: #00f2fe; font-weight: 600; cursor: not-allowed;">
                    <span class="input-hint">Incrémenté automatiquement à partir de la dernière facture</span>
                    @error('invoice_number')
                        <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Client -->
                <div class="form-group">
                    <label for="client"><i class="fa-solid fa-user"></i> Client <span class="required">*</span></label>
                    <input type="text" id="client" name="client" placeholder="Nom du client ou raison sociale" value="{{ old('client') }}" required>
                    @error('client')
                        <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bon de commande -->
                <div class="form-group">
                    <label for="order_number"><i class="fa-solid fa-file-pen"></i> Bon de commande</label>
                    <input type="text" id="order_number" name="order_number" placeholder="N°0023-2026" value="{{ old('order_number') }}">
                    @error('order_number')
                        <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Objet -->
                <div class="form-group full-width">
                    <label for="object"><i class="fa-solid fa-tag"></i> Objet <span class="required">*</span></label>
                    <textarea id="object" name="object" rows="2" placeholder="Ex: Location d'un véhicule 4X4 avec chauffeur pour mission..." required>{{ old('object') }}</textarea>
                    @error('object')
                        <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== COLONNE DROITE : LIGNES DE FACTURE ===== -->
        <div class="card-section">
            <div class="card-title">
                <i class="fa-solid fa-list"></i> Lignes de facture
            </div>
            <div class="card-subtitle" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <span><i class="fa-solid fa-calculator" style="color: #00f2fe;"></i> Quantité × Jours × PU = Montant</span>
                <span class="badge-lines" id="lineCount">1 ligne</span>
            </div>

            <div class="lines-section">
                <!-- Tableau des lignes -->
                <div class="lines-table-wrap">
                    <table class="lines-table" id="linesTable">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Désignation <span class="required">*</span></th>
                                <th style="width: 15%;">Quantité <span class="required">*</span></th>
                                <th style="width: 15%;">Jours <span class="required">*</span></th>
                                <th style="width: 20%;">PU (FCFA) <span class="required">*</span></th>
                                <th style="width: 15%;">Montant</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="linesBody">
                            <!-- Les lignes sont ajoutées ici par JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- ===== LIGNE AJOUTER + TOTAL (dans la carte de droite) ===== -->
                <div class="lines-footer">
                    <button type="button" class="btn-add-line" id="addLineBtn">
                        <i class="fa-solid fa-plus-circle"></i> Ajouter une ligne
                    </button>

                    <div class="total-invoice">
                        <label for="total_invoice"><i class="fa-solid fa-coins"></i> Total</label>
                        <input type="text" id="total_invoice" name="total_invoice" value="0" readonly>
                        @error('total_amount')
                            <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== BOUTONS EN BAS A GAUCHE ===== -->
    <div class="form-actions">
        <button type="submit" class="btn-submit" id="submitBtn">
            <i class="fa-solid fa-file-invoice"></i> Générer la facture
        </button>
        <button type="reset" class="btn-cancel">
            <i class="fa-solid fa-eraser"></i> Effacer
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ===== RÉFÉRENCES =====
        const linesBody = document.getElementById('linesBody');
        const addLineBtn = document.getElementById('addLineBtn');
        const totalInvoice = document.getElementById('total_invoice');
        const lineCount = document.getElementById('lineCount');

        let lineCounter = 0;

        // ===== AJOUTER UNE LIGNE =====
        function addLine(designation = '', quantity = '', days = '', unitPrice = '') {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="text" class="line-designation" name="lines[${lineCounter}][designation]" placeholder="Désignation" value="${designation}" required>
                </td>
                <td>
                    <input type="text" class="line-quantity" name="lines[${lineCounter}][quantity]" placeholder="Ex: 1 ou 20%" value="${quantity}" required>
                </td>
                <td>
                    <input type="number" class="line-days" name="lines[${lineCounter}][days]" placeholder="Jours" min="0" step="1" value="${days}" required>
                </td>
                <td>
                    <input type="number" class="line-unit-price" name="lines[${lineCounter}][unit_price]" placeholder="0" step="1" min="0" value="${unitPrice}" required>
                </td>
                <td>
                    <input type="text" class="line-total" readonly value="0">
                </td>
                <td>
                    <button type="button" class="btn-remove-line" onclick="removeLine(this)">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </td>
            `;
            linesBody.appendChild(tr);

            // Ajouter les événements
            const inputs = tr.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', updateAll);
            });

            lineCounter++;
            updateAll();
        }

        // ===== SUPPRIMER UNE LIGNE =====
        window.removeLine = function(btn) {
            const tr = btn.closest('tr');
            if (linesBody.children.length > 1) {
                tr.remove();
                updateAll();
            } else {
                alert('Vous devez conserver au moins une ligne.');
            }
        };

        // ===== METTRE À JOUR TOUT =====
        function updateAll() {
            updateLinesTotals();
            updateTotalInvoice();
            updateLineCount();
        }

        // ===== METTRE À JOUR LES TOTAUX DES LIGNES =====
        function updateLinesTotals() {
            const rows = linesBody.querySelectorAll('tr');
            rows.forEach(row => {
                const quantityInput = row.querySelector('.line-quantity');
                const daysInput = row.querySelector('.line-days');
                const unitPriceInput = row.querySelector('.line-unit-price');
                const totalInput = row.querySelector('.line-total');

                let quantity = 0;
                const qtyVal = quantityInput.value.trim();
                if (qtyVal.includes('%')) {
                    quantity = parseFloat(qtyVal.replace('%', '')) || 0;
                } else {
                    quantity = parseFloat(qtyVal) || 0;
                }

                const days = parseFloat(daysInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const total = quantity * days * unitPrice;
                totalInput.value = total > 0 ? total.toFixed(0) : '0';
            });
        }

        // ===== METTRE À JOUR LE TOTAL DE LA FACTURE =====
        function updateTotalInvoice() {
            const rows = linesBody.querySelectorAll('tr');
            let grandTotal = 0;
            rows.forEach(row => {
                const totalInput = row.querySelector('.line-total');
                const val = parseFloat(totalInput.value) || 0;
                grandTotal += val;
            });
            totalInvoice.value = grandTotal > 0 ? grandTotal.toFixed(0) : '0';
        }

        // ===== METTRE À JOUR LE COMPTEUR DE LIGNES =====
        function updateLineCount() {
            const count = linesBody.children.length;
            lineCount.textContent = count + ' ligne' + (count > 1 ? 's' : '');
        }

        // ===== BOUTON AJOUTER UNE LIGNE =====
        addLineBtn.addEventListener('click', function() {
            addLine();
        });

        // ===== AJOUTER UNE LIGNE PAR DÉFAUT =====
        addLine();

        // ===== GESTION DES POURCENTAGES =====
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('line-quantity')) {
                updateAll();
            }
        });

        // ===== SOUCISSION DU FORMULAIRE =====
        document.getElementById('invoiceForm').addEventListener('submit', function(e) {
            const client = document.getElementById('client').value.trim();
            const object = document.getElementById('object').value.trim();
            const total = parseFloat(totalInvoice.value) || 0;

            // Vérifier que toutes les lignes ont une désignation
            const rows = linesBody.querySelectorAll('tr');
            let hasError = false;
            rows.forEach(row => {
                const designation = row.querySelector('.line-designation').value.trim();
                const quantity = row.querySelector('.line-quantity').value.trim();
                const days = row.querySelector('.line-days').value.trim();
                const unitPrice = row.querySelector('.line-unit-price').value.trim();
                if (!designation || !quantity || !days || !unitPrice) {
                    hasError = true;
                    row.style.border = '2px solid #ff6b6b';
                } else {
                    row.style.border = '';
                }
            });

            if (!client || !object) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires (Client et Objet).');
                return false;
            }

            if (hasError) {
                e.preventDefault();
                alert('Veuillez remplir toutes les lignes correctement (Désignation, Quantité, Jours et PU).');
                return false;
            }

            if (total <= 0) {
                e.preventDefault();
                alert('Le montant total doit être supérieur à 0.');
                return false;
            }

            // Afficher les données envoyées dans la console pour déboguer
            console.log('Données du formulaire :', new FormData(this));
            
            return true;
        });

    });
</script>
@endsection