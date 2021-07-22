import DefaultRenderer from './default-renderer';

import Visit from '../../../pages/visit';

let visit;

class VisitRenderer extends DefaultRenderer {
    onEnter() {
        super.onEnter();
    }
    onLeave() {
        super.onLeave();
    }
    onEnterCompleted() {
        super.onEnterCompleted();

        visit = new Visit();
    }
    onLeaveCompleted() {
        super.onLeaveCompleted();

        visit.stopPage();
        visit = null;
    }
}

export default VisitRenderer;
