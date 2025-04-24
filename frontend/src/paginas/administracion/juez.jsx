import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Juez = () => {
  const columnas = ["Nombre", "Número de contacto"];

  return (
    <TablaCrud titulo="Jueces Disponibles" columnas={columnas} />
  );
};

export default Juez;
