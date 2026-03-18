<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMessages extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Derniers messages';

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactMessage::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'gray' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Sujet')
                    ->limit(40),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu')
                    ->since(),
            ])
            ->paginated(false);
    }
}
