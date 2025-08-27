<!DOCTYPE html>
<html>
<head>
    <title>Reçu de pointage - {{ $boutique->nom_boutique }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Reset et styles de base */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px; 
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }
        
        /* En-tête */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .company-details {
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }
        
        .document-info {
            text-align: right;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .document-number {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
            display: block;
        }
        
        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }
        
        /* Section info boutique */
        .boutique-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 0 0 25px 0;
            border-left: 4px solid #2c3e50;
        }
        
        .boutique-name {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .boutique-details {
            font-size: 11px;
            color: #555;
        }
        
        .report-title h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
        }
        
        .report-title h3 {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-weight: normal;
            font-size: 16px;
        }
        
        /* Tableau des données */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 25px 0;
            font-size: 11px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .data-table th {
            background-color: #2c3e50;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            border: 1px solid #1a252f;
        }
        
        .data-table td {
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            vertical-align: top;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Section des totaux */
        .summary-section {
            margin: 30px 0;
            display: flex;
            justify-content: flex-end;
        }
        
        .summary-table {
            width: 45%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
            font-size: 11px;
        }
        
        .summary-table td {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }
        
        .summary-table tr:last-child td {
            font-weight: 700;
            background-color: #f8f9fa;
            border-top: 2px solid #2c3e50;
        }
        
        .summary-label {
            font-weight: 600;
            color: #2c3e50;
            width: 70%;
        }
        
        /* Badges de statut améliorés */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
            min-width: 80px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid transparent;
        }
        
        .status-livre {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-color: #c8e6c9;
        }
        
        .status-non-livre {
            background-color: #ffebee;
            color: #c62828;
            border-color: #ffcdd2;
        }
        
        .status-retourne {
            background-color: #fff8e1;
            color: #f57f17;
            border-color: #ffecb3;
        }
        
        /* Pied de page */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            margin-top: 40px;
            padding: 15px 30px 0 30px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 9px;
            color: #777;
            line-height: 1.4;
            background-color: #fff;
        }
        
        .page-number:after {
            content: "Page " counter(page);
            font-size: 9px;
            color: #777;
        }
        
        /* Message vide */
        .empty-message {
            text-align: center;
            padding: 30px;
            color: #777;
            font-style: italic;
            background-color: #f9f9f9;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 12px;
        }
        
        /* Signature */
        .signature {
            margin: 40px 0 80px 0;
            text-align: right;
        }
        
        .signature-line {
            width: 200px;
            height: 1px;
            background-color: #333;
            margin: 30px 0 5px auto;
        }
        
        .signature-text {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
        }
            /* Filigrane */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            opacity: 0.05;
            pointer-events: none;
            z-index: -1;
            white-space: nowrap;
            font-weight: 700;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="watermark">OVL DELIVERY SERVICES</div>
    <div class="header">
        <div class="company-info">
            <div class="company-name">OVL DELIVERY SERVICES</div>
            <div class="company-details">
                <p>Capital de 1 000 000 CFA</p>
                <p>Cocody Riviera Golf face de l'Ambassade des USA</p>
                <p>Tél: +225 07 877 0300 / +225 5848 2836</p>
                <p>Email: ovl-delivery@delivery.online</p>
                <p>WhatsApp: +225 5848 2836</p>
            </div>
        </div>
        
        <div class="document-info">
            <img src="{{ public_path('img/logo.jpg') }}" alt="Logo OVL Delivery" class="logo">
            <div class="document-title">REÇU DU POINT DES LIVRAISONS</div>
            <span class="document-number">N° {{ strtoupper(uniqid('RCPT-')) }}</span>
            <div>Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
        </div>
    </div>
    
    <div class="boutique-info">
        <div class="boutique-name">{{ $boutique->nom_boutique }}</div>
        <div class="boutique-details">
            Point du jour - {{ \Carbon\Carbon::parse($request->date)->format('d/m/Y') }}
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Communes</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date de réception</th>
                <th>Date de livraison</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commandes as $commande)
                <tr>
                    <td>{{ $commande->communes }}</td>
                    <td>{{ number_format($commande->cout_reel, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($commande->statut == 'Livré')
                            <span class="status-badge status-livre">{{ $commande->statut }}</span>
                        @elseif($commande->statut == 'Non Livré')
                            <span class="status-badge status-non-livre">{{ $commande->statut }}</span>
                        @elseif($commande->statut == 'Retourné')
                            <span class="status-badge status-retourne">{{ $commande->statut }}</span>
                        @else
                            {{ $commande->statut }}
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-message">Aucune commande trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php
        $totalCommandes = $commandes->count();
        $totalLivres = $commandes->where('statut', 'Livré')->sum('cout_reel');
        $totalNonLivres = $commandes->where('statut', 'Non Livré')->sum('cout_reel');
        $totalRetournes = $commandes->where('statut', 'Retourné')->sum('cout_reel');
        $totalGeneral = $totalLivres + $totalRetournes; // Exclure les commandes non livrées du total général
    @endphp

    <div class="summary-section">
        <table class="summary-table">
            <tr>
                <td class="summary-label">Nombre total de commandes :</td>
                <td style="text-align: right;">{{ $totalCommandes }}</td>
            </tr>
            <tr>
                <td class="summary-label">Total commandes livrées :</td>
                <td style="text-align: right;">{{ number_format($totalLivres, 0, ' ', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="summary-label">Total commandes non livrées :</td>
                <td style="text-align: right;">{{ number_format($totalNonLivres, 0, ' ', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="summary-label">Total commandes retournées :</td>
                <td style="text-align: right;">{{ number_format($totalRetournes, 0, ' ', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="summary-label">MONTANT TOTAL :</td>
                <td style="text-align: right; font-weight: 700;">{{ number_format($totalGeneral, 0, ' ', ' ') }} FCFA</td>
            </tr>
        </table>
    </div>
    
    <div class="signature">
        <div class="signature-line"></div>
        <div class="signature-text">Signature & cachet</div>
    </div>
    
    <div class="footer">
        <div>OVL DELIVERY SERVICES - {{ date('Y') }} | Tous droits réservés</div>
        <div>Document généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
        <div class="page-number"></div>
    </div>
</body>
</html>