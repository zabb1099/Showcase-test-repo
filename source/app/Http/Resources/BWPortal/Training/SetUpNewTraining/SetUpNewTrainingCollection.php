<?php

namespace App\Http\Resources\BWPortal\Training\SetUpNewTraining;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SetUpNewTrainingCollection extends ResourceCollection
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







