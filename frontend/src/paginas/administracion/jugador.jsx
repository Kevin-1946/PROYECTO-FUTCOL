import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Jugador = () => {
  const columnas = ["Nombre", "N° de documento", "Fecha de nacimiento"];

  return (
    <TablaCrud titulo="Jugadores" columnas={columnas} />
  );
};

export default Jugador;
