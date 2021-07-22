import DefaultRenderer from './default-renderer';

import Exhibitions from '../../../pages/exhibitions';
// import store from '../../../store';

let exhibitions;

class ExhibitionsRenderer extends DefaultRenderer {
    onEnter() {
        super.onEnter();
    }
    onLeave() {
        super.onLeave();
    }
    onEnterCompleted() {
        super.onEnterCompleted();

        exhibitions = new Exhibitions();
    }
    onLeaveCompleted() {
        super.onLeaveCompleted();

        exhibitions.stopPage();
        exhibitions = null;
    }
}

export default ExhibitionsRenderer;
