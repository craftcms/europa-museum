// Core
import store from '../store';

// Utils
import bindAll from '../utils/bindAll';

// Events
import EventBus from '../utils/EventBus';
import { Events as GlobalResizeEvents } from '../utils/GlobalResize';

// Blocks
import BlocksController from '../blocks/blocks-controller';

import Exhibitions from './exhibitions';
import Visit from './visit';

class Pages {
    constructor() {
        const segments = location.pathname.split('/').filter(s => s.length);
        const rootSlug = segments.length ? segments[0] : 'home';
        store.body.dataset.page = rootSlug;

        if (rootSlug === 'exhibitions') {
            new Exhibitions();
        }

        if (rootSlug === 'visit') {
            new Visit();
        }

        this.initVars();
        this.init();
    }

    initVars() {
        this.contentBlocks = store.body.querySelector('.content-blocks');
    }

    init() {
        bindAll(this, ['onResize', 'updateScroll', 'onScroll']);

        this.scrolled = false;
        this.$scrollAwareElements = store.body.querySelectorAll('[data-scroll-section]');
        this.$parallaxElements = store.body.querySelectorAll('[data-scroll]');

        if (document.readyState === 'complete') {
            this.updateScroll();
        } else {
            window.addEventListener('load', () => {
                store.body.classList.remove('loading');
                store.isLoading = false;

                this.updateScroll();
            });
        }

        EventBus.on(GlobalResizeEvents.RESIZE, this.onResize);

        document.addEventListener('lazyloaded', this.updateScroll);
        document.addEventListener('scroll', this.updateScroll);

        // Blocks
        if (this.contentBlocks) {
            this.blocksController = new BlocksController();
        }

    }

    onResize() {
        this.updateScroll();
    }

    updateScroll() {
        // This method includes a number of basic behavioral “shims” for features we wanted from the `locomotive-scroll` package.

        this.$scrollAwareElements.forEach(function($el) {
            const box = $el.getBoundingClientRect();

            // Has it come above-the-fold or passed the screen entirely?
            if (box.top > window.innerHeight || box.bottom < 0) {
                $el.classList.remove('is-inview');
                $el.dataset.isInView = false;
                return;
            }

            // Ok, some part of the element is on screen:
            $el.classList.add('is-inview');
            $el.dataset.isInView = true;
        });

        this.$parallaxElements.forEach(function($el) {
            // Is there an effect to apply?
            if (!$el.dataset.scrollZ) {
                return;
            }

            const z = parseFloat($el.dataset.scrollZ);
            const $scrollSection = $el.closest('[data-scroll-section]');
            const box = $scrollSection.getBoundingClientRect();
            const center = (box.top + box.bottom) / 2;
            const screenCenter = window.innerHeight / 2;
            console.log({ center, screenCenter });

            $el.style.transform = `translate(0, ${(center - screenCenter) / z}px)`;
        });
    }

    onScroll(e) {
        const currentScroll = e.scroll.y;

        EventBus.emit('scroll', e);

        if (currentScroll >= 50 && !this.scrolled) {
            store.body.classList.add('scrolled');
            this.scrolled = true;
        } else if (currentScroll < 50 && this.scrolled) {
            store.body.classList.remove('scrolled');
            this.scrolled = false;
        }
    }

    destroy() {
        const _this = this;

        document.removeEventListener('lazyloaded', _this.updateScroll);

        if (this.blocksController) {
            this.blocksController.stopBlocks();
        }
    }
}

export default Pages;
