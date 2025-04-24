import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Inscripcion = () => {
  const columnas = ["Fecha de inscripción", "Nombre de equipo", "Tipo de torneo"];

  return (
    <TablaCrud titulo="Inscripciones" columnas={columnas} />
  );
};

export default Inscripcion;
