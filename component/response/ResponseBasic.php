<?php

namespace component\response;

class ResponseBasic
{
    public function __construct(array $info = [])
    {
        foreach ($info as $key => $value) {
            if((new \ReflectionClass(static::class))->hasProperty($key) ) {
                $this->$key = $value;
            }
        }
    }
}
