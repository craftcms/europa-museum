import Highway from '@dogstudio/highway/build/highway';

class DefaultTransition extends Highway.Transition {

    in({from, to, trigger, done}) {

        setTimeout(() => {
            done();
        }, 500);

    }

    out({from, trigger, done}) {

        setTimeout(() => {
            from.remove();
            done();
        }, 500);

    }

}

export default DefaultTransition;
