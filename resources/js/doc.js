import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Alpine.magic('tooltip', (el) => (message) => {
    let instance = tippy(el, { content: message, trigger: 'manual' });

    instance.show();

    setTimeout(() => {
        instance.hide();

        setTimeout(() => instance.destroy(), 150);
    }, 2000);
});
