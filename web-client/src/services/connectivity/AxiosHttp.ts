import axios, {AxiosInstance, AxiosRequestConfig} from 'axios';
import {HttpClient} from '@/services/connectivity/HttpClient';
import {HttpRequestConfig} from '@/services/connectivity/interface/HttpRequestConfig';
import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';
import {HttpError} from '@/services/connectivity/interface/HttpError';

class AxiosHttp implements HttpClient {
    protected axios: AxiosInstance;

    constructor(options: object) {
        this.axios = axios.create(options);
    }

    public delete<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R> {
        return this.axios.delete(url, config as AxiosRequestConfig);
    }

    public get<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R> {
        try {
            return this.axios.get(url, config as AxiosRequestConfig);
        } catch (e) {
            throw e as HttpError;
        }
    }

    public head<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R> {
        return this.axios.head(url, config as AxiosRequestConfig);
    }

    public options<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R> {
        return this.axios.options(url, config as AxiosRequestConfig);
    }

    public patch<T = any, R = HttpResponse<T>>(url: string, data?: any, config?: HttpRequestConfig): Promise<R> {
        return this.axios.patch(url, data, config as AxiosRequestConfig);
    }

    public post<T = any, R = HttpResponse<T>>(url: string, data?: any, config?: HttpRequestConfig): Promise<R> {
        try {
            return this.axios.post(url, data, config as AxiosRequestConfig);
        } catch (e) {
            throw e as HttpError;
        }
    }

    public put<T = any, R = HttpResponse<T>>(url: string, data?: any, config?: HttpRequestConfig): Promise<R> {
        return this.axios.put(url, data, config as AxiosRequestConfig);
    }

    public request<T = any, R = HttpResponse<T>>(config: HttpRequestConfig): Promise<R> {
        return this.axios.request(config as AxiosRequestConfig);
    }

    public header(header: string, value: string): void {
        this.axios.defaults.headers[header] = value;
    }
}

export {AxiosHttp};
