// Alpine.js build CSP (self-hosted) — l'évaluateur n'utilise plus new Function(),
// ce qui permet de retirer 'unsafe-eval' de la CSP. Contrainte : aucune variable
// globale (localStorage, navigator, document, setTimeout…) ni template literal /
// fonction fléchée dans les directives ; cette logique vit dans les méthodes des composants.
import Alpine from '@alpinejs/csp';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

// Composants partagés (enregistrés avant Alpine.start()).
// Copie d'un lien dans le presse-papier (article).
Alpine.data('copyLink', () => ({
    copied: false,
    copy() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            this.copied = true;
            setTimeout(() => { this.copied = false; }, 2000);
        }).catch(() => {});
    },
}));

// Bandeau d'annonce dismissible — texte passé via data-announcement-text,
// persistance localStorage (logique sortie de la directive : globals interdits en CSP).
Alpine.data('announcementBar', () => ({
    dismissed: false,
    storageKey: 'neogtb_announcement_dismissed',
    init() {
        const text = this.$el.dataset.announcementText;
        const stored = localStorage.getItem(this.storageKey);
        if (stored) {
            try {
                const data = JSON.parse(stored);
                if (data.text === text) this.dismissed = true;
                else localStorage.removeItem(this.storageKey);
            } catch (e) { localStorage.removeItem(this.storageKey); }
        }
    },
    dismiss() {
        this.dismissed = true;
        localStorage.setItem(this.storageKey, JSON.stringify({ text: this.$el.dataset.announcementText, at: Date.now() }));
    },
}));

// Bannière CTA dismissible — clé de stockage passée via data-storage-key.
Alpine.data('ctaDismiss', () => ({
    show: false,
    init() {
        this.show = !localStorage.getItem(this.$el.dataset.storageKey);
    },
    dismiss() {
        this.show = false;
        localStorage.setItem(this.$el.dataset.storageKey, '1');
    },
}));

window.Alpine = Alpine;
Alpine.start();
