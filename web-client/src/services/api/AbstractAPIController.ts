import {HttpClient} from '@/services/connectivity/HttpClient';
import {inject, injectable} from 'inversify';

@injectable()
export abstract class AbstractAPIController {
    @inject(HttpClient) protected http!: HttpClient;
}
