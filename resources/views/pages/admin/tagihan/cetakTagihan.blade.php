<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Tagihan {{ date('F') }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/template/assets/library/bootstrap/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        section {
            font-size: 12px;
        }

        .title-letter{
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <header>
        <table align="center">
            <tr>
                <td style="padding-right:20px;"><img src="{{ public_path('images/logo-sasmita.png') }}" alt="sasmita" width="80px;" height="80px;"></td>
                <td class="text-center" align="center">
                    <h4 style="margin: 0px;">
                        YAYASAN SASMITA JAYA <br>
                        UNIVERSITAS PAMULANG
                    </h4>
                    <p style="margin: 0px; font-size:12px;">
                        Jln. Surya Kencana No.1 Pamulang Barat - Pamulang, Tangerang Selatan, Banten <br>
                        Telp.
                    </p>
                </td>
                <td style="padding-left:20px;"><img src="{{ public_path('images/logo-unpam.png') }}" alt="unpam" width="80px;" height="80px;"></td>
            </tr>
        </table>
    </header>
    <hr>
    <section>
        <h5 class="title-letter text-center" style="text-transform: uppercase;">Surat Tagihan Sewa Kios dan Listrik</h5>
        <p class="text-center" style="text-transform: uppercase; font-size: 16px;">Bulan {{ date('F', strtotime($bulan)) }} Tahun {{ date('Y') }}</p>
    </section>
    <section style="margin-top: 60px;">
        <p class="body-letter">
            Berikut adalah daftar tagihan sewa kios dan listrik :
        </p>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Penyewa</th>
                <th scope="col">Rekening</th>
                <th scope="col">Kode Tagihan</th>
                <th scope="col">Periode</th>
                <th scope="col">Total Tagihan</th>
              </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($dataTagihan as $tagihan)
                <tr>
                    <td>{{ $i++}}</td>
                    <td>{{ $tagihan->SewaKios->User->nama_lengkap }}</td>
                    <td>{{ $tagihan->SewaKios->User->rekening }}</td>
                    <td>{{ $tagihan->kode_tagihan }}</td>
                    <td>{{ date('M Y', strtotime($tagihan->periode)) }}</td>
                    <td>{{ 'Rp '.number_format($tagihan->tagihan_kios - ($tagihan->diskon/100*$tagihan->tagihan_kios)+ $tagihan->tagihan_kwh,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <section>
        <p>
            Demikianlah surat ini dikeluarkan, agar dapat dipergunakan sebaik-baiknya.
        </p>
    </section>
    <section class="signature">
        <table style="float: right; text-align:right;">
            <tr>
                <td>Tangerang Selatan, {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td style="padding-top: 40px; padding-bottom:40px;"></td>
            </tr>
            <tr>
                <td>(<span style="padding-right: 70px; padding-left:70px;"> </span>)</td>
            </tr>
        </table>
    </section>
</body>
</html>
