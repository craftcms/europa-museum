import store from '../store';
import bindAll from '../utils/bindAll';

// Blocks
import SliderBlock from './slider';

class BlocksController {
    constructor() {
        bindAll(this, []);

        this.initVars();
        this.initBlocks();
    }

    initVars() {
        this.slider = store.body.querySelectorAll('.slider');
        BlocksController.sliders = [];
    }

    initBlocks() {
        this.slider.forEach((element, i) => {
            BlocksController.sliders[i] = new SliderBlock(BlocksController, element);
        });
    }

    stopBlocks() {
        BlocksController.sliders.forEach(block => {
            block.destroy();
        });
    }

}

export default BlocksController;
