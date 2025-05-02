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
      console.log(response.data); // Depuración adicional
  
      // Verificar si la respuesta es un array
      if (Array.isArray(response.data)) {
        const datosFormateados = response.data.map(item => ({
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
        setDatos([]); // Vaciar si no hay datos válidos
      }
  
    } catch (error) {
      console.error("Error al obtener amonestaciones:", error);
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
        "Tarjeta roja"
      ]}
      datos={datos} // ← aquí se pasa la info del backend
    />
  );
};

export default Amonestacion;