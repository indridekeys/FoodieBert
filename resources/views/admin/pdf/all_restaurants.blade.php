<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
        
        .header-table { width: 100%; border-bottom: 3px solid #D4AF37; margin-bottom: 30px; }
        .header-title { color: #001f3f; font-size: 24px; font-weight: bold; }
        .header-meta { text-align: right; color: #666; font-size: 12px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        
        /* Navy Blue & Gold Header */
        th { background-color: #001f3f; color: #D4AF37; padding: 12px 10px; text-align: left; text-transform: uppercase; border-right: 1px solid #002a54; }
        
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        /* Row Highlighting */
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        .matricule-cell { font-family: monospace; font-weight: bold; color: #001f3f; }
        .name-cell { font-weight: bold; font-size: 12px; }
        
        /* Status Colors */
        .status-open { color: #10b981; font-weight: bold; }
        .status-closed { color: #ff6b6b; font-weight: bold; } /* Light Red */

        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 9px; color: #D4AF37; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-title" style="border:none; padding:0;">Restaurant Registry Master Report</td>
            <td class="header-meta" style="border:none; padding:0;">
                Generated: {{ date('d/m/Y H:i') }}<br>
                Records: {{ count($restaurants) }} Total
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="15%">Matricule</th>
                <th width="30%">Establishment Name</th>
                <th width="15%">Category</th>
                <th width="20%">Owner</th>
                <th width="10%">Status</th>
                <th width="10%">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $res)
            <tr>
                <td class="matricule-cell">{{ $res->matricule }}</td>
                <td class="name-cell">{{ $res->name }}</td>
                <td>{{ $res->category }}</td>
                <td>{{ $res->owner_name }}</td>
                <td class="{{ $res->status === 'open' ? 'status-open' : 'status-closed' }}">
                    {{ strtoupper($res->status) }}
                </td>
                <td>{{ $res->created_at ? $res->created_at->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        BERT-ADM-LOG-{{ date('Ymd') }} | Internal Use Only
    </div>
</body>
</html>