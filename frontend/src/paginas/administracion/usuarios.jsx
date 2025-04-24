import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Usuarios = () => {
  const columnas = [
    "Nombres",
    "Apellidos",
    "Tipo de Documento",
    "Número de Documento",
    "Email",
    "Edad",
    "Género",
    "Password"
  ];

  return (
    <TablaCrud titulo="Usuarios Registrados" columnas={columnas} />
  );
};

export default Usuarios;
