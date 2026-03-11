import axios from 'axios';

// Create axios instance with base URL and headers
const api = axios.create({
  baseURL: '/api', // Use relative URL for proper proxy handling
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true,
  withXSRFToken: true
});

// Add CSRF token to all requests
api.interceptors.request.use(config => {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (token) {
    config.headers['X-CSRF-TOKEN'] = token;
  }
  return config;
});

// Response interceptor for handling errors
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Handle unauthorized access
      console.error('Unauthorized access - please login');
      // You can redirect to login page here if needed
    }
    return Promise.reject(error);
  }
);

// API endpoints
export const companiesApi = {
  getAll: () => api.get('/companies'),
  getOne: (id) => api.get(`/companies/${id}`),
  create: (data) => api.post('/companies', data),
  update: (id, data) => api.put(`/companies/${id}`, data),
  delete: (id) => api.delete(`/companies/${id}`)
};

export const venuesApi = {
  getByCompany: (companyId) => api.get(`/companies/${companyId}/venues`),
  getOne: (companyId, venueId) => api.get(`/companies/${companyId}/venues/${venueId}`),
  create: (companyId, data) => api.post(`/companies/${companyId}/venues`, data),
  update: (companyId, venueId, data) => api.put(`/companies/${companyId}/venues/${venueId}`, data),
  delete: (companyId, venueId) => api.delete(`/companies/${companyId}/venues/${venueId}`)
};

export const tablesApi = {
  getByVenue: (venueId) => api.get(`/venues/${venueId}/tables`),
  getOne: (venueId, tableId) => api.get(`/venues/${venueId}/tables/${tableId}`),
  create: (venueId, data) => api.post(`/venues/${venueId}/tables`, data),
  update: (venueId, tableId, data) => api.put(`/venues/${venueId}/tables/${tableId}`, data),
  delete: (venueId, tableId) => api.delete(`/venues/${venueId}/tables/${tableId}`)
};

export const menusApi = {
  getByVenue: (venueId) => api.get(`/venues/${venueId}/menus`),
  getOne: (venueId, menuId) => api.get(`/venues/${venueId}/menus/${menuId}`),
  create: (venueId, data) => api.post(`/venues/${venueId}/menus`, data),
  update: (venueId, menuId, data) => api.put(`/venues/${venueId}/menus/${menuId}`, data),
  delete: (venueId, menuId) => api.delete(`/venues/${venueId}/menus/${menuId}`)
};

export const productsApi = {
  getAll: () => api.get('/products'),
  getByVenue: (venueId) => api.get(`/venues/${venueId}/products`),
  getOne: (id) => api.get(`/products/${id}`),
  create: (data) => api.post('/products', data),
  update: (id, data) => api.put(`/products/${id}`, data),
  delete: (id) => api.delete(`/products/${id}`)
};

export const ordersApi = {
  getAll: () => api.get('/orders'),
  getOne: (id) => api.get(`/orders/${id}`),
  create: (data) => api.post('/orders', data),
  update: (id, data) => api.put(`/orders/${id}`, data),
  delete: (id) => api.delete(`/orders/${id}`),
  getByTable: (tableId) => api.get(`/tables/${tableId}/orders`)
};

export default api;
