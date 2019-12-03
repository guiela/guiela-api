<?php

namespace App\Modules\Csv;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Collection;

/**
 * ResultWrapper Class
 * 
 * @author Anitche Chisom <anitchec.dev@gmail.com>
 */
class ResultWrapper
{
    /**
     * File header
     *
     * @var array
     */
    protected $header = [];

    /**
     * File records
     *
     * @var array
     */
    protected $records = [];

    /**
     * Set file header
     *
     * @param  array  $header  File header
     *
     * @return  self
     */ 
    public function setHeader(array $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Set file records
     *
     * @param  array|Collection  $records  File records
     *
     * @return  self
     */ 
    public function setRecords($records)
    {
        $this->records = $records;

        return $this;
    }

    public function getResult(): array
    {
        return [
            'header' => $this->header,
            'records' => $this->records
        ];
    }
}
