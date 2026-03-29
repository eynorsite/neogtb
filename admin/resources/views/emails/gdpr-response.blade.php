<x-mail::message>
# Bonjour {{ $gdprRequest->name }},

Nous avons traité votre demande RGPD de type **{{ $gdprRequest->getTypeLabel() }}** reçue le {{ $gdprRequest->created_at->format('d/m/Y') }}.

---

{!! nl2br(e($gdprRequest->response_content)) !!}

---

Conformément au RGPD, vous pouvez à tout moment exercer vos droits en nous contactant.

Cordialement,
**Le responsable RGPD — NeoGTB**

<x-mail::button :url="'https://neogtb.fr/mes-droits-rgpd'">
Exercer mes droits
</x-mail::button>

<small>EYNOR (NeoGTB) — Rue Aimé Césaire, 33320 Eysines — rgpd@neogtb.fr</small>
</x-mail::message>
