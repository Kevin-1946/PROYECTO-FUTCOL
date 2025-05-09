import React, { useEffect, useState } from "react";
import TablaCrud from "../../componentes/tablacrud/TablaCrud";
import {
  getAmonestaciones,
  createAmonestacion,
  updateAmonestacion,
  deleteAmonestacion,
} from "../../api/amonestacionService";

const Amonestacion = () => {
  const [datos, setDatos] = useState([]);
  const [formulario, setFormulario] = useState({
    nombre_jugador: "",
    numero_camiseta: "",
    equipo: "",
    encuentro_disputado: "",
    tarjeta_amarilla: 0,
    tarjeta_azul: 0,
    tarjeta_roja: 0,
  });

  useEffect(() => {
    cargarDatos();
  }, []);

  const cargarDatos = async () => {
    try {
      const response = await getAmonestaciones();

      if (Array.isArray(response.data)) {
        const datosFormateados = response.data.map(item => ({
          id: item.id, // Importante para editar/eliminar
          "Nombre del jugador": item.nombre_jugador,
          "Número de camiseta": item.numero_camiseta,
          "Equipo que juega": item.equipo,
          "Encuentro disputado": item.encuentro_disputado,
          "Tarjeta amarilla": item.tarjeta_amarilla,
          "Tarjeta azul": item.tarjeta_azul,
          "Tarjeta roja": item.tarjeta_roja,
        }));
        setDatos(datosFormateados);
      } else {
        console.warn("No se recibieron amonestaciones:", response.data.message);
        setDatos([]);
      }
    } catch (error) {
      console.error("Error al obtener amonestaciones:", error);
    }
  };

  // CREAR
  const manejarCrear = async (nuevo) => {
    try {
      await createAmonestacion(nuevo);
      await cargarDatos();
    } catch (error) {
      console.error("Error creando amonestación:", error);
    }
  };

  // EDITAR
  const manejarEditar = async (id, actualizado) => {
    try {
      await updateAmonestacion(id, actualizado);
      await cargarDatos();
    } catch (error) {
      console.error("Error actualizando amonestación:", error);
    }
  };

  // ELIMINAR
  const manejarEliminar = async (id) => {
    try {
      await deleteAmonestacion(id);
      await cargarDatos();
    } catch (error) {
      console.error("Error eliminando amonestación:", error);
    }
  };

  return (
    <TablaCrud
      titulo="Amonestaciones"
      columnas={[
        "Nombre del jugador",
        "Número de camiseta",
        "Equipo que juega",
        "Encuentro disputado",
        "Tarjeta amarilla",
        "Tarjeta azul",
        "Tarjeta roja",
      ]}
      datos={datos}
      onCrear={manejarCrear}
      onEditar={manejarEditar}
      onEliminar={manejarEliminar}
    />
  );
};

export default Amonestacion;