<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                Informations de la conversation
            </x-slot>

            <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <dt class="font-medium text-gray-500">Session ID</dt>
                    <dd class="font-mono text-xs">{{ $record->session_id }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Page d'origine</dt>
                    <dd>{{ $record->referrer_url ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Démarré le</dt>
                    <dd>{{ $record->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Dernière activité</dt>
                    <dd>{{ optional($record->last_activity_at)->format('d/m/Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Messages</dt>
                    <dd>{{ $record->messages_count }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Tokens IN / OUT</dt>
                    <dd>{{ $record->total_tokens_in }} / {{ $record->total_tokens_out }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Coût total</dt>
                    <dd class="font-semibold">{{ number_format($record->total_cost_eur, 6) }} €</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-500">Lead ?</dt>
                    <dd>
                        @if($record->is_lead)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-medium">Oui</span>
                            @if($record->lead_email)
                                — {{ $record->lead_email }}
                            @endif
                        @else
                            <span class="text-gray-400">Non</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Échanges</x-slot>

            <div class="space-y-3">
                @foreach($record->messages as $msg)
                    <div class="flex gap-3 @if($msg->role === 'user') flex-row-reverse @endif">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                            @if($msg->role === 'user') bg-gray-200 text-gray-700 @else bg-cyan-100 text-cyan-800 @endif">
                            {{ $msg->role === 'user' ? 'U' : 'B' }}
                        </div>
                        <div class="max-w-[75%]">
                            <div class="rounded-lg px-3 py-2 text-sm whitespace-pre-wrap
                                @if($msg->role === 'user') bg-gray-100 text-gray-900 @else bg-cyan-50 text-gray-800 border border-cyan-100 @endif">
                                {{ $msg->content }}
                            </div>
                            <div class="mt-1 text-xs text-gray-400 @if($msg->role === 'user') text-right @endif">
                                {{ $msg->created_at->format('H:i') }}
                                @if($msg->role === 'assistant')
                                    · {{ $msg->tokens_out }} tok · {{ number_format($msg->cost_eur, 6) }} € · {{ $msg->latency_ms }} ms
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
