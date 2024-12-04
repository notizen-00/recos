@php use Carbon\Carbon; @endphp
<style>
    @page {
        header: page-header;
        footer: page-footer;
    }

    .label-info {
        width: 80px;
    }

    .ttd tr td {
        text-align: center;
        padding-bottom: 5px;
        padding-top: 5px;
    }
</style>

<htmlpageheader name="page-header">
    <table style="width: 100%; margin-top:20px; vertical-align: bottom; font-family: arial; font-size: 22pt; color: #000000;  ">

        <tr>
            <td style="width: 9%;text-align: left;"><img height="90" width="250"></td>
            <td style="width: 33%;margin-top:10px; text-align: left;"><img height="110" width="260" src="{{ public_path('assets/img/logornm.png') }}"/></td>
            <td style="width: 58%;margin-top:10px; text-align: right; color: #004b8c; " height="80"> <b>{{ strtoupper($mail->sub_type_name) }}</b><br><br></td>
            <td style="width: 9%;text-align: right;"> </td>

        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="page-footer">
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

<div style="margin: 10px 5px 10px 50px">
    <table>
        <tr>
            <td colspan="3">Jember, {{ Carbon::create($mail->sign_date)->locale('id')->isoFormat('D MMMM Y')  }}</td>
        </tr>
        <tr>
            <td class="label-info">Nomor</td>
            <td>:</td>
            <td>{{ $mail->full_number }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>Kepada</td>
            <td>:</td>
            <td>{{ $mail->outgoingRecipients->pluck('title')->implode(', ') }}</td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>:</td>
            <td>{{ $mail->department_title }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>{{ $mail->attachment }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>{{ $mail->subject }}</td>
        </tr>
    </table>

    <div  style="margin-top:25px">
        {!! $mail->content !!}
    </div>

    <table style="margin-top:25px" class="ttd">
        <tr>
            <td ><strong>{{ $mail->department_title }},</strong></td>
        </tr>
        <tr>
            <td >
                <barcode code="{{ route('export.tte', ['outgoing', $mail->id]) }}" type="QR" disableborder="1" size="0.9" />
            </td>
        </tr>
        <tr>
            <td><strong>
                <u>
                    {{ $mail->user_name }}
                </u>
                </strong></td>
        </tr>
    </table>

</div>





