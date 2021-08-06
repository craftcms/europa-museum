// Plugins
import sniffer from 'sniffer';
import Highway from '@dogstudio/highway/build/highway';
import lazysizes from 'lazysizes';
import { gsap } from "gsap";

// Core
import store from './store';

// Highway Renderers
import DefaultRenderer from './plugins/highway/renderers/default-renderer';
import StyleguideRenderer from './plugins/highway/renderers/styleguide-renderer';
import HomeRenderer from './plugins/highway/renderers/home-renderer';
import ExhibitionsRenderer from './plugins/highway/renderers/exhibitions-renderer';
import ExhibitRenderer from './plugins/highway/renderers/exhibit-renderer';
import VisitRenderer from './plugins/highway/renderers/visit-renderer';
import NewsRenderer from './plugins/highway/renderers/news-renderer';
import NewsArticleRenderer from './plugins/highway/renderers/newsArticle-renderer';
import AboutRenderer from './plugins/highway/renderers/about-renderer';
import ContactRenderer from './plugins/highway/renderers/contact-renderer';

// Highway Transitions
import DefaultTransition from './plugins/highway/transitions/default-transition';

// Components
import { GlobalMobileNavMenu } from './components/mobileNavMenu';

window.firstLoad = true;

lazysizes.init();

// Highway
let H;

class App {

    constructor() {
        this.setup();
        this.init();
    }

    setup() {
        sniffer.addClasses(store.body);
        Object.assign(store, sniffer.getInfos());
        Object.assign(store, {
          isSmooth: sniffer.isDesktop
        });
    }

    init() {
        const footerTop = store.coreFooter.querySelector('.scroll-top');

        window.scrollTo(0, 0);

        this.initH();

        if (store.isSmooth) {
            "scrollRestoration" in history ? history.scrollRestoration = "manual" : window.onbeforeunload = function() {window.scrollTo(0, 0) };
        }

        store.darkToggle.addEventListener('click', () => {
            store.body.classList.toggle('theme-dark');
        });

        footerTop.addEventListener('click', () => {
            store.locoScroll.scrollTo('#loco-scroll');
        });
    }

    initH() {
        H = new Highway.Core({
            renderers: {
                default: DefaultRenderer,
                styleguide: StyleguideRenderer,
                home: HomeRenderer,
                exhibitions: ExhibitionsRenderer,
                exhibit: ExhibitRenderer,
                visit: VisitRenderer,
                news: NewsRenderer,
                newsArticle: NewsArticleRenderer,
                about: AboutRenderer,
                contact: ContactRenderer
            },
            transitions: {
                default: DefaultTransition
            },
        });

        H.on('NAVIGATE_IN', ({to, trigger, location}) => {
            window.scrollTo(0, 0);
            window.firstLoad = false;
            store.body.classList.remove('loading');
            store.body.classList.remove('scrolled');
            store.isLoading = false;
        });

        H.on('NAVIGATE_OUT', ({from, trigger, location}) => {
            store.body.classList.remove('first-load');
            store.body.classList.add('loading');
            store.isLoading = true;

            GlobalMobileNavMenu.mobileNavMenuClose();
        });
    }

}

const app = new App();

export { H };
