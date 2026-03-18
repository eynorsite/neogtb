<div class="space-y-4 p-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <span class="text-sm font-medium text-gray-500">Admin</span>
            <p>{{ $record->admin?->name ?? '—' }}</p>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500">Action</span>
            <p>{{ $record->action }}</p>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500">Date</span>
            <p>{{ $record->created_at->format('d/m/Y H:i:s') }}</p>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500">IP</span>
            <p>{{ $record->ip_address ?? '—' }}</p>
        </div>
    </div>

    @if($record->old_values)
        <div>
            <span class="text-sm font-medium text-gray-500">Anciennes valeurs</span>
            <pre class="mt-1 rounded-lg bg-gray-50 p-3 text-sm dark:bg-gray-800">{{ json_encode($record->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endif

    @if($record->new_values)
        <div>
            <span class="text-sm font-medium text-gray-500">Nouvelles valeurs</span>
            <pre class="mt-1 rounded-lg bg-gray-50 p-3 text-sm dark:bg-gray-800">{{ json_encode($record->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endif
</div>
