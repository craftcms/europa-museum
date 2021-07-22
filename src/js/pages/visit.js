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
        const _this = this;

        store.body.style.pointerEvents = 'none';
        store.locoScroll.scrollTo(_this.contentBlocks, -120);
        setTimeout(() => {
            store.body.style.pointerEvents = 'auto';
        }, 1000);
    }

}

export default Visit;
