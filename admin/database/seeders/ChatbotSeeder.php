<?php

namespace Database\Seeders;

use App\Models\ChatbotFaq;
use App\Models\ChatbotKnowledgeSnippet;
use App\Models\ChatbotSetting;
use Illuminate\Database\Seeder;

class ChatbotSeeder extends Seeder
{
    public function run(): void
    {
        ChatbotSetting::current();

        $snippets = [
            [
                'title' => 'NeoGTB — qui sommes-nous',
                'category' => 'NeoGTB',
                'priority' => 100,
                'content' => "NeoGTB est un cabinet de conseil indépendant en Gestion Technique du Bâtiment (GTB), basé en France. Nous accompagnons les propriétaires et exploitants de bâtiments tertiaires dans leur mise en conformité avec le décret BACS et le décret tertiaire, en agissant comme tiers de confiance entre les maîtres d'ouvrage et les intégrateurs/fabricants. Nous ne vendons aucun matériel ni logiciel : nous conseillons.",
            ],
            [
                'title' => 'Décret BACS — l\'essentiel',
                'category' => 'Décret BACS',
                'priority' => 95,
                'content' => "Le décret BACS (Building Automation and Control Systems) impose la mise en place de systèmes d'automatisation et de régulation dans les bâtiments tertiaires existants ou neufs dont la puissance nominale des systèmes de chauffage/climatisation/ventilation dépasse certains seuils. Le décret 2025-1343 du 30 décembre 2025 a fixé les calendriers de mise en conformité progressive jusqu'en 2027. Source : Légifrance, articles R.175-1 et suivants du Code de la construction et de l'habitation. Les sanctions en cas de non-conformité ne sont pas encore stabilisées mais des contrôles sont prévus.",
            ],
            [
                'title' => 'Différence GTB / GTC',
                'category' => 'Technique',
                'priority' => 80,
                'content' => "La GTC (Gestion Technique Centralisée) supervise un seul lot technique (par exemple : seulement le CVC, ou seulement l'éclairage). La GTB (Gestion Technique du Bâtiment) supervise et fait communiquer plusieurs lots techniques entre eux : CVC, éclairage, GTC énergie, sûreté, etc. Le décret BACS exige une GTB (multi-lots) et non une simple GTC. C'est une distinction importante quand on choisit son installation.",
            ],
            [
                'title' => 'Norme EN 15232 — niveaux de GTB',
                'category' => 'Technique',
                'priority' => 70,
                'content' => "La norme EN 15232 définit 4 classes de performance énergétique pour les systèmes de gestion du bâtiment : Classe A (haute performance), Classe B (avancée), Classe C (standard, niveau de référence), Classe D (non-énergétiquement efficace, à éviter). Le décret BACS exige au minimum une classe B ou A selon la taille du bâtiment.",
            ],
            [
                'title' => 'Services NeoGTB',
                'category' => 'Services',
                'priority' => 90,
                'content' => "NeoGTB propose : 1) Un pré-diagnostic GTB en ligne gratuit (wizard sur /audit) qui donne un score sur 100 et une estimation des économies. 2) Un comparateur des principales solutions GTB du marché (/comparateur). 3) Un générateur de fiches CEE pour valoriser les opérations standardisées (/generateur-cee). 4) Un accompagnement personnalisé sur devis : audit terrain, rédaction de cahier des charges, assistance à maîtrise d'ouvrage, suivi de chantier.",
            ],
            [
                'title' => 'Protocoles de communication GTB',
                'category' => 'Technique',
                'priority' => 60,
                'content' => "Les principaux protocoles de communication utilisés en GTB sont : Modbus (RTU série ou TCP/IP, simple et très répandu pour CVC/énergie), BACnet (protocole standard ISO du bâtiment), KNX (très utilisé pour l'éclairage et les commandes de zone), LonWorks (vieillissant), MQTT/REST (pour les passerelles IoT modernes). Une GTB conforme BACS doit privilégier les protocoles ouverts (BACnet, Modbus, KNX) pour éviter le verrouillage fournisseur.",
            ],
            [
                'title' => 'Tarifs et engagement',
                'category' => 'Tarifs',
                'priority' => 50,
                'content' => "Le pré-diagnostic en ligne est totalement gratuit. Pour un audit terrain personnalisé ou un accompagnement, les tarifs dépendent de la taille du bâtiment et du périmètre. Nous fournissons toujours un devis détaillé avant tout engagement. Pour obtenir un devis : /contact ou hello@neogtb.fr.",
            ],
            [
                'title' => 'Contact NeoGTB',
                'category' => 'Contact',
                'priority' => 40,
                'content' => "Pour nous joindre : email hello@neogtb.fr, formulaire /contact, ou demande d'audit /audit. Nous répondons sous 48 h ouvrées. Site web : https://neogtb.fr",
            ],
        ];

        foreach ($snippets as $s) {
            ChatbotKnowledgeSnippet::firstOrCreate(
                ['title' => $s['title']],
                $s + ['is_active' => true]
            );
        }

        $faqs = [
            [
                'question' => 'Mon bâtiment est-il concerné par le décret BACS ?',
                'answer' => "Le décret BACS s'applique aux bâtiments tertiaires (existants ou neufs) dont la puissance nominale des systèmes de chauffage, climatisation ou ventilation dépasse certains seuils définis par le décret 2025-1343. Pour le savoir précisément, faites notre pré-diagnostic gratuit sur /audit ou contactez-nous via /contact.",
                'category' => 'Décret BACS',
                'show_as_suggestion' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Quelle différence entre GTB et GTC ?',
                'answer' => "La GTC gère un seul lot technique (souvent le CVC). La GTB est plus large : elle supervise et fait communiquer plusieurs lots (CVC, éclairage, énergie, etc.). Le décret BACS exige une GTB, pas une simple GTC.",
                'category' => 'Technique',
                'show_as_suggestion' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'Comment se déroule un audit NeoGTB ?',
                'answer' => "Tout commence par notre pré-diagnostic gratuit en ligne (/audit) : 5 minutes de questions pour obtenir un score et une estimation des économies. Ensuite, si vous le souhaitez, nous proposons un audit terrain personnalisé sur devis : visite des installations, analyse des protocoles, rédaction du cahier des charges, comparatif d'intégrateurs.",
                'category' => 'Services',
                'show_as_suggestion' => true,
                'sort_order' => 3,
            ],
            [
                'question' => 'Combien coûte un accompagnement NeoGTB ?',
                'answer' => "Le pré-diagnostic en ligne est gratuit. Pour un accompagnement personnalisé, le tarif dépend de la taille du bâtiment et du périmètre. Demandez un devis sans engagement via /contact.",
                'category' => 'Tarifs',
                'show_as_suggestion' => false,
                'sort_order' => 4,
            ],
            [
                'question' => 'Êtes-vous indépendant des fabricants ?',
                'answer' => "Oui, totalement. NeoGTB est un cabinet de conseil indépendant : nous ne vendons aucun matériel ni logiciel et n'avons aucune commission de revente. C'est ce qui fait notre rôle de tiers de confiance.",
                'category' => 'NeoGTB',
                'show_as_suggestion' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($faqs as $f) {
            ChatbotFaq::firstOrCreate(
                ['question' => $f['question']],
                $f + ['is_active' => true]
            );
        }

        $this->command?->info('Chatbot : settings + ' . count($snippets) . ' snippets + ' . count($faqs) . ' FAQ initialisés.');
    }
}
