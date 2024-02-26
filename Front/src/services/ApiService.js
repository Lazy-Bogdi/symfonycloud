import redaxios from 'redaxios';

const ApiService = {
    init() {
        // Set the base URL once during initialization
        redaxios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
        // Setup token if available
        const token = localStorage.getItem('authToken');
        if (token) {
            redaxios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    },


    get(resource) {
        return redaxios.get(resource);
    },

    post(resource, data) {
        const completeUrl = import.meta.env.VITE_API_BASE_URL + resource;
        redaxios.defaults.baseURL = completeUrl
        console.log(completeUrl);
        return redaxios.post(completeUrl, data);
    },

    async login(resource, data) {
        const completeUrl = import.meta.env.VITE_API_BASE_URL + resource;
        return await redaxios.post(completeUrl, data, {
            headers: {
                'Content-Type': 'application/json',
                // Include other headers here if needed
            }
        });
    },


    // Add other methods here (post, put, delete, etc.) as needed
};

export default ApiService;
