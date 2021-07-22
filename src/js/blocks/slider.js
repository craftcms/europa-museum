import Flickity from 'flickity';
import imagesLoaded from 'flickity-imagesloaded';

import store from '../store';
import bindAll from '../utils/bindAll';

class SliderBlock {
    constructor(BlocksController, slider) {
        this.initVars(BlocksController, slider);
        this.initBlock();
    }

    // Init Vars
    initVars(BlocksController, slider) {
        bindAll(this, ['sliderPrev', 'sliderNext', 'dragStart', 'dragEnd']);

        this.BlocksController = BlocksController;
        this.slider = slider;

        if (this.slider.classList.contains('slide-wrap')) {
            this.slideWrapAround = true;
            this.slideInitialIndex = 1;
        } else {
            this.slideWrapAround = false;
            this.slideInitialIndex = 0;
        }

        this.sliderBlock = this.slider.closest('.slider-block');

        this.slidePrev = this.sliderBlock.querySelector('.btn-slider-prev');
        this.slideNext = this.sliderBlock.querySelector('.btn-slider-next');

        this.slides = this.sliderBlock.querySelectorAll('.slide');

        this.flkty = null;
    }

    // Init Page
    initBlock() {
        if (this.slider) {
            this.initSlider();
        }

        this.initEvents();
    }

    // Init Events
    initEvents() {
        const _this = this;

        if (document.readyState === 'complete') {

            this.flkty.resize();
            store.locoScroll.update();

        } else {

            window.addEventListener('load', function() {
                _this.flkty.resize();
                store.locoScroll.update();
            });

        }

        this.slidePrev.addEventListener('click', _this.sliderPrev);
        this.slideNext.addEventListener('click', _this.sliderNext);

        this.flkty.on('dragStart', _this.dragStart);
        this.flkty.on('dragEnd', _this.dragEnd);
    }

    // destroy
    destroy() {
        const _this = this;

        window.removeEventListener('load', function() {
            _this.flkty.resize();
        });

        this.slidePrev.removeEventListener('click', _this.sliderPrev);
        this.slideNext.removeEventListener('click', _this.sliderNext);

        this.flkty.off('dragStart', _this.dragStart);
        this.flkty.off('dragEnd', _this.dragEnd);
    }

    // Init Slider
    initSlider() {
        const _this = this;

        // Custom
        const applySelectedAttraction = Flickity.prototype.applySelectedAttraction;

        Flickity.prototype.applySelectedAttraction = function() {
            const freeScrollSlowDown = this.options.freeScrollSlowDown;
            if ( freeScrollSlowDown ) {
                this.applyBrakes( freeScrollSlowDown );
            } else {
                applySelectedAttraction.apply( this, arguments );
            }
        };

        Flickity.prototype.applyBrakes = function( freeScrollSlowDown ) {
            const dragDown = this.isDraggable && this.isPointerDown;
            if ( dragDown || !this.slides.length ) {
                return;
            }
            const distance = this.selectedSlide.target * -1 - this.x;
            const isValidNumber = typeof freeScrollSlowDown == 'number' && freeScrollSlowDown > 0;
            const deceleration = isValidNumber ? freeScrollSlowDown : 20;
            this.velocity = ( distance * (1-this.getFrictionFactor()) ) * deceleration;
        };

        // Flickity Init

        this.flkty = new Flickity(_this.slider, {
            cellSelector: '.slide',
            initialIndex: _this.slideInitialIndex,
            imagesLoaded: true,
            prevNextButtons: false,
            pageDots: false,
            wrapAround: _this.slideWrapAround,
            contain: true,
            adaptiveHeight: false,
            cellAlign: 'center',
            freeScroll: true,
            freeScrollFriction: 0.03,
            freeScrollSlowDown: 1,
            percentPosition: false,
        });
    }

    sliderPrev() {
        this.flkty.previous();
    }

    sliderNext() {
        this.flkty.next();
    }

    dragStart() {
        this.slides.forEach(slide => {
            slide.style.pointerEvents = "none";
        });
    }

    dragEnd() {
        this.slides.forEach(slide => {
            slide.style.pointerEvents = "auto";
        });
    }
}

export default SliderBlock;
