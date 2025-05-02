import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const Juez = () => {
  const columnas = ["Nombre", "Número de contacto", "Sede", "Encuentro"];

  return (
    <TablaCrud 
      titulo="Jueces" 
      columnas={columnas}
      endpoint="/jueces" // <- Asegúrate que este sea el endpoint correcto del backend
    />
  );
};

export default Juez;