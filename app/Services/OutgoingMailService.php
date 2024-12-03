<?php
namespace App\Services;

use App\Models\Classification;
use App\Models\OrgSubject;
use App\Models\Priority;
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
        $priority = Priority::all();
        $classification = Classification::all();
        $orgSubjects = OrgSubject::all();
        $detail_department = User::with('detail_department')->get();

        // Assuming the `fetch_sign_by_bod` method is available within this class or elsewhere.
        $detail_department_sign = $this->fetchSignByBod($sub_type);

        return [
            'sub_type' => $sub_type,
            'priority' => $priority,
            'classification' => $classification,
            'orgSubjects' => $orgSubjects,
            'detail_department' => $detail_department,
            'detail_department_sign' => $detail_department_sign,
        ];
    }

    private function fetchSignByBod($subType)
    {
        // Implement logic to fetch sign by bod, for example:
        // return $subType->bod->signatures; (assuming this relationship exists)
    }
}
