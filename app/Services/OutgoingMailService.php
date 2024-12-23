<?php
namespace App\Services;

use App\Models\OrgSubject;
use App\Models\OutgoingMail;
use App\Models\SubTypes;
use App\Models\User;

class OutgoingMailService
{
    protected int $subTypeId;

    protected SubTypes $subType;

    protected $sender;

    protected $outgoing_mail;

    protected $sign_user;

    public function __construct(string $subTypeId, string $user_sign_id)
    {

        $this->subTypeId = $subTypeId;

        $this->sender = auth()->user();

        $this->sign_user = User::with('detail_department')->where('id', $user_sign_id);

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

    private function get_org_subject($org_subject)
    {
        $subject = OrgSubject::where('name', $org_subject)->first();

        return $subject->code;
    }

    private function get_kode_organisasi()
    {

        $code = $this->sign_user->detail_department->kode_organisasi;

        if ($code == null) {
            return 'RNM000000';
        } else {
            return $this->sign_user->detail_department->kode_organisasi;
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

    public function generate_nomor_surat($kode = '', $org_subject = null)
    {

        $kode_surat = $this->subType->letter_format;
        $org_kode = $this->get_org_subject($org_subject);
        $kode_organisasi = $this->get_kode_organisasi();

        if ($kode == '') {
            if ($org_subject == null) {
                return $kode_surat . '-' . $this->get_nomor_surat() . '/' . $kode_organisasi . '/' . date('Y') . '-SO';
            } else {
                return $kode_surat . '-' . $this->get_nomor_surat() . '/' . $kode_organisasi . '/' . date('Y') . '-' . $org_kode;
            }
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
