import React, { useState, useEffect } from 'react';
import './TablaCrud.css';
import logo1 from "../../assets/imagenes/logo1.png";
import axios from 'axios'; // Asegúrate de tener axios instalado

const TablaCrud = ({ titulo, columnas, datos: datosExternos = [], endpoint = null }) => {
  const [form, setForm] = useState({});
  const [datosLocales, setDatosLocales] = useState([]);
  const [datosApi, setDatosApi] = useState([]);

  // Cargar datos desde endpoint si se proporciona
  useEffect(() => {
    if (endpoint) {
      axios.get(`http://localhost:8000/api${endpoint}`) // Ajusta si tu backend tiene otro dominio/puerto
        .then((res) => setDatosApi(res.data))
        .catch((err) => console.error("Error al cargar datos:", err));
    }
  }, [endpoint]);

  const datos = endpoint ? datosApi : (datosExternos.length > 0 ? datosExternos : datosLocales);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setDatosLocales([...datosLocales, form]);
    setForm({});
  };

  return (
    <div className="crud-contenedor">
      <div className="logo-fondo">
        {[...Array(5)].map((_, i) => (
          <img key={i} src={logo1} alt="Logo" className={`logo-small logo${i + 1}`} />
        ))}
      </div>

      <h2>{titulo}</h2>

      {!endpoint && (
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
      )}

      <table className="crud-tabla">
        <thead>
          <tr>
            {columnas.map((col) => (
              <th key={col}>{col}</th>
            ))}
          </tr>
        </thead>
        <tbody>
            {console.log(datos)} {/* Esto es solo para depuración */}
            {Array.isArray(datos) && datos.length > 0 ? (
              datos.map((fila, index) => (
                <tr key={index}>
                {columnas.map((col) => (
                <td key={col}>{fila[col] || '—'}</td>
                    ))}
              </tr>
                    ))
                    ) : (
                <tr>
                  <td colSpan={columnas.length}>No hay datos disponibles</td>
                </tr>
              )}
            </tbody>


          </table>
    </div>
  );
};

export default TablaCrud;