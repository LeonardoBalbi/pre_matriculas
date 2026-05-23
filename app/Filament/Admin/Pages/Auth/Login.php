<?php

namespace App\Filament\Admin\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getHeading(): string|Htmlable|null
    {
        return 'Area administrativa';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Entre para gerenciar pre-matriculas, unidades escolares e confirmacoes.';
    }
}
