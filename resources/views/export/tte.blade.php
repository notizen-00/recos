
<html>
<head>

    <title>Ekspor Tanda Tangan Elektronik {{ $title }}</title>

</head>

<body>
<style>
    h1,
    h3,
    h5,
    h6 {
        text-align: center;
        padding-right: 200px;
    }
    @page {
        header: page-header;
        footer: page-footer;
    }
   /* @page :right {

        background:url('{{ public_path('assets/img/garis1.png')  }}') no-repeat left bottom cover;
    }*/
    .header {
        background-position-x: left;
        text-align: center; /* Tengahkan teks di header */
        margin-bottom: 20px;
    }
    .header-img {
        width: 150px; /* Perkecil ukuran logo */
        margin-right: 20px; /* Tambah jarak antara logo dan teks */
        vertical-align: middle; /* Menjaga logo agar tetap berada di tengah vertikal */
        position: absolute; /* Gunakan posisi absolut */
        left: 20px; /* Atur posisi dari kiri kontainer */
        top: 18px; /* Atur posisi dari atas kontainer */
    }
    .header div {
        display: inline-block;
        vertical-align: middle; /* Menjaga teks agar tetap berada di tengah vertikal */
        text-align: center; /* Tetapkan teks kembali ke kiri */
        margin-top: 15px;
    }
    .header p {
        margin: 2px 0; /* Perkecil margin antara paragraf */
    }

    .row {
        margin-top: 20px;
    }

    .keclogo {
        font-size: 24px;
        font-size: 3vw;
    }

    .kablogo {
        font-size: 2vw;
    }

    .alamatlogo {
        font-size: 1.5vw;
    }

    .kodeposlogo {
        font-size: 1.7vw;
    }

    #tls {
        text-align: right;
    }

    .alamat-tujuan {
        margin-left: 50%;
    }

    .garis1 {
        border-top: 3px solid black;
        height: 2px;
        border-bottom: 1px solid black;
    }

    #logo {
        margin: auto;
        margin-left: 50%;
        margin-right: auto;
    }

    #tempat-tgl {
        margin-left: 120px;
    }

    #camat {
        text-align: center;
    }

    #nama-camat {
        margin-top: 100px;
        text-align: center;
    }

    #img {
        display: flex;
    }

    .test > img {
        width: 70px;
    }
</style>
<htmlpageheader name="page-header">
   <table style="vertical-align: bottom; font-family: arial; margin: -3px; padding-top: -100px;
    font-size: 10pt; color: #000000;width: 100%  ">
        <tr style=" margin: 0; padding: 0;">

            <td style="text-align: left"><img height="2400" width="1" src="{{ public_path('assets/img/garis1.png') }}"/></td>
        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="page-footer">
   {{-- <img style="height: 2400px;margin-top: -20px" src="{{ public_path('assets/img/garis1.png') }}"/>
--}}

    <table style="vertical-align: bottom; font-family: arial; margin: -3px;font-size: 10pt; color: #000000;width: 100%  ">
        <tr>
            <td style="text-align: left"><img height="2400" width="1" style="margin-top: -3px" src="{{ public_path('assets/img/garis1.png') }}"/></td>
            <td style="vertical-align: bottom; text-align: left; padding-bottom: 20px">
            <b>PT Rolas Nusantara Medika</b><br> Jln. Gajah Mada No. 15 Jember <br>Jawa Timur 68133</br><br>T/F : (0331) 485926</br><br>Email: info@rolasmedika.co.id</br>
            </td>
            <td style="text-align: right;"><img height="220" width="210" src="{{ public_path('assets/img/ihcc.png') }}"/></td>
        </tr>
    </table>
</htmlpagefooter>

<div style="margin: 10px 5px 10px 20px">

    <div class="header">
        <img class="header-img" src="{{ public_path('assets/img/logornm.png') }}" alt="IHC Logo">
     {{--   <img src="#" alt="IHC Logo">--}}
        <div>
            <p><strong>PT ROLAS NUSANTARA MEDIKA</strong></p>
            <p>Jl. Gajah Mada 15 Jember</p>
            <p>Telepon (0331) 485926, Fax (0331) 485926</p>
            <p>Website : rolasmedika.com</p>
        </div>
    </div>

    <div class="container">
        <hr class="garis1" />
        <div id="alamat" class="row">
            <div id="lampiran" class="col-md-6">
                Nomor :
                {{ Carbon\Carbon::parse($date)->isoFormat('MMYYYYDD') }} / {{ $id }} / {{ Carbon\Carbon::parse($date)->isoFormat('Y') }}
                <br />
                Perihal : E-Sign {{ ucwords($perihal) }} {{ ucwords($title) }}
            </div>
            <div id="tgl-srt" class="col-md-6">
                <p id="tls">Jember,
                    {{ Carbon\Carbon::parse($date)->isoFormat('DD/MM/Y') }}
                </p>
            </div>
        </div>
        <div id="pembuka">Menindak lanjuti
            {{ ucwords($title) }} dengan surat Nomor :
            {{ Carbon\Carbon::parse($date)->isoFormat('MMYYYYDD') }} / {{ $id }} / {{ Carbon\Carbon::parse($date)->isoFormat('Y') }}
            perihal tanda tangan elektronik menyatakan dengan benar dan sah bahwa {{ strtolower($perihal) }} tersebut telah disetujui
            dan ditanda tangani oleh:
        </div>
        <div id="tempat-tgl">
            <table>
                <tr>
                    <td>Nama</td>
                    <td><span style="margin-left: 5px; margin-right: 5px">:</span> </td>
                    <td> {{ $senior_name }}</td>
                </tr>
                <tr>
                    <td>Sebagai</td>
                    <td><span style="margin-left: 5px; margin-right: 5px">:</span> </td>
                    <td> {{ $senior_position }}</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td><span style="margin-left: 5px; margin-right: 5px">:</span> </td>
                    <td> {{ ucwords($title) }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><span style="margin-left: 5px; margin-right: 5px">:</span> </td>
                    <td> {{ (Carbon\Carbon::parse($date)->isoFormat('dddd')) }} ,
                        {{ Carbon\Carbon::parse($date)->isoFormat('DD') }}
                        {{ (Carbon\Carbon::parse($date)->isoFormat('MMM')) }}
                        {{ Carbon\Carbon::parse($date)->isoFormat('Y') }}
                        {{ Carbon\Carbon::now()->isoFormat('HH:mm') }} WIB</td>
                </tr>
            </table>
        </div>
        <div id="penutup">Demikian dokumen tanda tangan elektronik ini dibuat untuk kepentingan pengesahan.</div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div id="ttd" class="col-md-6" style="margin-top:100px;padding-left: 400px">
                    <div>
                        <p id="camat"><strong>{{ $signer_position }}</strong></p>
                        <div id="nama-camat"><strong><u>
                                    {{ $signer_name }}
                                </u></strong><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
