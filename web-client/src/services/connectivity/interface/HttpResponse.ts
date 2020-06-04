import {HttpRequestConfig} from '@/services/connectivity/interface/HttpRequestConfig';

export interface HttpResponse<T = any> {
    data: T;
    status: number;
    statusText: string;
    headers: any;
    config: HttpRequestConfig;
    request?: any;
}
