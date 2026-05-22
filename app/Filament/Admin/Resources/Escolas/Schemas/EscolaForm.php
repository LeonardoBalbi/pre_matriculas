<?php

namespace App\Filament\Admin\Resources\Escolas\Schemas;

use App\Models\Bairro;
use App\Models\Distrito;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class EscolaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('escola_nome')
                    ->label('Nome da Escola'),
                TextInput::make('escola_endereco')
                    ->label('Endereço'),
                FileUpload::make('escola_foto')
                    ->label('Foto da unidade escolar')
                    ->helperText('Use JPG, PNG ou WEBP. Fotos grandes serao otimizadas antes do envio para carregar melhor na pagina inicial.')
                    ->disk('public')
                    ->directory('escolas')
                    ->visibility('public')
                    ->afterStateHydrated(function (FileUpload $component, ?string $state): void {
                        if ($state && ! Storage::disk('public')->exists($state)) {
                            $component->state(null);
                        }
                    })
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatioOptions([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->automaticallyResizeImagesMode('contain')
                    ->automaticallyResizeImagesToWidth('1600')
                    ->automaticallyUpscaleImagesWhenResizing(false)
                    ->imagePreviewHeight('180')
                    ->panelAspectRatio('16:9')
                    ->panelLayout('integrated')
                    ->maxSize(8192)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->downloadable()
                    ->openable()
                    ->nullable(),
                Select::make('escola_bairro_id')
                    ->label('Bairro')
                    ->options(Bairro::all()->pluck('escola_bairro_id', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('escola_distrito_id')
                    ->label('Distrito')
                    ->options(Distrito::all()->pluck('distrito', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('escola_vagas')
                    ->numeric(),
                TextInput::make('escola_vagas_especiais')
                    ->numeric(),
                TextInput::make('escola_ano_leitivo'),
                Select::make('escola_status')
                    ->options(['ativa' => 'Ativa', 'inativa' => 'Inativa']),
            ]);
    }
}
