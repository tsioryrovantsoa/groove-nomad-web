<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Facture - Proposition #{{ $proposal->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .client-info,
        .invoice-details {
            width: 45%;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .festival-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            background-color: #e9ecef;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }

        .page-break {
            page-break-before: always;
        }

        .ai-response {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .ai-response h3 {
            color: #007bff;
            margin-bottom: 15px;
        }

        .ai-response-content {
            line-height: 1.6;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Page 1: Détails de la facture -->
    <div class="header">
        <div class="logo">GROOVE NOMAD</div>
        <div>Votre spécialiste des voyages festivaliers</div>
    </div>

    <div class="invoice-info">
        <div class="client-info">
            <div class="section-title">Informations client</div>
            <div class="info-row">
                <span class="label">Nom :</span>
                <span class="value">{{ $user->first_name }} {{ $user->last_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email :</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="label">Téléphone :</span>
                <span class="value">{{ $user->phone_number }}</span>
            </div>
            <div class="info-row">
                <span class="label">Adresse :</span>
                <span class="value">{{ $user->address }}, {{ $user->city }}</span>
            </div>
        </div>

        <div class="invoice-details">
            <div class="section-title">Détails de la facture</div>
            <div class="info-row">
                <span class="label">Numéro de facture :</span>
                <span class="value">{{ $invoiceNumber }}</span>
            </div>
            <div class="info-row">
                <span class="label">Date de facture :</span>
                <span class="value">{{ $invoiceDate }}</span>
            </div>
            <div class="info-row">
                <span class="label">Proposition # :</span>
                <span class="value">{{ $proposal->id }}</span>
            </div>
            <div class="info-row">
                <span class="label">Demande # :</span>
                <span class="value">{{ $request->id }}</span>
            </div>
        </div>
    </div>

    <div class="festival-info">
        <div class="section-title">Festival sélectionné</div>
        <div class="info-row">
            <span class="label">Nom :</span>
            <span class="value">{{ $festival->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Dates :</span>
            <span class="value">{{ $festival->start_date->format('d/m/Y') }} -
                {{ $festival->end_date->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Lieu :</span>
            <span class="value">{{ $festival->location }}, {{ $festival->region }}</span>
        </div>
    </div>

    <div class="section-title">Détails de la demande</div>
    <div class="info-row">
        <span class="label">Dates de voyage :</span>
        <span class="value">{{ $request->date_start->format('d/m/Y') }} -
            {{ $request->date_end->format('d/m/Y') }}</span>
    </div>
    <div class="info-row">
        <span class="label">Région :</span>
        <span class="value">{{ $request->region }}</span>
    </div>
    <div class="info-row">
        <span class="label">Nombre de personnes :</span>
        <span class="value">{{ $request->people_count }}</span>
    </div>
    <div class="info-row">
        <span class="label">Budget :</span>
        <span class="value">{{ number_format($request->budget, 2, ',', ' ') }} €</span>
    </div>

    <div class="section-title">Détail des prestations</div>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Prix TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposalDetails as $detail)
                <tr>
                    <td>{{ $detail->name }}</td>
                    <td style="text-align: right;">{{ number_format($detail->price, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-amount">
            Total TTC : {{ number_format($total, 2, ',', ' ') }} €
        </div>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>GROOVE NOMAD - Votre spécialiste des voyages festivaliers</p>
    </div>

    <!-- Page 2: Réponse IA -->
    <div class="page-break">
        <div class="header">
            <div class="logo">GROOVE NOMAD</div>
            <div>Proposition détaillée - Proposition #{{ $proposal->id }}</div>
        </div>

        <div class="ai-response">
            <h3>Proposition de séjour personnalisée</h3>
            <div class="ai-response-content">
                {!! Str::markdown($proposal->response_text) !!}
            </div>
        </div>

        <div class="footer">
            <p>Cette proposition a été générée par notre IA spécialisée en voyages festivaliers</p>
            <p>GROOVE NOMAD - Votre spécialiste des voyages festivaliers</p>
        </div>
    </div>
</body>

</html>
