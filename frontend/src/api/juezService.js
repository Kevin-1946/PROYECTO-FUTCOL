import api from "./api";

// Obtener todos los jueces
export const getJueces = () => api.get("/jueces");

// Obtener un solo juez por ID
export const getJuez = (id) => api.get(`/jueces/${id}`);

// Crear un nuevo juez
export const createJuez = (data) => api.post("/jueces", data);

// Actualizar completamente un juez (PUT)
export const updateJuez = (id, data) => api.put(`/jueces/${id}`, data);

// Actualizar parcialmente un juez (PATCH)
export const updateJuezParcial = (id, data) => api.patch(`/jueces/${id}`, data);

// Eliminar un juez
export const deleteJuez = (id) => api.delete(`/jueces/${id}`);
