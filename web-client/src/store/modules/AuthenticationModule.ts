import {container} from '@/container';
import {HttpClient} from '@/services/connectivity/HttpClient';

interface AuthenticationState {
    token: string | null;
}

export interface UserCredentials {
    username: string;
    password: string;
}

const http = container.get(HttpClient);

const module = {
    namespaced: true,
    state: {
        token: null,
    } as AuthenticationState,
    getters: {
        isAuthenticated: (state: AuthenticationState): boolean => {
            return state.token !== null;
        },
    },
    actions: {
        authenticate: async (context: any, credentials: UserCredentials): Promise<boolean> => {
            const response = await http.post('/login', credentials);

            if (response.data.success) {
                context.commit('setToken', response.data.token);

                http.header('X-AUTH-TOKEN', response.data.token);
                return true;
            } else {
                return false;
            }
        },
    },
    mutations: {
        setToken: (state: AuthenticationState, token: string): void => {
            state.token = token;
        },
    },
};

export {module};
