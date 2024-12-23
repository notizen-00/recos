<?php
namespace App\Services;

use App\Models\OutgoingMail;
use App\Models\SubTypes;
use App\Models\User;

class LetterService
{
    protected int $subTypeId;

    protected SubTypes $subType;

    protected $sender;

    protected $outgoing_mail;

    protected $sign_user;

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
}
