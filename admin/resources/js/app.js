import './bootstrap';

// Alpine.js + plugins (self-hosted, plus de unpkg)
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

window.Alpine = Alpine;
Alpine.start();
