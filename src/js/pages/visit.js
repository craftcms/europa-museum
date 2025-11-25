import store from '../store';

import bindAll from '../utils/bindAll';

class Visit {
    constructor() {
        this.initVars();
        this.initPage();
    }

    // Init Vars
    initVars() {
        bindAll(this, ['scrollDown']);

        this.btnDown = store.body.querySelector('.btn-down');
        this.contentBlocks = store.body.querySelector('.content-blocks');
    }

    // Init Page
    initPage() {
        this.addListeners();
    }

    addListeners() {
        const _this = this;

        this.btnDown.addEventListener('click', _this.scrollDown);
    }

    removeListeners() {
        const _this = this;

        this.btnDown.removeEventListener('click', _this.scrollDown);
    }

    // Stop Page
    stopPage() {
        this.removeListeners();
    }

    scrollDown() {
        const contentRect = this.contentBlocks.getBoundingClientRect();

        window.scrollTo({
            left: 0,
            top: window.scrollY + contentRect.top - 150,
            behavior: 'smooth',
        });
    }

}

export default Visit;
