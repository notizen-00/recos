<?php
namespace App\Services;

use App\Models\OutgoingMail;
use App\Models\SubTypes;
use App\Models\User;
use App\Models\DetailDepartments;
use App\Models\TrackingOutgoingMail;

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

    private function fetch_sender_detail_department()
    {
        return DetailDepartment::findOrFail($this->sender->detail_department_id);
        
    }

    public function get_send_to_verif()
    {

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


    public function get_nomor_surat()
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
}