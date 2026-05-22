<?php

namespace Rhylton\Escolas;

use Laravel\Nova\Fields\Field;
use App\Models\Escola;

class Escolas extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'escolas';

    // public function __construct($name, $attribute = null, $resolveCallback = null)
    // {
    //     parent::__construct($name, $attribute, $resolveCallback);

    //     $this->resolveUsing(function ($value) {
    //         $escola = Escola::where(['id' => $value])->first();
    //         return $escola->escola_nome ?? null;
    //     });
    // }
    
}
