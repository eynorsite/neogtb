<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Instantané d'une page (table page_contents) pris AVANT chaque enregistrement,
 * pour permettre un retour arrière ("Annuler ma dernière modification").
 *
 * Table append-only : on ne met jamais à jour une révision (UPDATED_AT désactivé).
 * Le snapshot est une map { page_content.id => value } couvrant toute la page,
 * les valeurs nulles incluses.
 */
class ContentRevision extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['batch_id', 'page', 'snapshot', 'created_by'];

    protected function casts(): array
    {
        return [
            'snapshot' => 'array',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
