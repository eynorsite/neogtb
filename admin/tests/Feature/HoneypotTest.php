<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Le champ leurre `_gotcha` était affiché dans quatre vues mais n'était réellement
 * contrôlé que sur deux d'entre elles : sur le générateur CEE et sur le formulaire
 * d'exercice des droits RGPD, il n'était même pas transmis au serveur.
 *
 * Ces tests verrouillent la chaîne complète : champ envoyé → requête rejetée.
 */
class HoneypotTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cee_lead_is_rejected_when_the_decoy_field_is_filled(): void
    {
        $this->postJson('/cee/lead', [
            '_gotcha' => 'bot',
            'email' => 'bot@example.com',
            'consentement_rgpd' => true,
        ])->assertStatus(422)->assertJsonValidationErrors('_gotcha');
    }

    #[Test]
    public function gdpr_request_is_rejected_when_the_decoy_field_is_filled(): void
    {
        $this->postJson('/rgpd/request', [
            '_gotcha' => 'bot',
            'type' => 'access',
            'email' => 'bot@example.com',
            'name' => 'Bot',
        ])->assertStatus(422)->assertJsonValidationErrors('_gotcha');
    }

    #[Test]
    public function an_empty_decoy_field_never_blocks_a_legitimate_visitor(): void
    {
        // Le champ est toujours posté (chaîne vide) par les formulaires : il ne doit
        // en aucun cas déclencher l'erreur de validation.
        $this->postJson('/cee/lead', [
            '_gotcha' => '',
            'email' => 'client@example.com',
            'consentement_rgpd' => true,
        ])->assertJsonMissingValidationErrors('_gotcha');

        $this->postJson('/rgpd/request', [
            '_gotcha' => '',
            'type' => 'access',
            'email' => 'client@example.com',
            'name' => 'Client',
        ])->assertJsonMissingValidationErrors('_gotcha');
    }

    #[Test]
    public function crlf_injection_is_refused_on_the_gdpr_email_field(): void
    {
        // Les demandes RGPD déclenchent un envoi de courriel (GdprResponseMail) :
        // le champ email doit refuser toute tentative d'injection d'en-tête.
        $this->postJson('/rgpd/request', [
            'type' => 'access',
            'email' => "client@example.com\r\nBcc: tiers@example.com",
            'name' => 'Client',
        ])->assertStatus(422)->assertJsonValidationErrors('email');
    }
}
