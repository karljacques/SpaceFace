import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';
import {HttpRequestConfig} from '@/services/connectivity/interface/HttpRequestConfig';

abstract class HttpClient {
    public abstract request<T = any, R = HttpResponse<T>>(config: HttpRequestConfig): Promise<R>;

    public abstract get<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R>;

    public abstract delete<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R>;

    public abstract head<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R>;

    public abstract options<T = any, R = HttpResponse<T>>(url: string, config?: HttpRequestConfig): Promise<R>;

    public abstract post<T = any, R = HttpResponse<T>>(url: string, data?: any, config?: HttpRequestConfig): Promise<R>;

    public abstract put<T = any, R = HttpResponse<T>>(url: string, data?: any, config?: HttpRequestConfig): Promise<R>;

    public abstract patch<T = any, R = HttpResponse<T>>
    (url: string, data?: any, config?: HttpRequestConfig): Promise<R>;

    public abstract header(header: string, value: string): void;
}

const mockHttpClientFactory = (): HttpClient => {
    return {
        get: jest.fn(),
        post: jest.fn(),
        head: jest.fn(),
        request: jest.fn(),
        options: jest.fn(),
        put: jest.fn(),
        patch: jest.fn(),
        delete: jest.fn(),
        header: jest.fn(),
    };
};

export {HttpClient, mockHttpClientFactory};
