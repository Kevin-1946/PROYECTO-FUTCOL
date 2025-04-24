import React, { useState } from 'react';
import './TablaCrud.css';
import logo1 from "../../assets/imagenes/logo1.png";

// Acepta datos externos (props.datos) y también puede funcionar internamente
const TablaCrud = ({ titulo, columnas, datos: datosExternos = [] }) => {
  // Estado local para formulario
  const [form, setForm] = useState({});
  // Estado local solo si no se reciben datos por props
  const [datosLocales, setDatosLocales] = useState([]);

  // Determina si usamos datos del padre o del estado local
  const datos = datosExternos.length > 0 ? datosExternos : datosLocales;

  // Manejador de cambio de input
  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  // Manejador de envío de formulario (solo agrega a estado local)
  const handleSubmit = (e) => {
    e.preventDefault();
    setDatosLocales([...datosLocales, form]); // Agrega a los datos locales
    setForm({}); // Limpia formulario
  };

  return (
    <div className="crud-contenedor">
      {/* Fondo decorativo con logos */}
      <div className="logo-fondo">
        {[...Array(5)].map((_, i) => (
          <img key={i} src={logo1} alt="Logo" className={`logo-small logo${i + 1}`} />
        ))}
      </div>

      <h2>{titulo}</h2>

      {/* Formulario de ingreso de datos */}
      <form onSubmit={handleSubmit} className="crud-formulario">
        {columnas.map((col) => (
          <input
            key={col}
            type="text"
            name={col}
            placeholder={col}
            value={form[col] || ''}
            onChange={handleChange}
            required
          />
        ))}
        <button type="submit">Agregar</button>
      </form>

      {/* Tabla de datos */}
      <table className="crud-tabla">
        <thead>
          <tr>
            {columnas.map((col) => (
              <th key={col}>{col}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {datos.map((fila, index) => (
            <tr key={index}>
              {columnas.map((col) => (
                <td key={col}>{fila[col]}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default TablaCrud;