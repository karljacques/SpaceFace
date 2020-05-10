import {Inject, Vue} from 'vue-property-decorator';
import {Container} from 'inversify';
import {interfaces} from 'inversify/dts/interfaces/interfaces';

abstract class VueContainer extends Vue {
    @Inject('container') protected container!: Container;

    protected get<T>(serviceIdentifier: interfaces.ServiceIdentifier<T>): T {
        return this.container.get<T>(serviceIdentifier);
    }
}

export {VueContainer};
