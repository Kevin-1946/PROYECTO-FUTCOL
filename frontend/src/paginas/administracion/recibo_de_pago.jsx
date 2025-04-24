import React from "react";
import '../../componentes/tablacrud/TablaCrud.css';
import TablaCrud from "../../componentes/tablacrud/TablaCrud";

const ReciboDePago = () => {
  const columnas = ["Confirmación de pago", "Fecha de emisión", "Monto"];

  return (
    <TablaCrud titulo="Recibos de Pago" columnas={columnas} />
  );
};

export default ReciboDePago;
