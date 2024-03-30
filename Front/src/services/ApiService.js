import redaxios from 'redaxios';
import { useRouter } from 'vue-router';

function getAuthHeaders() {
    const token = localStorage.getItem('authToken');
    return {
        'Authorization': token ? `Bearer ${token}` : undefined,  // Only set Authorization if token exists
        'Content-Type': 'application/json'
    };
}

const ApiService = {
    init() {
        redaxios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
    },


    async makeRequest(method, resource, data = null, skipRefresh = false) {
        const config = {
            method: method,
            url: resource,
            data: data,
            headers: !skipRefresh ? getAuthHeaders() : null
        };

        try {
            return await redaxios(config);
        } catch (error) {
            // console.log(1, skipRefresh)
            if (!skipRefresh && error && error.status === 401) {
                // console.log(2, skipRefresh)
                // Only attempt to refresh the token if we're not already trying to refresh it
                const newToken = await this.refreshToken();
                // console.log(newToken)
                if (newToken) {
                    config.headers = getAuthHeaders(); // Fetch headers again as they will now contain the new token
                    return await redaxios(config);
                } else {
                    throw new Error('Unauthorized - Unable to refresh token');
                }
            } else {
                // Rethrow the error if it's not a 401 or if we're skipping refresh
                throw error;
            }
        }
    },

    get(resource) {
        console.log(resource)
        return this.makeRequest('get', resource);
    },

    post(resource, data) {
        return this.makeRequest('post', resource, data);
    },

    put(resource, data) {
        return this.makeRequest('put', resource, data);
    },

    delete(resource) {
        return this.makeRequest('delete', resource);
    },

    async login(resource, data) {
        const response = await this.post(resource, data);
        if (response.data.token && response.data.refreshToken) {
            localStorage.setItem('authToken', response.data.token);
            localStorage.setItem('refreshToken', response.data.refreshToken);
        }
        return response;
    },

    logout() {
        localStorage.removeItem('authToken');
        localStorage.removeItem('refreshToken');
        delete redaxios.defaults.headers.common['Authorization'];
    },

    handleRefreshTokenFailure() {
        // Clear user session
        this.logout();
        // Use Vue Router to redirect to login page, appending the current path as query param
        const router = useRouter();
        router.push({ name: 'Login', query: { redirect: router.currentRoute.value.fullPath } });
    },

    async refreshToken() {
        try {
            const response = await this.makeRequest('post', '/token/refresh', { refresh_token: localStorage.getItem('refreshToken') }, true);  // Note the 'true' at the end
            if (response.data.token) {
                localStorage.setItem('authToken', response.data.token);
                return response.data.token;
            } else {
                this.handleRefreshTokenFailure();
                return null;
            }
        } catch (error) {
            // console.log(error);
            this.handleRefreshTokenFailure();
            return null;
        }
    },
};

export default ApiService;
