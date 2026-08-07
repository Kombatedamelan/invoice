<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $facture->invoice_number }}</title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }

        body {
            font-family: "Times New Roman", serif;
            color: #000;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .invoice-wrapper {
            width: 100%;
            padding-bottom: 70px;
        }

        /* ==========================
           EN-TÊTE
        ========================== */

        .header-table {
            width:100%;
            border-collapse:collapse;
        }

        
        .logo-cell {
            width: 30%;
            text-align: left !important;
            vertical-align: top;
        }

        .logo-cell img {
            display: block !important;
            margin-left: 0 !important;
            margin-right: auto !important;
        }

        .header-table td {
            vertical-align: top;
        }


        .company-info {
            width: 50%;
            font-size: 11px;
            line-height: 1.5;
            text-align: left;
            vertical-align: top;
            padding: 0 !important;
            margin: 0;

            position: relative;
            top: -25px;   /* monte le bloc */
            left: -155px;  /* déplace vers la gauche */
        }

        .date-cell {
            width: 25%;
            text-align: right;
            font-size: 12px;
            position: relative;   /* monte le bloc */
            left: 100px; 
        }

        /* ==========================
           CLIENT - CENTRÉ
        ========================== */

        .client-block {
            width: 400px;
            text-align: left;
            margin-top: 10px;
            margin-bottom: 10px;
            line-height: 1.4;
            position: relative;
            left: 350px;
        }

        /* ==========================
           OBJET
        ========================== */

        .object-block {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        /* ==========================
           NUMERO FACTURE
        ========================== */

        .invoice-number {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        /* ==========================
           TABLEAU FACTURE
        ========================== */

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 15px;
        }

        .invoice-table thead {
            display: table-header-group;
        }

        .invoice-table tr {
            page-break-inside: avoid;
        }

        .invoice-table th {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }

        .invoice-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        .invoice-table .designation {
            text-align: left;
        }

        .invoice-table .number {
            text-align: center;
        }

        .invoice-table .money {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
        }

        /* ==========================
           MONTANT LETTRES
        ========================== */

        .amount-words {
            margin-top: 15px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        /* ==========================
           INFORMATIONS BANCAIRES
        ========================== */

        .bank-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .bank-table td {
            padding: 2px;
        }

        .bank-label {
            width: 160px;
            font-weight: bold;
        }

        /* ==========================
           SIGNATURE
        ========================== */

        .signature-table {
            width: 100%;
            margin-top: 40px;
            
        }

        .signature-cell {
            width: 70%;
        }

        .signature-right {
            text-align: left;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 40px;
        }

        /* ==========================
           FOOTER
        ========================== */

       /* ==========================
        FOOTER FIXE EN BAS DE PAGE
        ========================== */

        .footer-table {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            background: #fff;
        }

        .footer-table td {
            width: 25%;
            vertical-align: top;
            padding: 5px;
        }

        /* ==========================
           EVITER LES COUPURES
        ========================== */

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
        }

        /* ==========================
           RESPONSIVE
        ========================== */

        @media (max-width: 850px) {
            .header-table td {
                display: block;
                width: 100% !important;
                text-align: center !important;
            }
            .logo-cell img {
                width: 120px;
                margin: 0 auto !important;
            }
            .company-info {
                text-align: center !important;
                padding-left: 0;
            }
            .date-cell {
                text-align: center !important;
            }
            .footer-table td {
                width: 50%;
            }
        }

        @media (max-width: 480px) {
            .footer-table td {
                width: 100%;
            }
            .invoice-table {
                font-size: 9px;
            }
            .invoice-table th,
            .invoice-table td {
                padding: 4px;
            }
            .bank-label {
                width: 120px;
            }
            .logo-cell img {
                width: 100px;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-wrapper">

        <!-- ==========================
             EN-TÊTE
        ========================== -->

        <table class="header-table">
            <tr>
                <td class="logo-cell" align="left" valign="top">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo MOUNOUO">
                </td>

                <td class="company-info" align="left" valign="top">
                    RCCM: TG-LFW-01-2024-A10-06-156 / NIF: 1001972055<br>
                    Adéticopé-Lomé, préfecture d'AGOE NYIVE,<br>
                    Représentée par Madame SAMBIANI FARDJA DAMBOA
                </td>

                <td class="date-cell" align="right" valign="top">
                    Lomé, le 
                    {{ $facture->date->format('d') }}
                    {{ [
                        'janvier','février','mars','avril',
                        'mai','juin','juillet','août',
                        'septembre','octobre','novembre','décembre'
                    ][$facture->date->format('n')-1] }}
                    {{ $facture->date->format('Y') }}
                </td>
            </tr>
        </table>

        <!-- ==========================
             CLIENT - CENTRÉ
        ========================== -->

        <div class="client-block">
            <strong>Client :</strong>
            {{ $facture->client }}
            <br>
            {{ $facture->client_address ?? 'Avenue de Tervuren 36, 1040 Bruxelles, Belgique' }}
            <br>
            {{ $facture->client_tva ?? 'VAT n°BE 0452.263.785' }}
        </div>

        <!-- ==========================
             OBJET
        ========================== -->

        <div class="object-block">
            <strong>Objet :</strong>
            {{ $facture->object }}
        </div>

        <!-- ==========================
             NUMERO FACTURE
        ========================== -->

        <div class="invoice-number">
            Facture N° {{ $facture->invoice_number }}
        </div>

        <!-- ==========================
             TABLEAU FACTURE
        ========================== -->

        @php
            $grandTotal = 0;
            $orderNumber = $facture->order_number ?? 'N° 0027-COMMUNICATION /DUE/ATI-AESA';
        @endphp

        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="18%">N° Bon de commande</th>
                    <th width="34%">Désignation</th>
                    <th width="8%">Nbre</th>
                    <th width="10%">Durée<br>(jours)</th>
                    <th width="13%">PPU<br>(FCFA)</th>
                    <th width="17%">Montant<br>(FCFA)</th>
                </tr>
            </thead>
            <tbody>
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
                            <td class="number" rowspan="{{ count($facture->lines) }}">
                                {{ $orderNumber }}
                            </td>
                        @endif
                        <td class="designation">
                            {{ $line['designation'] ?? '-' }}
                        </td>
                        <td class="number">
                            {{ $qty }}
                        </td>
                        <td class="number">
                            {{ $days }}
                        </td>
                        <td class="money">
                            {{ number_format($pu, 0, ',', ' ') }}
                        </td>
                        <td class="money">
                            {{ number_format($total, 0, ',', ' ') }}
                        </td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5" class="money">TOTAL</td>
                    <td class="money">
                        {{ number_format($grandTotal, 0, ',', ' ') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ==========================
             MONTANT EN LETTRES
        ========================== -->

        <div class="amount-words">
            <strong>Arrêter la présente facture à la somme de :</strong>
            {{ $facture->amount_in_words ?? 'Cinq cent soixante mille' }}
            ({{ number_format($grandTotal, 0, ',', ' ') }})
            francs CFA.
        </div>

        <!-- ==========================
             BANQUE
        ========================== -->

        <table class="bank-table">
            <tr>
                <td class="bank-label">Banque :</td>
                <td>ORABANK</td>
            </tr>
            <tr>
                <td class="bank-label">Intitulé du Compte :</td>
                <td>MOUNOUO</td>
            </tr>
            <tr>
                <td class="bank-label">Code Banque :</td>
                <td>TG 116</td>
            </tr>
            <tr>
                <td class="bank-label">Code Agence :</td>
                <td>01101</td>
            </tr>
            <tr>
                <td class="bank-label">Code Swift :</td>
                <td>ORBKTGTG</td>
            </tr>
            <tr>
                <td class="bank-label">Numéro de Compte :</td>
                <td>084539200201</td>
            </tr>
            <tr>
                <td class="bank-label">Clé RIB :</td>
                <td>34</td>
            </tr>
            <tr>
                <td class="bank-label">Code IBAN :</td>
                <td>TG53TG1160110108453920020134</td>
            </tr>
        </table>

        <!-- ==========================
             SIGNATURE
        ========================== -->

        <table class="signature-table">
            <tr>
                <td class="signature-cell"></td>
                <td class="signature-cell signature-right">
                    <div class="signature-title">Le responsable</div>
                    <br><br><br>
                    <strong>SAMBIAAR DAMBOA</strong>
                </td>
            </tr>
        </table>

        <!-- ==========================
             FOOTER
        ========================== -->

        <table class="footer-table">
            <tr>
                <td>
                    Lomé-Togo,<br>
                    Kladjamé non loin de l'antenne moor
                </td>
                <td>
                    TG-LFW-01-2024-A10-06156
                    <br>
                    NIF 1001972055
                </td>
                <td>
                    Régune fiscal: TPU
                    <br>
                    CNSS: 193330 
                </td>
                <td>
                    mounouo2023@gmail.com
                    <br>
                    contact: 90430202
                </td>
            </tr>
        </table>

    </div>

</body>
</html>