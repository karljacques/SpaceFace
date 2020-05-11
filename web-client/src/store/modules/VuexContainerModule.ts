import {container} from '@/container';
import {VuexModule} from 'vuex-module-decorators';
import {Container} from 'inversify';
import {interfaces} from 'inversify/dts/interfaces/interfaces';

export class VuexContainerModule extends VuexModule {
    private container: Container = container;

    protected get<T>(serviceIdentifier: interfaces.ServiceIdentifier<T>): T {
        return this.container.get<T>(serviceIdentifier);
    }
}
