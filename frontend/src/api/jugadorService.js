import api from "./api";

// Obtener todos los jugadores
export const getJugadores = () => api.get("/jugadores");

// Obtener un solo jugador por ID
export const getJugador = (id) => api.get(`/jugadores/${id}`);

// Crear un nuevo jugador
export const createJugador = (data) => api.post("/jugadores", data);

// Actualizar completamente un jugador (PUT)
export const updateJugador = (id, data) => api.put(`/jugadores/${id}`, data);

// Actualizar parcialmente un jugador (PATCH)
export const updateJugadorParcial = (id, data) => api.patch(`/jugadores/${id}`, data);

// Eliminar un jugador
export const deleteJugador = (id) => api.delete(`/jugadores/${id}`);