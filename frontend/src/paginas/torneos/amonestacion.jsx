import React, { useEffect, useState } from "react";
import TablaCrud from "../../componentes/tablacrud/TablaCrud";
import {
  getAmonestaciones,
  createAmonestacion,
} from "../../api/amonestacionService"; // importa las funciones del servicio

const Amonestacion = () => {
  const [datos, setDatos] = useState([]);

  // Cargar datos al iniciar el componente
  useEffect(() => {
    cargarDatos();
  }, []);

  const cargarDatos = async () => {
    try {
      const response = await getAmonestaciones();
      const datosFormateados = response.data.map(item => ({
        "Tarjeta amarilla": item.tarjeta_amarilla,
        "Tarjeta azul": item.tarjeta_azul,
        "Tarjeta roja": item.tarjeta_roja,
      }));
      setDatos(datosFormateados);
    } catch (error) {
      console.error("Error al obtener amonestaciones:", error);
    }
  };

  return (
    <TablaCrud
      titulo="Amonestaciones"
      columnas={["Tarjeta amarilla", "Tarjeta azul", "Tarjeta roja"]}
      datos={datos} // ← aquí se pasa la info del backend
    />
  );
};

export default Amonestacion;
