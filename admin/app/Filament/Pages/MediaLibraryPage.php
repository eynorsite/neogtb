<?php

namespace App\Filament\Pages;

use App\Models\Media;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MediaLibraryPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Mon site';

    protected static ?string $navigationLabel = 'Médiathèque';

    protected static ?string $title = 'Médiathèque';

    protected static ?int $navigationSort = 15;

    protected string $view = 'filament.pages.media-library';

    public function table(Table $table): Table
    {
        return $table
            ->query(Media::query()->with('uploader'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Aperçu')
                    ->disk('public')
                    ->width(60)
                    ->height(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Type')
                    ->badge(),

                Tables\Columns\TextColumn::make('size_for_humans')
                    ->label('Taille'),

                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Uploadé par'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('mime_type')
                    ->label('Type')
                    ->options(fn () => Media::distinct()->pluck('mime_type', 'mime_type')->toArray()),
            ])
            ->actions([
                \Filament\Actions\Action::make('copyUrl')
                    ->label('Copier URL')
                    ->icon('heroicon-o-clipboard')
                    ->action(function ($record) {
                        // URL copying handled via JS in the frontend
                    }),
                \Filament\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        Storage::disk($record->disk)->delete($record->path);
                    }),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make()
                    ->before(function ($records) {
                        foreach ($records as $record) {
                            Storage::disk($record->disk)->delete($record->path);
                        }
                    }),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('upload')
                    ->label('Uploader un fichier')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        \Filament\Forms\Components\FileUpload::make('files')
                            ->label('Fichiers')
                            ->multiple()
                            ->directory('media')
                            ->maxSize(10240)
                            ->acceptedFileTypes([
                                'image/jpeg', 'image/png', 'image/webp', 'image/gif',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ]),
                    ])
                    ->action(function (array $data) {
                        if (! empty($data['files'])) {
                            foreach ((array) $data['files'] as $path) {
                                $disk = Storage::disk('public');
                                $fullPath = $disk->path($path);

                                if (file_exists($fullPath)) {
                                    Media::create([
                                        'name' => pathinfo($path, PATHINFO_FILENAME),
                                        'file_name' => basename($path),
                                        'mime_type' => mime_content_type($fullPath),
                                        'path' => $path,
                                        'disk' => 'public',
                                        'size' => filesize($fullPath),
                                        'uploaded_by' => auth()->guard('admin')->id(),
                                    ]);
                                }
                            }
                        }
                    }),
            ]);
    }
}
