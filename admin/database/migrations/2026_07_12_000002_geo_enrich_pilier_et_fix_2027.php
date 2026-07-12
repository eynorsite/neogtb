<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * GEO — enrichissement du contenu (prod), one-shot idempotent :
 *
 *  A. Article « decret-tertiaire-gtb-obligations » : échéance BACS 70 kW datée
 *     « 1er janvier 2027 » (périmée depuis le décret n° 2025-1343) → « 2030 ».
 *     Remplacement de chaîne EXACTE (lue en base prod) → fiable.
 *
 *  C. Article pilier « guide-complet-gtb-2026 » : contenu réécrit façon GEO
 *     (réponse d'abord, statistiques sourcées ADEME/NF EN ISO 52120-1, seuils
 *     BACS en puissance, mini-FAQ) ET surtout HTML « Purify-safe » : le tableau
 *     des classes est converti en liste <ul>, car la config Purify n'autorise
 *     PAS <table> (c'est pourquoi le tableau actuel s'affichait en charabia).
 *
 * Garde d'idempotence : le pilier n'est réécrit QUE si l'ancien marqueur
 * « est devenue un enjeu majeur » est présent (absent de la nouvelle version).
 * → aucune ré-application, et aucun écrasement d'un contenu déjà réédité.
 * Sauvegarde de l'ancien contenu conservée hors-git ; down() no-op (one-shot).
 */
