<?php

namespace App\Filament\Widgets;

use App\Models\AdminActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivity extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Activité récente';

    public function table(Table $table): Table
    {
        return $table
            ->query(AdminActivityLog::query()->with('admin')->latest('created_at')->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->since(),

                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin'),

                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ]),

                Tables\Columns\TextColumn::make('model_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '—'),
            ])
            ->paginated(false);
    }
}
