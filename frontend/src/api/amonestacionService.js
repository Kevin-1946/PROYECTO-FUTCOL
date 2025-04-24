
import api from "./api";

export const getAmonestaciones = () => api.get("/amonestaciones");

export const getAmonestacion = (id) => api.get(`/amonestaciones/${id}`);

export const createAmonestacion = (data) => api.post("/amonestaciones", data);

export const updateAmonestacion = (id, data) => api.put(`/amonestaciones/${id}`, data);

export const deleteAmonestacion = (id) => api.delete(`/amonestaciones/${id}`);