<?php

namespace component\response;

class ResponseError extends ResponseBasic
{
    public $status = null;
    public $source;
    public $title = null;
    public $detail;
    
}
