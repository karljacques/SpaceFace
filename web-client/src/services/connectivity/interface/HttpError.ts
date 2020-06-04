import {HttpRequestConfig} from '@/services/connectivity/interface/HttpRequestConfig';
import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';

export interface HttpError<T = any> extends Error {
    config: HttpRequestConfig;
    code?: string;
    request?: any;
    response?: HttpResponse<T>;
    isAxiosError: boolean;
    toJSON: () => object;
}
