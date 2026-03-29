<x-mail::message>
# Bonjour {{ $message->name }},

Merci pour votre message concernant **« {{ $message->subject }} »**.

---

{!! nl2br(e($message->reply_content)) !!}

---

Cordialement,
**L'équipe NeoGTB**

<x-mail::button :url="'https://neogtb.fr/contact'">
Nous recontacter
</x-mail::button>

<small>Cet email fait suite à votre message envoyé le {{ $message->created_at->format('d/m/Y à H:i') }}.</small>
</x-mail::message>