return new class extends Migration
{
    public function up(): void
    {
        $applied = ['fix_2027' => 0, 'pilier_reecrit' => 0];

        // A. Correction date 2027 → 2030 (chaîne exacte)
        $old2027 = '<strong>1er janvier 2027</strong> : bâtiments avec CVC &gt; 70 kW';
        $new2027 = '<strong>1er janvier 2030</strong> : bâtiments avec CVC &gt; 70 kW';
        $art = DB::table('posts')->where('slug', 'decret-tertiaire-gtb-obligations')->first();
        if ($art && str_contains((string) $art->content, $old2027)) {
            DB::table('posts')->where('id', $art->id)->update([
                'content' => str_replace($old2027, $new2027, $art->content),
            ]);
            $applied['fix_2027'] = 1;
        }

        // C. Réécriture GEO du pilier (garde par marqueur de l'ancienne version)
        $pilier = DB::table('posts')->where('slug', 'guide-complet-gtb-2026')->first();
        if ($pilier && str_contains((string) $pilier->content, 'est devenue un enjeu majeur')) {
            DB::table('posts')->where('id', $pilier->id)->update([
                'content' => $this->pilierHtml(),
            ]);
            $applied['pilier_reecrit'] = 1;
        }

        Log::info('[GEO migration] Enrichissement contenu', $applied);
    }

    public function down(): void
    {
        // Enrichissement one-shot — non réversible automatiquement (ancien contenu sauvegardé hors-git).
    }

    private function pilierHtml(): string
    {
        return <<<'HTML'
<p><strong>La GTB (Gestion Technique du Bâtiment) est le système informatique qui centralise le pilotage des équipements techniques d'un bâtiment — chauffage, ventilation, climatisation, éclairage, comptage d'énergie — pour réduire sa consommation de 20 à 30 %.</strong> Selon la norme <strong>NF EN ISO 52120-1</strong> (ex-EN 15232), c'est le principal levier d'efficacité énergétique <em>active</em> du tertiaire. Depuis le <strong>décret BACS</strong>, elle est même obligatoire au-delà de 290 kW de puissance de chauffage-climatisation.</p>
<h2>Définition simple : la GTB, le « cerveau » du bâtiment</h2>
<p>Concrètement, une GTB fait quatre choses en continu :</p>
<ul>
<li><strong>Elle collecte</strong> les données de dizaines à des centaines de capteurs (température, présence, CO₂, consommation…) ;</li>
<li><strong>Elle analyse</strong> ces données en temps réel ;</li>
<li><strong>Elle pilote</strong> les équipements (chauffage, éclairage, ventilation, stores…) selon l'occupation réelle ;</li>
<li><strong>Elle optimise</strong> le fonctionnement global pour supprimer les gaspillages invisibles.</li>
</ul>
<p>Là où la <strong>GTC</strong> (Gestion Technique Centralisée) supervise <em>un</em> lot technique isolé (souvent le CVC), la GTB <strong>fait dialoguer tous les lots entre eux</strong> depuis une supervision unique.</p>
<h2>Les 5 fonctions principales d'une GTB</h2>
<h3>1. Régulation CVC</h3>
<p>Le chauffage, la ventilation et la climatisation (CVC) pèsent <strong>près de 50 % de la consommation énergétique d'un bâtiment tertiaire</strong> (source : <strong>ADEME</strong>). C'est le premier gisement d'économies : la GTB régule finement chaque zone selon l'occupation réelle plutôt que de chauffer ou climatiser des locaux vides.</p>
<h3>2. Gestion de l'éclairage</h3>
<p>Détection de présence, variation d'intensité selon la lumière naturelle, scénarios horaires : l'éclairage piloté réduit sa consommation <strong>de 30 à 50 %</strong> tout en préservant le confort visuel.</p>
<h3>3. Suivi énergétique</h3>
<p>Comptage par usage (chauffage, éclairage, prises), détection automatique des dérives, alertes en temps réel : la GTB <strong>rend visible ce qui était invisible</strong> et fournit les justificatifs exigés par le décret tertiaire.</p>
<h3>4. Sécurité</h3>
<p>Contrôle d'accès, détection d'intrusion, sécurité incendie : la GTB intègre ou communique avec les systèmes de sûreté du bâtiment via des protocoles standard (BACnet, Modbus).</p>
<h3>5. Reporting</h3>
<p>Tableaux de bord, historiques et rapports automatisés : la GTB produit les données nécessaires au pilotage et à la preuve de conformité réglementaire.</p>
<h2>Quel gain attendre selon la classe de GTB ? (norme NF EN ISO 52120-1)</h2>
<p>La norme <strong>NF EN ISO 52120-1 (ex-EN 15232)</strong> classe la performance des systèmes d'automatisation en quatre niveaux, avec un impact chiffré sur la consommation :</p>
<ul>
<li><strong>Classe D</strong> — non performant, aucune régulation : surconsommation (référence haute).</li>
<li><strong>Classe C</strong> — automatisation standard, <strong>minimum conforme au décret BACS</strong> : niveau de référence.</li>
<li><strong>Classe B</strong> — automatisation avancée avec supervision centralisée : <strong>20 à 30 % d'économies</strong>. C'est le niveau couramment visé et la condition de la prime CEE.</li>
<li><strong>Classe A</strong> — haute performance et optimisation prédictive : <strong>jusqu'à 30 à 50 % d'économies</strong>.</li>
</ul>
<p><em>Fourchettes indicatives issues des facteurs d'efficacité de la norme NF EN ISO 52120-1, variables selon le type de bâtiment et l'usage.</em></p>
<h2>Combien coûte une GTB ?</h2>
<p>Le budget dépend de la taille et de la complexité du bâtiment. Ordres de grandeur observés :</p>
<ul>
<li><strong>Petits bâtiments</strong> (moins de 2 000 m²) : 15 à 30 €/m² ;</li>
<li><strong>Bâtiments moyens</strong> (2 000 à 10 000 m²) : 10 à 25 €/m² ;</li>
<li><strong>Grands bâtiments</strong> (plus de 10 000 m²) : 8 à 20 €/m².</li>
</ul>
<p>Le <strong>retour sur investissement se situe généralement entre 2 et 5 ans</strong>, souvent raccourci par la <strong>prime CEE dédiée à la GTB</strong> (fiche standardisée BAT-TH-116), conditionnée à l'atteinte de la classe B.</p>
<h2>Réglementation : la GTB est-elle obligatoire ?</h2>
<h3>Décret BACS — l'obligation d'automatisation</h3>
<p><strong>Oui, au-delà d'un certain seuil de puissance.</strong> Le décret BACS (<em>Building Automation and Control Systems</em>) impose des fonctions d'automatisation et de contrôle (art. <strong>R. 175-3</strong> du Code de la construction et de l'habitation) aux bâtiments tertiaires équipés de systèmes de chauffage ou de climatisation dont la <strong>puissance nominale dépasse</strong> :</p>
<ul>
<li><strong>290 kW</strong> → obligation applicable depuis le <strong>1er janvier 2025</strong> ;</li>
<li><strong>70 kW</strong> → obligation applicable au <strong>1er janvier 2030</strong>.</li>
</ul>
<p><strong>Point clé souvent mal compris : le seuil BACS s'exprime en puissance (kW), pas en surface (m²).</strong> Le décret impose des <em>fonctions</em> d'automatisation ; la classe B de la norme NF EN ISO 52120-1 est le niveau couramment retenu pour y répondre et pour obtenir la prime CEE.</p>
<h3>Décret tertiaire — l'obligation de résultat</h3>
<p>Le dispositif Éco Énergie Tertiaire impose aux bâtiments tertiaires de <strong>plus de 1 000 m²</strong> de réduire leur consommation d'énergie finale de <strong>-40 % d'ici 2030, -50 % d'ici 2040 et -60 % d'ici 2050</strong>. La GTB est le principal outil pour atteindre <em>et prouver</em> ces objectifs.</p>
<h3>RE2020 — le neuf</h3>
<p>La réglementation environnementale 2020 fixe des exigences de performance qui rendent la GTB quasi indispensable dans les constructions tertiaires neuves.</p>
<h2>Questions fréquentes</h2>
<h3>GTB et GTC, est-ce la même chose ?</h3>
<p>Non. La GTC pilote <strong>un</strong> lot technique (souvent le CVC) ; la GTB <strong>supervise et coordonne l'ensemble</strong> des lots depuis une interface unique.</p>
<h3>Mon bâtiment est-il concerné par le décret BACS ?</h3>
<p>Si sa puissance de chauffage/climatisation dépasse <strong>290 kW</strong>, l'obligation s'applique <strong>depuis 2025</strong> ; entre <strong>70 et 290 kW</strong>, elle s'appliquera <strong>en 2030</strong>.</p>
<h3>Quelle classe viser ?</h3>
<p>La <strong>classe B</strong> de la norme NF EN ISO 52120-1 : c'est le niveau généralement visé et la condition d'éligibilité à la prime CEE.</p>
<h2>Conclusion</h2>
<p>La GTB n'est plus un luxe mais une <strong>nécessité réglementaire et économique</strong>. Entre le décret BACS, le décret tertiaire et un retour sur investissement de 2 à 5 ans, c'est l'une des décisions les plus rentables pour un gestionnaire de bâtiment tertiaire.</p>
<p><em>Besoin d'évaluer la maturité GTB de votre bâtiment ? <a href="/audit">Lancez notre audit gratuit</a>.</em></p>
HTML;
    }
};
