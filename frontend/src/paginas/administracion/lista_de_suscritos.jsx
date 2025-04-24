import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Suscritos = () => {
  const columnas = ["Documento", "Género", "Nombres", "Apellidos", "Edad", "Email"];

  return (
    <TablaCrud titulo="Lista de Suscritos" columnas={columnas} />
  );
};

export default Suscritos;
