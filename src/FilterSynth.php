<?php

namespace LaravelViews;

use LaravelViews\Filters\BaseFilter;
use LaravelViews\Filters\Filter;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class FilterSynth extends Synth {
    public static $key = 'filter';

    static function match($target) {
        return $target instanceof BaseFilter;
    }

    function dehydrate($target, $dehydrateChild) {
        return [serialize($target), []];
    }

    function hydrate($value, $meta, $hydrateChild) {
        $obj = unserialize($value);

        return $obj;
    }

    function set(&$target, $key, $value) {
        $target->$key = $value;
    }
}
