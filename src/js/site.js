// Plugins
import sniffer from 'sniffer';
import lazysizes from 'lazysizes';

// Core
import store from './store';

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
        Object.assign(store, {
          isSmooth: false
        });
    }

    init() {
        const footerTop = store.coreFooter.querySelector('.scroll-top');

        // window.scrollTo(0, 0);

        new Pages();

        if (store.isSmooth) {
            "scrollRestoration" in history ? history.scrollRestoration = "manual" : window.onbeforeunload = function() {window.scrollTo(0, 0) };
        }

        // if (store.isSmooth) {
        //     "scrollRestoration" in history ? history.scrollRestoration = "manual" : window.onbeforeunload = function() {window.scrollTo(0, 0) };
        // }

        store.darkToggle.addEventListener('click', () => {
            store.body.classList.toggle('theme-dark');
        });

        footerTop.addEventListener('click', () => {
            store.locoScroll.scrollTo('#loco-scroll');
        });
    }
}

const app = new App();
