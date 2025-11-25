// Plugins
import sniffer from 'sniffer';
import lazysizes from 'lazysizes';

// Core
import store from './store';

import { GlobalMobileNavMenu } from './components/mobileNavMenu.js';
import Pages from './pages/index.js';

window.firstLoad = true;

class App {

    constructor() {
        this.setup();
        this.init();
    }

    setup() {
        sniffer.addClasses(store.body);
        Object.assign(store, sniffer.getInfos());
    }

    init() {
        const $footerTop = store.coreFooter.querySelector('.scroll-top');

        new Pages();

        store.darkToggle.addEventListener('click', () => {
            store.body.classList.toggle('theme-dark');
        });

        $footerTop.addEventListener('click', () => {
            window.scrollTo({
                left: 0,
                top: 0,
                behavior: 'smooth',
            });
        });
    }
}

const app = new App();
