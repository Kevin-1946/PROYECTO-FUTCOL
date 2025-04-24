import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Encuentros = () => {
  const columnas = ["Sede", "Fecha", "Hora"];

  return (
    <TablaCrud titulo="Encuentros" columnas={columnas} />
  );
};

export default Encuentros;
