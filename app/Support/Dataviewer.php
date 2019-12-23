<?php

use Illuminate\Support;


trait Dataviewer {


    public function scopeAdvancedFilter($query)
    {
        return $this->process($query, request()->all())
            ->
    }

    public function process($query, $data)
    {

    }
}
