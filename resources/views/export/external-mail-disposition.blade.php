@php use Carbon\Carbon; @endphp
<style>
    @page {
        header: page-header;
        footer: page-footer;
    }

    body {
        font-size: 9pt;
    }

    td {
        padding: 10px; /* Memberi jarak di sekitar cell */
        text-align: center;
    }
</style>

<htmlpageheader name="page-header">
    <table width="100%" style="border-bottom: 1px solid #000; font-size: 12px; text-align: center;">
    </table>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <table width="100%" style="font-size:10pt;font-family: Arial;" cellpadding="20">
        <tr>
            <td width="50%" align="left">Halaman {PAGENO} dari {nbpg}</td>
            <td width="50%" align="right">Printed on: {DATE j/m/Y H:i}</td>
        </tr>
    </table>
</htmlpagefooter>

<p>
<table style="border:1px solid black;width:100%;border-collapse: collapse;" border="1">
    <tr>
        <td colspan="9" style="text-align: center;padding:15px;font-size:12pt;">
            <h4>LEMBAR PENERUS</h4>
            <b>{{ $externalMail->department_title }}</b>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>NO. AGENDA</b>
        </td>
        <td colspan="3">
            <b>DITERIMA TANGGAL</b>
        </td>
        <td colspan="4">
            <b>TINGKAT SURAT</b>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>{{ $externalMail->agenda_number }}</b>
        </td>
        <td colspan="3">
            <b>{{ $externalMail->agenda_date }}</b>
        </td>
        @foreach($listClassification as $lc)
            @if($lc['id'] == $externalMail->classification_id)
                <td style="background-image: url('{{ public_path('assets/img/lingkaran.png') }}');background-image-resize:5;background-repeat:no-repeat;background-position:center;text-align:center;padding-top:10px;padding-right:10px;padding-left:10px;font-weight: bold;">
            @else
                <td>
                    @endif
                    <b>{{ strtoupper(substr($lc['name'], 0, 1)) }}</b>
                </td>
                @endforeach
                @foreach($listPriority as $lp)
                    @if($lp['id'] == $externalMail->priority_id)
                        <td style="background-image: url('{{ public_path('assets/img/lingkaran.png') }}');background-image-resize:5;background-repeat:no-repeat;background-position:center;text-align:center;padding-top:10px;padding-right:10px;padding-left:10px;font-weight: bold;">
                    @else
                        <td>
                            @endif
                            <b>{{ strtoupper(substr($lp['name'], 0, 1)) }}</b>
                        </td>
                        @endforeach
    </tr>
    <tr>
        <td colspan="9" style="text-align:left;font-weight: bold;font-size:10pt;">
            PERIHAL: {{ $externalMail->subject }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:10pt;">
            <b>DITERUSKAN KEPADA</b>
        </td>
        @foreach($listFollowUpTypes as $lf)
            <td text-rotate="90" style="font-size:10pt;">
                <b>{{ strtoupper($lf['name']) }}</b>
            </td>
        @endforeach;
        <td colspan="2">
            <table>
                <tr text-rotate="90">
                    <th>TANGGAL</th>
                    <th>DITERUSKAN</th>
                </tr>
            </table>
        </td>
        <td text-rotate="90" style="font-size:10pt;border:1px solid black">
            <b>PARAF</b>
        </td>
    </tr>
    @foreach($listDepartment as $ld)
        <tr style="font-size:9pt">
            <td style="width:3%;border:1px solid black">{{ $loop->index + 1 }}</td>
            <td style="border:1px solid black;text-align: left;padding-left:3px;padding-right:0px;width:45%;">{{ $ld['title'] }}</td>
            <td style="font-weight:bold;border:1px solid black">
                @php
                    $n = $externalMailDisposition->where('recipient_user_detail_departments_id', $ld['id'])->first();
                    if($n && $n->follow_up_type_id == $listFollowUpTypes[0]['id']){
                        echo 'v';
                    }
                @endphp
            </td>
            <td style="font-weight:bold;border:1px solid black">
                @php
                    $n = $externalMailDisposition->where('recipient_user_detail_departments_id', $ld['id'])->first();
                    if($n && $n->follow_up_type_id == $listFollowUpTypes[1]['id']){
                        echo 'v';
                    }
                @endphp
            </td>
            <td style="font-weight:bold;border:1px solid black">
                @php
                    $n = $externalMailDisposition->where('recipient_user_detail_departments_id', $ld['id'])->first();
                    if($n && $n->follow_up_type_id == $listFollowUpTypes[2]['id']){
                        echo 'v';
                    }
                @endphp
            </td>
            <td style="font-weight:bold;border:1px solid black">
                @php
                    $n = $externalMailDisposition->where('recipient_user_detail_departments_id', $ld['id'])->first();
                    if($n && $n->follow_up_type_id == $listFollowUpTypes[3]['id']){
                        echo 'v';
                    }
                @endphp
            </td>
            <td colspan="2" style="border:1px solid black">
                @php
                    $n = $externalMailDisposition->where('recipient_user_detail_departments_id', $ld['id'])->first();
                    if($n){
                        echo date('Y-m-d', strtotime($n->created_at));
                    }
                @endphp
            </td>
            <td style="border:1px solid black"></td>
        </tr>
    @endforeach
    <tr style="border:1px solid black;">
        <td colspan="9" style="text-align:left;padding:0px;">
            <table>
                <tr>
                    <td style="width:50%;text-align: left;">
                        <b>DISPOSISI:</b><br/>
                        {{ $externalMailDisposition[0]['follow_up_message'] }}<br/><br/>
                        CATATAN:<br/>
                        <ol>
                            <li>Seluruh proses harap melalui sekretariat</li>
                            <li>R=Rahasia; P=Penting; S=Segera; B=Biasa</li>
                        </ol>
                    </td>
                    <td style="padding-left:20%;">
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td style="border:1px solid black;">{{ date('Y-m-d', strtotime($externalMailDisposition[0]['created_at'])) }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">PARAF</td>
                                <td style="border:1px solid black;">TANGGAL</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        </td>
    </tr>
</table>
