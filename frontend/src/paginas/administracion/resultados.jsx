import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Resultados = () => {
  const columnas = [
    "Equipo",
    "Puntos",
    "Partidos Jugados",
    "Goles a Favor",
    "Goles en Contra",
    "Diferencia de Goles"
  ];

  return (
    <TablaCrud titulo="Resultados" columnas={columnas} />
  );
};

export default Resultados;
