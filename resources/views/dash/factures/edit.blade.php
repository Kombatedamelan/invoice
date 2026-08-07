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
        color: #ffa502;
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

    .form-section {
        max-width: 900px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 35px 40px;
        animation: fadeUp 1s ease-out 0.2s both;
    }

    .form-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-title i {
        color: #ffa502;
    }

    .form-subtitle {
        color: #a0aec0;
        font-size: 0.85rem;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 25px;
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
        color: #ffa502;
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
        padding: 11px 16px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        color: #fff;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #ffa502;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 20px rgba(255, 165, 0, 0.05);
    }

    .form-group input:read-only {
        background: rgba(255, 165, 0, 0.05);
        border-color: rgba(255, 165, 0, 0.1);
        color: #ffa502;
        font-weight: 600;
        cursor: not-allowed;
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

    .form-group textarea {
        resize: vertical;
        min-height: 60px;
    }

    .lines-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        margin-top: 15px;
    }

    .lines-table th {
        color: #a0aec0;
        font-weight: 500;
        font-size: 0.7rem;
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
        border-color: #ffa502;
        background: rgba(255, 255, 255, 0.08);
    }

    .lines-table input.line-total {
        background: rgba(255, 165, 0, 0.05);
        border-color: rgba(255, 165, 0, 0.1);
        color: #ffa502;
        font-weight: 600;
        text-align: right;
    }

    .btn-add-line {
        background: rgba(255, 165, 0, 0.08);
        border: 1px dashed rgba(255, 165, 0, 0.2);
        color: #ffa502;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Poppins', sans-serif;
        margin-top: 10px;
    }

    .btn-add-line:hover {
        background: rgba(255, 165, 0, 0.15);
        border-color: #ffa502;
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

    .lines-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
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
        color: #ffa502;
        margin-right: 8px;
    }

    .total-invoice input {
        width: 180px;
        padding: 10px 16px;
        background: rgba(255, 165, 0, 0.08);
        border: 1px solid rgba(255, 165, 0, 0.15);
        border-radius: 10px;
        color: #ffa502;
        font-size: 1.2rem;
        font-weight: 700;
        text-align: right;
        font-family: 'Poppins', sans-serif;
        outline: none;
    }

    .total-invoice input:read-only {
        cursor: default;
    }

    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        align-items: center;
    }

    .btn-update {
        background: linear-gradient(135deg, #ffa502, #e67e22);
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
        box-shadow: 0 4px 25px rgba(255, 165, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Poppins', sans-serif;
    }

    .btn-update:hover {
        box-shadow: 0 8px 35px rgba(255, 165, 0, 0.35);
        transform: translateY(-2px);
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
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    @media (max-width: 850px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .form-section {
            padding: 25px 20px;
        }
        .form-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .form-group.full-width {
            grid-column: 1;
        }
        .form-actions {
            flex-direction: column-reverse;
        }
        .btn-update,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
        .lines-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .total-invoice input {
            width: 100%;
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
            <i class="fa-solid fa-pen"></i> Modifier la facture
        </h1>
        <p><i class="fa-regular fa-circle-check"></i> Modifiez les informations de la facture.</p>
    </div>
    <a href="{{ route('factures.index') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</section>

<!-- ===== FORMULAIRE ===== -->
<section class="form-section">
    <div class="form-title">
        <i class="fa-solid fa-file-invoice"></i> Informations de la facture
    </div>
    <div class="form-subtitle">
        Les champs marqués d'un <span style="color: #ff6b6b;">*</span> sont obligatoires.
    </div>

    <form action="{{ route('factures.update', $facture->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Date -->
            <div class="form-group">
                <label for="date"><i class="fa-solid fa-calendar-days"></i> Date <span class="required">*</span></label>
                <input type="date" id="date" name="date" value="{{ old('date', $facture->date->format('Y-m-d')) }}" required>
                @error('date')
                    <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- N° Facture -->
            <div class="form-group">
                <label for="invoice_number"><i class="fa-solid fa-hashtag"></i> N° Facture <span class="required">*</span></label>
                <input type="text" id="invoice_number" name="invoice_number" value="{{ $facture->invoice_number }}" readonly>
                <span class="input-hint">Le numéro de facture ne peut pas être modifié</span>
                @error('invoice_number')
                    <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Client -->
            <div class="form-group">
                <label for="client"><i class="fa-solid fa-user"></i> Client <span class="required">*</span></label>
                <input type="text" id="client" name="client" placeholder="Nom du client ou raison sociale" value="{{ old('client', $facture->client) }}" required>
                @error('client')
                    <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bon de commande -->
            <div class="form-group">
                <label for="order_number"><i class="fa-solid fa-file-pen"></i> Bon de commande</label>
                <input type="text" id="order_number" name="order_number" placeholder="N°0023-2026" value="{{ old('order_number', $facture->order_number) }}">
                @error('order_number')
                    <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Objet -->
            <div class="form-group full-width">
                <label for="object"><i class="fa-solid fa-tag"></i> Objet <span class="required">*</span></label>
                <textarea id="object" name="object" rows="2" placeholder="Ex: Location d'un véhicule 4X4 avec chauffeur pour mission..." required>{{ old('object', $facture->object) }}</textarea>
                @error('object')
                    <span class="error-text" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- ===== LIGNES DE FACTURE ===== -->
        <div style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
                <h4 style="color: #e2e8f0; font-size: 1rem;"><i class="fa-solid fa-list" style="color: #ffa502;"></i> Lignes de facture</h4>
                <span style="color: #5a6a7e; font-size: 0.7rem;">Quantité × Jours × PU = Montant</span>
            </div>

            <div class="lines-table-wrap" style="overflow-x: auto;">
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
                        @foreach($facture->lines as $index => $line)
                            <tr>
                                <td>
                                    <input type="text" class="line-designation" name="lines[{{ $index }}][designation]" placeholder="Désignation" value="{{ $line['designation'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="text" class="line-quantity" name="lines[{{ $index }}][quantity]" placeholder="Ex: 1 ou 20%" value="{{ $line['quantity'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="number" class="line-days" name="lines[{{ $index }}][days]" placeholder="Jours" min="0" step="1" value="{{ $line['days'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="number" class="line-unit-price" name="lines[{{ $index }}][unit_price]" placeholder="0" step="1" min="0" value="{{ $line['unit_price'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="text" class="line-total" readonly value="{{ (($line['quantity'] ?? 0) * ($line['days'] ?? 0) * ($line['unit_price'] ?? 0)) }}">
                                </td>
                                <td>
                                    <button type="button" class="btn-remove-line" onclick="removeLine(this)">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn-add-line" id="addLineBtn">
                <i class="fa-solid fa-plus"></i> Ajouter une ligne
            </button>

            <div class="lines-footer">
                <div></div>
                <div class="total-invoice">
                    <label for="total_invoice"><i class="fa-solid fa-calculator"></i> Total</label>
                    <input type="text" id="total_invoice" name="total_invoice" value="{{ $facture->total_amount }}" readonly>
                </div>
            </div>
        </div>

        <!-- ===== BOUTONS ===== -->
        <div class="form-actions">
            <button type="submit" class="btn-update">
                <i class="fa-solid fa-floppy-disk"></i> Mettre à jour
            </button>
            <a href="{{ route('factures.index') }}" class="btn-cancel">
                <i class="fa-solid fa-times"></i> Annuler
            </a>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const linesBody = document.getElementById('linesBody');
        const addLineBtn = document.getElementById('addLineBtn');
        const totalInvoice = document.getElementById('total_invoice');

        let lineCounter = {{ count($facture->lines) }};

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

            const inputs = tr.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', updateAll);
            });

            lineCounter++;
            updateAll();
        }

        window.removeLine = function(btn) {
            const tr = btn.closest('tr');
            if (linesBody.children.length > 1) {
                tr.remove();
                updateAll();
            } else {
                alert('Vous devez conserver au moins une ligne.');
            }
        };

        function updateAll() {
            updateLinesTotals();
            updateTotalInvoice();
        }

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

        addLineBtn.addEventListener('click', function() {
            addLine();
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('line-quantity')) {
                updateAll();
            }
        });

        // Initialiser les totaux
        updateAll();
    });
</script>
@endsection