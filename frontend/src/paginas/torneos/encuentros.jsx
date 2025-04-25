import React, { useEffect, useState } from "react";
import "../../componentes/tablacrud/TablaCrud.css";
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Encuentros = () => {
  const [datos, setDatos] = useState([]);

  const columnas = ["Sede", "Fecha", "Hora", "Partido"];

  useEffect(() => {
    // Simulación temporal, reemplazar con fetch a la API en producción
    const encuentrosActuales = [
      {
        sede: "",
        fecha: "",
        hora: "",
        local: "",
        visitante: "",
      },
      {
        sede: "",
        fecha: "",
        hora: "",
        local: "",
        visitante: "",
      },
    ];

    const datosFormateados = encuentrosActuales.map((encuentro) => ({
      Sede: encuentro.sede,
      Fecha: encuentro.fecha,
      Hora: encuentro.hora,
      Partido: `${encuentro.local} vs ${encuentro.visitante}`,
    }));

    setDatos(datosFormateados);
  }, []);

  return (
    <TablaCrud titulo="Encuentros" columnas={columnas} datos={datos} />
  );
};

export default Encuentros;