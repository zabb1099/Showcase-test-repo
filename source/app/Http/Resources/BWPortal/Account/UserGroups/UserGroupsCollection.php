<?php

namespace App\Http\Resources\BWPortal\Account\UserGroups;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserGroupsCollection extends ResourceCollection
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return parent::toArray($request);
    }
}

