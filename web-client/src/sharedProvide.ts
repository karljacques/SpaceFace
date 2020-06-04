import {fluentProvide} from 'inversify-binding-decorators';

const sharedProvide = (identifier: any) => {
    return fluentProvide(identifier)
        .inSingletonScope()
        .done();
};

export {sharedProvide};
