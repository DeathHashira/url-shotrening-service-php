<?php

namespace Models;

class Urls extends BaseRepository
{
    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->tableName = 'urls';
    }
}