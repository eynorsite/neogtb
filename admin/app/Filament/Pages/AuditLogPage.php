<?php

namespace App\Filament\Pages;

use App\Models\AdminActivityLog;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditLogPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Système';

    protected static ?string $navigationLabel = 'Journal d\'activité';

    protected static ?string $title = 'Journal d\'activité';

    protected static ?int $navigationSort = 95;

    protected string $view = 'filament.pages.audit-log';

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && $admin->isAdmin();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AdminActivityLog::query()->with('admin'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('action')
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                        'info' => fn ($state) => in_array($state, ['login', 'logout']),
                    ]),

                Tables\Columns\TextColumn::make('model_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('model_id')
                    ->label('ID')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'created' => 'Création',
                        'updated' => 'Modification',
                        'deleted' => 'Suppression',
                        'login' => 'Connexion',
                        'logout' => 'Déconnexion',
                    ]),

                Tables\Filters\SelectFilter::make('admin_id')
                    ->label('Admin')
                    ->relationship('admin', 'name'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('Du'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.pages.audit-log-detail', ['record' => $record])),
            ])
            ->paginated([25, 50, 100]);
    }
}
