<?php
namespace App\Services;

use App\Models\OutgoingMail;
use App\Models\SubTypes;
use App\Models\User;

class OutgoingMailService
{
    protected int $subTypeId;

    protected SubTypes $subType;

    protected $sender;

    protected $outgoing_mail;

    public function __construct(string $subTypeId)
    {

        $this->subTypeId = $subTypeId;

        $this->sender = auth()->user();

        $this->subType = SubTypes::findOrFail($this->subTypeId);

        $this->outgoing_mail = OutgoingMail::where('sub_type_id', $this->subTypeId);

    }

    public function get_sign_letter_list()
    {

        if ($this->subType->bod && $this->subType->bod != null) {

            $bodArray = explode(',', $this->subType->bod);
            return User::with('detail_department.bod')
                ->whereBodIn($bodArray)
                ->get();
        } else {
            throw new \Exception('Column Bod Kosong');
        }

    }

    private function get_nomor_surat()
    {
        $latest_mail = $this->outgoing_mail
            ->orderBy('id', 'desc')
            ->first();

        if (!$latest_mail) {
            return 1;
        }

        return $latest_mail->no + 1;
    }

    public function generate_nomor_surat($kode = '')
    {

        $kode_surat = $this->subType->letter_format;

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

    public function update_nomor_surat(OutgoingMail $outgoing)
    {
        $data = [
            'no' => $this->get_nomor_surat(),
            'full_number' => $this->generate_nomor_surat(),
            'sign_date' => now()->toDateTimeString(),
        ];

        $outgoing->update($data);
    }
}
