import React, { useEffect, useState } from "react";
import TablaCrud from "../tablacrud/TablaCrud"; // ajusta si cambia de ubicación
import {
  getAmonestaciones,
  createAmonestacion,
  updateAmonestacion,
  deleteAmonestacion,
} from "../../api/amonestacionService";
import "./AmonestacionCrud.css"; // Estilos opcionales

const AmonestacionCrud = () => {
  const [datos, setDatos] = useState([]);

  // Cargar los datos iniciales al montar el componente
  useEffect(() => {
    cargarDatos();
  }, []);

  // Función para cargar las amonestaciones desde el backend
  const cargarDatos = async () => {
    try {
      const response = await getAmonestaciones();

      // Verifica si la respuesta contiene un arreglo
      if (Array.isArray(response.data)) {
        const datosFormateados = response.data.map(item => ({
          id: item.id,
          "Nombre del jugador": item.nombre_jugador,
          "Número de camiseta": item.numero_camiseta,
          "Equipo que juega": item.equipo,
          "Encuentro disputado": item.encuentro_disputado,
          "Tarjeta amarilla": item.tarjeta_amarilla,
          "Tarjeta azul": item.tarjeta_azul,
          "Tarjeta roja": item.tarjeta_roja,
        }));
        setDatos(datosFormateados); // Actualiza el estado con los datos
      } else {
        setDatos([]); // Si no es un arreglo, vacía los datos
      }
    } catch (error) {
      console.error("Error al obtener amonestaciones:", error); // Error al obtener datos
    }
  };

  // Función para manejar la creación de una nueva amonestación
  const manejarCrear = async (nuevo) => {
    try {
      // Aseguramos que los valores sean números y no NaN (usando || 0)
      const dataParaEnviar = {
        nombre_jugador: nuevo["Nombre del jugador"],
        numero_camiseta: parseInt(nuevo["Número de camiseta"]) || 0, // Asegura que sea un número
        equipo: nuevo["Equipo que juega"],
        encuentro_disputado: nuevo["Encuentro disputado"],
        tarjeta_amarilla: parseInt(nuevo["Tarjeta amarilla"]) || 0, // Valor predeterminado 0 si no es un número
        tarjeta_azul: parseInt(nuevo["Tarjeta azul"]) || 0,
        tarjeta_roja: parseInt(nuevo["Tarjeta roja"]) || 0,
      };

      // Validación adicional para asegurarse de que las tarjetas no sean NaN
      if (isNaN(dataParaEnviar.tarjeta_amarilla) ||
          isNaN(dataParaEnviar.tarjeta_azul) ||
          isNaN(dataParaEnviar.tarjeta_roja)) {
        console.error("Algunos valores de tarjetas no son válidos.");
        return; // No enviaremos los datos si hay algún NaN
      }

      await createAmonestacion(dataParaEnviar); // Llamamos a la función para crear la amonestación
      await cargarDatos(); // Recargamos los datos después de la creación
    } catch (error) {
      // En caso de error, mostramos el mensaje en consola
      console.error("Error creando amonestación:", error.response?.data || error.message);
    }
  };

  // Función para manejar la edición de una amonestación existente
  const manejarEditar = async (id, actualizado) => {
    try {
      // Aseguramos que los valores sean números y no NaN (usando || 0)
      const dataParaEnviar = {
        nombre_jugador: actualizado["Nombre del jugador"],
        numero_camiseta: parseInt(actualizado["Número de camiseta"]) || 0,
        equipo: actualizado["Equipo que juega"],
        encuentro_disputado: actualizado["Encuentro disputado"],
        tarjeta_amarilla: parseInt(actualizado["Tarjeta amarilla"]) || 0,
        tarjeta_azul: parseInt(actualizado["Tarjeta azul"]) || 0,
        tarjeta_roja: parseInt(actualizado["Tarjeta roja"]) || 0,
      };

      // Validación adicional para asegurarse de que las tarjetas no sean NaN
      if (isNaN(dataParaEnviar.tarjeta_amarilla) ||
          isNaN(dataParaEnviar.tarjeta_azul) ||
          isNaN(dataParaEnviar.tarjeta_roja)) {
        console.error("Algunos valores de tarjetas no son válidos.");
        return; // No enviaremos los datos si hay algún NaN
      }

      await updateAmonestacion(id, dataParaEnviar); // Llamamos a la función para actualizar la amonestación
      await cargarDatos(); // Recargamos los datos después de la actualización
    } catch (error) {
      // En caso de error, mostramos el mensaje en consola
      console.error("Error actualizando amonestación:", error.response?.data || error.message);
    }
  };

  // Función para manejar la eliminación de una amonestación
  const manejarEliminar = async (id) => {
    try {
      await deleteAmonestacion(id); // Llamamos a la función para eliminar la amonestación
      await cargarDatos(); // Recargamos los datos después de la eliminación
    } catch (error) {
      // En caso de error, mostramos el mensaje en consola
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

export default AmonestacionCrud;