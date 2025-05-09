import api from "./api";

// Obtener todos los encuentros
export const getEncuentros = () => api.get("/encuentros");

// Obtener un solo encuentro por ID
export const getEncuentro = (id) => api.get(`/encuentros/${id}`);

// Crear un nuevo encuentro
export const createEncuentro = (data) => api.post("/encuentros", data);

// Actualizar un encuentro existente
export const updateEncuentro = (id, data) => api.put(`/encuentros/${id}`, data);

// Eliminar un encuentro
export const deleteEncuentro = (id) => api.delete(`/encuentros/${id}`);
