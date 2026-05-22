<?php

namespace App\Filament\Admin\Resources\Vagas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VagasInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('num_edital'),
                TextEntry::make('titulo'),
                TextEntry::make('vaga_ac')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('vaga_pcd')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('vaga_negro')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('vaga_indios')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
