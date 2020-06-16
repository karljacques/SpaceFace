import {container} from '@/container';
import {HttpClient} from '@/services/connectivity/HttpClient';

interface AuthenticationState {
    isAuthenticated: boolean;
}

export interface UserCredentials {
    username: string;
    password: string;
}

const http = container.get(HttpClient);

const module = {
    namespaced: true,
    state: {
        isAuthenticated: false,
    } as AuthenticationState,
    getters: {
        isAuthenticated: (state: AuthenticationState): boolean => {
            return state.isAuthenticated;
        },
    },
    actions: {
        authenticate: async (context: any, credentials: UserCredentials): Promise<boolean> => {
            const response = await http.post('/login', credentials);

            context.commit('setAuthenticated', !!response.data.token);

            return response.data.success;
        },
        fetchAuthenticationState: async (context: any): Promise<void> => {
            const response = await http.get('/authenticated');
            context.commit('setAuthenticated', response.data.authenticated);
        },
        logout: async (context: any): Promise<void> => {
            await http.get('/authentication/logout');
            await context.dispatch('fetchAuthenticationState');
        },
    },
    mutations: {
        setAuthenticated: (state: AuthenticationState, authenticated: boolean): void => {
            state.isAuthenticated = authenticated;
        },
    },
};

export {module};
