import {HttpInterface} from '@/services/connectivity/HttpInterface';
import {inject, injectable} from 'inversify';

@injectable()
export abstract class AbstractAPIController {
    @inject(HttpInterface) protected http!: HttpInterface;
}
