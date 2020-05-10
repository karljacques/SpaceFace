import {Inject, Vue} from 'vue-property-decorator';
import {Container} from 'inversify';

abstract class VueContainer extends Vue {
    @Inject('CONTAINER') protected container!: Container;
}

export {VueContainer};
