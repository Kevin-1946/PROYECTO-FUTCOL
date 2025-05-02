import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Equipos = () => {
  const columnas = ["Nombre de equipo", "N° de jugadores"];

  return (
    <TablaCrud titulo="Equipos Participantes" columnas={columnas} />
  );
};

export default Equipos;
