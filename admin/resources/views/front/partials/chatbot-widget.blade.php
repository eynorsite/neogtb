{{-- Chatbot widget NeoGTB — chargé côté serveur uniquement si activé --}}
@php
    $chatbotEnabled = \App\Models\ChatbotSetting::current()->enabled;
@endphp

@if($chatbotEnabled)
<div
    id="neogtb-chatbot"
    x-data="neogtbChatbot"
    x-init="boot()"
    x-cloak
    class="fixed z-[9999]"
    :class="position === 'bottom-left' ? 'bottom-4 left-4' : 'bottom-4 right-4'"
>
    {{-- Bouton flottant --}}
    <button
        type="button"
        x-show="!open"
        x-on:click="openChat()"
        class="group flex items-center gap-2 rounded-full px-4 py-3 text-white shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
        :style="'background-color: ' + color + '; --tw-ring-color: ' + color"
        aria-label="Ouvrir l'assistant NeoGTB"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span class="text-sm font-medium" x-text="title"></span>
    </button>

    {{-- Panneau --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="w-[min(380px,calc(100vw-2rem))] h-[min(580px,calc(100vh-2rem))] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200"
        role="dialog"
        aria-label="Assistant NeoGTB"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 text-white" :style="'background-color: ' + color">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-semibold leading-tight" x-text="title"></div>
                    <div class="text-xs opacity-80 leading-tight" x-text="subtitle"></div>
                </div>
            </div>
            <button type="button" x-on:click="open = false" aria-label="Fermer" class="rounded-full p-1 hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Consentement RGPD --}}
        <template x-if="!consentGiven && requireConsent">
            <div class="flex-1 overflow-y-auto p-4 flex flex-col justify-center">
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-gray-700">
                    <p x-text="consentText" class="leading-relaxed"></p>
                    <div class="mt-3 flex flex-col gap-2">
                        <button
                            type="button"
                            x-on:click="acceptConsent()"
                            class="w-full px-4 py-2 rounded-lg text-white font-medium text-sm hover:opacity-90"
                            :style="'background-color: ' + color"
                        >
                            J'accepte et je continue
                        </button>
                        <a href="/politique-de-confidentialite" target="_blank" class="text-xs text-center text-gray-500 underline hover:text-gray-700">
                            Politique de confidentialité
                        </a>
                    </div>
                </div>
            </div>
        </template>

        {{-- Zone messages --}}
        <template x-if="consentGiven || !requireConsent">
            <div class="flex-1 overflow-y-auto p-4 space-y-3" x-ref="messagesEl">
                {{-- Welcome --}}
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" :style="'background-color: ' + color">N</div>
                    <div class="bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-800 max-w-[85%]" x-text="welcomeMessage"></div>
                </div>

                {{-- Suggestions --}}
                <template x-if="messages.length === 0 && suggestions.length > 0">
                    <div class="flex flex-wrap gap-2 pl-9">
                        <template x-for="s in suggestions" :key="s">
                            <button
                                type="button"
                                x-on:click="askSuggestion(s)"
                                class="text-xs px-3 py-1.5 rounded-full border border-gray-300 text-gray-700 hover:border-gray-400 hover:bg-gray-50"
                                x-text="s"
                            ></button>
                        </template>
                    </div>
                </template>

                {{-- Historique --}}
                <template x-for="(msg, i) in messages" :key="i">
                    <div class="flex gap-2" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                        <div
                            class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                            :class="msg.role === 'user' ? 'bg-gray-200 text-gray-600' : 'text-white'"
                            :style="msg.role === 'user' ? '' : 'background-color: ' + color"
                            x-text="msg.role === 'user' ? 'V' : 'N'"
                        ></div>
                        <div
                            class="rounded-lg px-3 py-2 text-sm max-w-[85%] whitespace-pre-wrap"
                            :class="msg.role === 'user' ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-800'"
                            x-text="msg.content"
                        ></div>
                    </div>
                </template>

                {{-- Indicateur de frappe --}}
                <template x-if="isStreaming && (messages.length === 0 || messages[messages.length-1].role === 'user')">
                    <div class="flex gap-2">
                        <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" :style="'background-color: ' + color">N</div>
                        <div class="bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-500">
                            <span class="inline-flex gap-1">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </span>
                        </div>
                    </div>
                </template>

                {{-- Erreur --}}
                <template x-if="errorMessage">
                    <div class="bg-red-50 border border-red-200 rounded-lg px-3 py-2 text-xs text-red-700" x-text="errorMessage"></div>
                </template>
            </div>
        </template>

        {{-- Input --}}
        <template x-if="consentGiven || !requireConsent">
            <form
                x-on:submit.prevent="send()"
                class="border-t border-gray-200 p-3 flex items-end gap-2 bg-white"
            >
                <textarea
                    x-ref="input"
                    x-model="inputText"
                    x-on:keydown.enter.prevent="if(!$event.shiftKey) send()"
                    rows="1"
                    placeholder="Posez votre question…"
                    :disabled="isStreaming"
                    class="flex-1 resize-none rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 disabled:opacity-60"
                ></textarea>
                <button
                    type="submit"
                    :disabled="!inputText.trim() || isStreaming"
                    class="p-2 rounded-lg text-white disabled:opacity-50 disabled:cursor-not-allowed hover:opacity-90"
                    :style="'background-color: ' + color"
                    aria-label="Envoyer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                </button>
            </form>
        </template>

        {{-- Capture lead — apparaît après 1 user + 1 assistant --}}
        <template x-if="(consentGiven || !requireConsent) && messages.length >= 2 && !leadDismissed && !leadSubmitted">
            <div class="border-t border-gray-200 bg-gray-50 px-3 py-2.5">
                {{-- Bouton subtil pour ouvrir le formulaire --}}
                <template x-if="!leadFormVisible">
                    <div class="flex items-center justify-between gap-2">
                        <button
                            type="button"
                            x-on:click="showLeadForm()"
                            class="flex items-center gap-1.5 text-xs font-medium hover:underline focus:outline-none"
                            :style="'color: ' + color"
                            aria-label="Demander à être rappelé par email"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>Demander un rappel</span>
                        </button>
                        <button
                            type="button"
                            x-on:click="leadDismissed = true"
                            aria-label="Masquer la proposition de rappel"
                            class="rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-600 focus:outline-none"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>

                {{-- Formulaire ouvert --}}
                <template x-if="leadFormVisible">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs text-gray-700 leading-snug">Vous voulez qu'on vous rappelle pour approfondir ?</p>
                            <button
                                type="button"
                                x-on:click="leadFormVisible = false; leadDismissed = true"
                                aria-label="Fermer le formulaire de rappel"
                                class="flex-shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-600 focus:outline-none"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form x-on:submit.prevent="submitLead()" class="flex items-center gap-2">
                            <label for="neogtb-lead-email" class="sr-only">Votre adresse email</label>
                            <input
                                id="neogtb-lead-email"
                                type="email"
                                x-model="leadEmail"
                                required
                                placeholder="votre@email.fr"
                                autocomplete="email"
                                :disabled="leadSubmitting"
                                class="flex-1 min-w-0 rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs focus:border-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 disabled:opacity-60"
                            />
                            <button
                                type="submit"
                                :disabled="leadSubmitting || !leadEmail.trim()"
                                class="rounded-lg px-3 py-1.5 text-xs font-medium text-white transition hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed"
                                :style="'background-color: ' + color"
                                aria-label="Envoyer mon email pour être rappelé"
                            >
                                <span x-show="!leadSubmitting">Laisser mon email</span>
                                <span x-show="leadSubmitting">…</span>
                            </button>
                        </form>
                        <template x-if="leadError">
                            <p class="text-[11px] text-red-600" x-text="leadError"></p>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Confirmation lead --}}
        <template x-if="leadSubmitted">
            <div class="border-t border-gray-200 bg-gray-50 px-3 py-2.5">
                <p class="text-xs text-gray-700 text-center">Merci, nous vous recontactons sous 48 h.</p>
            </div>
        </template>

        {{-- Pied --}}
        <div class="px-3 py-1.5 text-[10px] text-gray-400 border-t border-gray-100 text-center bg-gray-50">
            Propulsé par Claude · Conversations conservées 30 j
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('neogtbChatbot', () => ({
            open: false,
            enabled: false,
            title: 'Assistant NeoGTB',
            subtitle: 'Conseil GTB & décret BACS',
            color: '#0E7490',
            position: 'bottom-right',
            welcomeMessage: '',
            suggestions: [],
            requireConsent: true,
            consentText: '',
            consentGiven: false,
            messages: [],
            inputText: '',
            isStreaming: false,
            errorMessage: '',
            sessionId: null,
            fallbackUrl: '/contact',
            leadEmail: '',
            leadName: '',
            leadFormVisible: false,
            leadSubmitted: false,
            leadDismissed: false,
            leadSubmitting: false,
            leadError: '',

            // Ouvre le panneau et focus l'input (build CSP : pas de fonction fléchée en directive)
            openChat() {
                this.open = true;
                this.$nextTick(() => this.$refs.input?.focus());
            },

            async boot() {
                try {
                    const res = await fetch('/api/chatbot/bootstrap', { credentials: 'same-origin' });
                    const data = await res.json();
                    if (!data.enabled) return;
                    this.enabled = true;
                    this.title = data.title || this.title;
                    this.subtitle = data.subtitle || this.subtitle;
                    this.color = data.color || this.color;
                    this.position = data.position || this.position;
                    this.welcomeMessage = data.welcome_message || '';
                    this.suggestions = data.suggested_questions || [];
                    this.requireConsent = !!data.require_consent;
                    this.consentText = data.consent_text || '';
                    this.fallbackUrl = data.fallback_url || '/contact';
                    this.consentGiven = this.getCookie('neogtb_chat_consent') === '1';
                } catch (e) {
                    // silencieux
                }
            },

            async acceptConsent() {
                try {
                    await fetch('/api/chatbot/consent', {
                        method: 'POST',
                        headers: this.headers(),
                        credentials: 'same-origin',
                    });
                    this.consentGiven = true;
                    this.setCookie('neogtb_chat_consent', '1', 30);
                    this.$nextTick(() => this.$refs.input?.focus());
                } catch (e) {
                    this.errorMessage = 'Impossible d\'enregistrer le consentement.';
                }
            },

            askSuggestion(text) {
                this.inputText = text;
                this.send();
            },

            async send() {
                const text = this.inputText.trim();
                if (!text || this.isStreaming) return;

                this.errorMessage = '';
                this.messages.push({ role: 'user', content: text });
                this.inputText = '';
                this.isStreaming = true;
                this.scrollToBottom();

                let assistantMsg = null;

                try {
                    const res = await fetch('/api/chatbot/stream', {
                        method: 'POST',
                        headers: this.headers(),
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            message: text,
                            landing: window.location.pathname,
                        }),
                    });

                    if (!res.ok) {
                        const j = await res.json().catch(() => ({}));
                        const errMap = {
                            'rate_limit_ip': 'Vous avez atteint la limite de messages. Revenez demain ou contactez-nous.',
                            'rate_limit_session': 'Limite atteinte sur cette conversation. Pour aller plus loin, contactez-nous.',
                            'budget_exceeded': 'L\'assistant est temporairement indisponible. Utilisez le formulaire de contact.',
                            'consent_required': 'Merci d\'accepter les conditions avant de discuter.',
                            'invalid_message': 'Message invalide.',
                        };
                        this.errorMessage = errMap[j.error] || 'Une erreur est survenue. Réessayez.';
                        this.isStreaming = false;
                        return;
                    }

                    const reader = res.body.getReader();
                    const decoder = new TextDecoder();
                    let buffer = '';

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;
                        buffer += decoder.decode(value, { stream: true });

                        let pos;
                        while ((pos = buffer.indexOf('\n\n')) !== -1) {
                            const block = buffer.slice(0, pos).trim();
                            buffer = buffer.slice(pos + 2);
                            if (!block.startsWith('data: ')) continue;
                            try {
                                const event = JSON.parse(block.slice(6));
                                if (event.type === 'delta' && event.text) {
                                    if (!assistantMsg) {
                                        assistantMsg = { role: 'assistant', content: '' };
                                        this.messages.push(assistantMsg);
                                    }
                                    assistantMsg.content += event.text;
                                    this.scrollToBottom();
                                }
                            } catch (e) {
                                // ignore parse errors
                            }
                        }
                    }
                } catch (e) {
                    this.errorMessage = 'Connexion interrompue. Réessayez.';
                } finally {
                    this.isStreaming = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.messagesEl;
                    if (el) el.scrollTop = el.scrollHeight;
                });
            },

            headers() {
                return {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
                    'Accept': 'application/json',
                };
            },

            showLeadForm() {
                this.leadFormVisible = true;
                this.leadError = '';
            },

            async submitLead() {
                const email = (this.leadEmail || '').trim();
                if (!email) return;
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!re.test(email)) {
                    this.leadError = 'Email invalide ou erreur serveur';
                    return;
                }

                this.leadSubmitting = true;
                this.leadError = '';

                try {
                    const res = await fetch('/api/chatbot/lead', {
                        method: 'POST',
                        headers: this.headers(),
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            email: email,
                            name: this.leadName || null,
                            note: 'Demande de rappel via widget',
                        }),
                    });

                    if (!res.ok) {
                        this.leadError = 'Email invalide ou erreur serveur';
                        this.leadSubmitting = false;
                        return;
                    }

                    this.leadSubmitted = true;
                    this.leadFormVisible = false;
                } catch (e) {
                    this.leadError = 'Email invalide ou erreur serveur';
                } finally {
                    this.leadSubmitting = false;
                }
            },

            setCookie(name, value, days) {
                const d = new Date();
                d.setTime(d.getTime() + days * 86400000);
                document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/;SameSite=Lax;Secure`;
            },

            getCookie(name) {
                const m = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
                return m ? m.pop() : null;
            },
        }));
    });
</script>
@endif
