import React, { useState, useEffect } from 'react';
import './TablaCrud.css';
import logo1 from "../../assets/imagenes/logo1.png";
import axios from 'axios';

const TablaCrud = ({ titulo, columnas, datos: datosExternos = [], endpoint = null, onCrear, onEditar, onEliminar }) => {
  const [form, setForm] = useState({});
  const [modoEdicion, setModoEdicion] = useState(false);
  const [idEditando, setIdEditando] = useState(null);
  const [datosApi, setDatosApi] = useState([]);

  // Si se pasa endpoint, se cargan los datos directamente desde el backend
  useEffect(() => {
    if (endpoint) {
      axios.get(`http://localhost:8000/api${endpoint}`)
        .then((res) => setDatosApi(res.data))
        .catch((err) => console.error("Error al cargar datos:", err));
    }
  }, [endpoint]);

  const datos = endpoint ? datosApi : datosExternos;

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      if (modoEdicion && idEditando !== null) {
        await onEditar(idEditando, form);
      } else {
        await onCrear(form);
      }
    } catch (error) {
      console.error("Error en el formulario:", error);
    }

    setForm({});
    setModoEdicion(false);
    setIdEditando(null);
  };

  const iniciarEdicion = (id, fila) => {
    setModoEdicion(true);
    setIdEditando(id);
    setForm(fila);
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setIdEditando(null);
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

      {onCrear && (
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
          <button type="submit">{modoEdicion ? "Actualizar" : "Agregar"}</button>
          {modoEdicion && <button type="button" onClick={cancelarEdicion}>Cancelar</button>}
        </form>
      )}

      <table className="crud-tabla">
        <thead>
          <tr>
            {columnas.map((col) => (
              <th key={col}>{col}</th>
            ))}
            {(onEditar || onEliminar) && <th>Acciones</th>}
          </tr>
        </thead>
        <tbody>
          {Array.isArray(datos) && datos.length > 0 ? (
            datos.map((fila, index) => (
              <tr key={fila.id || index}>
                {columnas.map((col) => (
                  <td key={col}>{fila[col] || '—'}</td>
                ))}
                {(onEditar || onEliminar) && (
                  <td>
                    {onEditar && <button className="btn-editar" onClick={() => iniciarEdicion(fila.id, fila)}>Editar</button>}
                    {onEliminar && <button className="btn-eliminar" onClick={() => onEliminar(fila.id)}>Eliminar</button>}

                  </td>
                )}
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan={columnas.length + 1}>No hay datos disponibles</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default TablaCrud;