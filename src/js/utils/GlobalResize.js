import debounce from 'lodash.debounce';
import EventBus from './EventBus';

class GlobalResize {

    constructor() {
        this.onResize = debounce(this.onResize.bind(this), 200);
        window.addEventListener('resize', this.onResize);
    }

    onResize() {
        EventBus.emit(GlobalResize.events.RESIZE);
    }
}

GlobalResize.events = {
    RESIZE: 'GlobalResize.events.RESIZE',
};

export default new GlobalResize();
export const Events = GlobalResize.events;
