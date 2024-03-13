import redaxios from 'redaxios';

function getAuthHeaders() {
    const token = localStorage.getItem('authToken');
    return {
        'Authorization': token ? `Bearer ${token}` : undefined, // Only set Authorization if token exists
        'Content-Type': 'application/json'
    };
}
const ApiService = {
    init() {
        // Set the base URL once during initialization
        redaxios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;

        // Ensure headers and common objects are initialized
        // if (!redaxios.defaults.headers) {
        //     redaxios.defaults.headers = {};
        // }
        // if (!redaxios.defaults.headers.common) {
        //     redaxios.defaults.headers.common = {};
        // }

        // this.setAuthHeader();
    },

    setAuthHeader() {
        const token = localStorage.getItem('authToken');
        return {
            'Authorization': token ? `Bearer ${token}` : undefined, // Only set Authorization if token exists
            'Content-Type': 'application/json'
        };
    },

    get(resource) {
        console.log(redaxios.defaults)
        return redaxios.get(resource,{ headers: getAuthHeaders() });
    },

    post(resource, data) {
        return redaxios.post(resource, data, { headers: getAuthHeaders() });
    },

    put(resource, data) {
        return redaxios.put(resource, data, { headers: getAuthHeaders() });
    },

    delete(resource) {
        return redaxios.delete(resource,{ headers: getAuthHeaders() });
    },

    async login(resource, data) {
        // this.init()
        const response = await redaxios.post(resource, data, {
            headers: {
                'Content-Type': 'application/json'
            }
        });

        // if (response.data.token) {
        //     this.setAuthHeader();
        // }
        return response;
    },

    logout() {
        // localStorage.removeItem('authToken');
        delete redaxios.defaults.headers.common['Authorization'];
        // You might want to redirect the user to the login page or perform other cleanup actions here.
    },


    // Add other methods here (post, put, delete, etc.) as needed
};

export default ApiService;
