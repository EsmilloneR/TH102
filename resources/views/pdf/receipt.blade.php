<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Car Rental Agreement</title>
    <style>
        /* Page Setup for Printing */
        @page {
            size: 8.5in 11in;
            /* Standard Bond Paper Size */
            margin: 0.5in;
            /* Reduced margins to fit content */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            /* Slightly reduced font size for better fit */
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .section {
            margin-bottom: 6px;
        }

        .label {
            font-weight: bold;
            margin-right: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
        }

        .table td {
            padding: 3px;
            vertical-align: top;
        }

        /* Signature Section Fix */
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 10px;
            /* border-top: 1px solid #000; */
            page-break-inside: avoid;
            /* Prevent page break inside signature section */
        }

        .signature .column {
            width: 45%;
            text-align: center;
        }

        /* .signature .column .renter .comaker {
            padding: 100px;
            text-align: center;
        } */

        .signature .column p {
            margin: 10px 0;
        }

        .signature .column .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
        }

        .signature .column .label {
            font-weight: bold;
            margin-top: 10px;
        }

        .signature .column .date {
            font-size: 9px;
            color: #555;
            margin-bottom: 65px;
        }

        /* Container for better layout */
        .container {
            max-width: 100%;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2><span class="text-red-600">Twayne</span> Garage Car Rental</h2>
            <p>Car Rental Agreement Form</p>
        </div>

        <div class="section">
            <table class="table">
                <tr>
                    <td class="label">Renter’s Name:</td>
                    <td>{{ $rental->user->name ?? '________________' }}</td>
                    <td class="label">Age:</td>
                    <td>{{ $rental->user->age ?? '_____' }}</td>
                    <td class="label">Contact No:</td>
                    <td>{{ $rental->user->phone_number ?? '________________' }}</td>
                </tr>
                <tr>
                    <td class="label">Address:</td>
                    <td colspan="5">{{ $rental->user->address ?? '______________________________________' }}</td>
                </tr>
                <tr>
                    <td class="label">Nationality:</td>
                    <td>{{ $rental->user->nationality ?? '_________' }}</td>
                    <td class="label">ID Type:</td>
                    <td>{{ ucwords(Str::replace('_', ' ', $rental->user->id_type)) ?? '_________' }}</td>
                    <td class="label">Date:</td>
                    <td>{{ $rental->date ?? now()->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Time Out:</td>
                    <td colspan="5">{{ $rental->time_out ?? '_________' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p class="label">Co-maker:</p>
            <table class="table">
                <tr>
                    <td class="label">Name:</td>
                    <td>{{ $rental->co_maker->name ?? '________________' }}</td>
                    <td class="label">Age:</td>
                    <td>{{ $rental->co_maker->age ?? '_____' }}</td>
                    <td class="label">Contact No:</td>
                    <td>{{ $rental->co_maker->contact ?? '________________' }}</td>
                </tr>
                <tr>
                    <td class="label">Address:</td>
                    <td colspan="5">{{ $rental->co_maker->address ?? '______________________________________' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">ID Type:</td>
                    <td colspan="5">{{ $rental->co_maker->id_type ?? '_________' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p class="label">Car Details:</p>
            <table class="table">
                <tr>
                    <td class="label">Unit Make:</td>
                    <td>{{ $vehicle->make ?? '_________' }}</td>
                    <td class="label">Model:</td>
                    <td>{{ $vehicle->model ?? '_________' }}</td>
                    <td class="label">Year:</td>
                    <td>{{ $vehicle->year ?? '_____' }}</td>
                </tr>
                <tr>
                    <td class="label">Color:</td>
                    <td>{{ $vehicle->color ?? '_________' }}</td>
                    <td class="label">Plate No:</td>
                    <td>{{ $vehicle->licensed_number ?? '_________' }}</td>
                    <td class="label">Transmission:</td>
                    <td>{{ $vehicle->transmission ?? 'AT/MT' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table class="table">
                <tr>
                    <td class="label">Pickup Location:</td>
                    <td colspan="3">{{ $rental->pickup_location ?? '________________' }}</td>
                </tr>
                <tr>
                    <td class="label">Return Date:</td>
                    <td>{{ $rental->rental_end ? \Carbon\Carbon::parse($rental->rental_end)->format('M d, Y') : '_________' }}
                    </td>
                    <td class="label">Fuel Level:</td>
                    <td>{{ $rental->fuel_level ?? '_________' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p class="label">Trip Type:</p>
            <ul>
                <li>{{ $rental->trip_type == 'pickup' ? '✔' : '___' }} Pick Up & Drop Off only</li>
                <li>{{ $rental->trip_type == 'hours' ? '✔' : '___' }} Hour/s</li>
                <li>{{ $rental->trip_type == 'roundtrip' ? '✔' : '___' }} Round trip only (10hrs max)</li>
                <li>{{ $rental->trip_type == '24hrs' ? '✔' : '___' }} 24 hours</li>
                <li>{{ $rental->trip_type == 'days' ? '✔' : '___' }} Days</li>
                <li>{{ $rental->trip_type == 'weeks' ? '✔' : '___' }} Week/weeks</li>
                <li>{{ $rental->trip_type == 'months' ? '✔' : '___' }} Month/months</li>
            </ul>
        </div>

        <!-- Signature Section -->
        <div class="signature">
            <div class="column renter">
                <div class="signature-line"></div>
                <p class="label">Renter’s Signature</p>
                <p class="date">Date: {{ now()->format('M d, Y') }}</p>
            </div>
            <div class="column comaker">
                <div class="signature-line"></div>
                <p class="label">Co-maker’s Signature</p>
                <p class="date">Date: _____________________</p>
            </div>
        </div>
    </div>
</body>

</html>
