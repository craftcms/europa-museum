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
        const pageTemplate = segments[0];
        const pageName = pageTemplate.length > 1 ? pageTemplate : 'home';
        store.body.dataset.page = pageName;

        if (pageName === 'exhibitions') {
            new Exhibitions();
        }

        if (pageName === 'visit') {
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

        const _this = this;

        this.scrolled = false;

        if (document.readyState === 'complete') {

            this.updateScroll();

        } else {

            window.addEventListener('load', () => {

                store.body.classList.remove('loading');
                store.isLoading = false;

                _this.updateScroll();

            });
        }

        EventBus.on(GlobalResizeEvents.RESIZE, _this.onResize);

        document.addEventListener('lazyloaded', _this.updateScroll);

        // Blocks
        if (this.contentBlocks) {
            this.blocksController = new BlocksController();
        }

    }

    onResize() {
        this.updateScroll();
    }

    updateScroll() {}

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
