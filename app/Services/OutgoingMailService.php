<?php
namespace App\Services;

use App\Models\OutgoingMail;
use App\Models\SubTypes;
use App\Models\User;

class OutgoingMailService
{
    protected $subTypeId;

    public function __construct(string $subTypeId)
    {

        $this->subTypeId = $subTypeId;
    }

    public function fetchDetails()
    {
        $sub_type = SubTypes::findOrFail($this->subTypeId);
        $detail_department = User::with('detail_department')->get();

        $detail_department_sign = $this->fetchSignByBod($this->subTypeId);

        return [
            'sub_type' => $sub_type,
            'detail_department' => $detail_department,
            'detail_department_sign' => $detail_department_sign,
        ];
    }

    public static function fetchSignByBod()
    {

    }

    public function get_nomor_surat()
    {
        $latest_mail = OutgoingMail::where('sub_type_id', $this->subTypeId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$latest_mail) {
            return 1;
        }

        return $latest_mail->no + 1;
    }

    public function generate_nomor_surat($kode = '')
    {
        $subtype = SubTypes::findOrFail($this->subTypeId);

        $kode_surat = $subtype->letter_format;
        if ($kode == '') {
            return $kode_surat . '-' . $this->get_nomor_surat() . '/RNM000000/' . date('Y') . '-SO';
        } else {
            if ($kode == 'get_kode') {
                return $kode_surat;
            } else {
                return '';
            }
        }

    }
}
