// EncuentroCrud.jsx
import React, { useEffect, useState } from "react";
import {
  getEncuentros,
  createEncuentro,
  updateEncuentro,
  deleteEncuentro,
} from "../../api/EncuentrosService";
import "./EncuentroCrud.css";

const EncuentroCrud = () => {
  const [encuentros, setEncuentros] = useState([]);
  const [form, setForm] = useState({
    sede: "",
    fecha: "",
    hora: "",
    local: "",
    visitante: "",
  });
  const [editandoId, setEditandoId] = useState(null);
  const [errores, setErrores] = useState({});

  const cargarDatos = async () => {
    try {
      const res = await getEncuentros();
      const data = Array.isArray(res.data) ? res.data : res.data.data;
      setEncuentros(data || []);
    } catch (error) {
      console.error("Error al cargar los encuentros:", error);
      setEncuentros([]);
    }
  };

  useEffect(() => {
    cargarDatos();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const validarCampos = () => {
    const erroresNuevos = {};
    const textoRegex = /^[A-Za-z0-9\s]+$/;

    if (!form.sede || !textoRegex.test(form.sede)) {
      erroresNuevos.sede = "Solo letras, números y espacios";
    }

    if (!form.fecha) {
      erroresNuevos.fecha = "Campo obligatorio";
    }

    if (!form.hora) {
      erroresNuevos.hora = "Campo obligatorio";
    }

    if (!form.local || !textoRegex.test(form.local)) {
      erroresNuevos.local = "Solo letras, números y espacios";
    }

    if (!form.visitante || !textoRegex.test(form.visitante)) {
      erroresNuevos.visitante = "Solo letras, números y espacios";
    }

    setErrores(erroresNuevos);
    return Object.keys(erroresNuevos).length === 0;
  };

  const handleSubmit = async () => {
    if (!validarCampos()) return;

    try {
      const horaFormateada = form.hora.length === 5 ? `${form.hora}:00` : form.hora;
      const datos = { ...form, hora: horaFormateada };

      if (editandoId) {
        await updateEncuentro(editandoId, datos);
      } else {
        await createEncuentro(datos);
      }

      setForm({ sede: "", fecha: "", hora: "", local: "", visitante: "" });
      setEditandoId(null);
      setErrores({});
      await cargarDatos();
    } catch (error) {
      console.error("Error al guardar el encuentro:", error.response?.data || error.message);
    }
  };

  const handleEditar = (encuentro) => {
    setForm({
      sede: encuentro.sede,
      fecha: encuentro.fecha,
      hora: encuentro.hora.slice(0, 5),
      local: encuentro.local,
      visitante: encuentro.visitante,
    });
    setEditandoId(encuentro.id);
    setErrores({});
  };

  const handleEliminar = async (id) => {
    try {
      await deleteEncuentro(id);
      await cargarDatos();
    } catch (error) {
      console.error("Error al eliminar el encuentro:", error);
    }
  };

  return (
    <div className="encuentro-crud">
      <h2>Encuentros</h2>
      <div className="formulario">
        {[
          { name: "sede", placeholder: "Sede" },
          { name: "fecha", type: "date" },
          { name: "hora", type: "time" },
          { name: "local", placeholder: "Equipo local" },
          { name: "visitante", placeholder: "Equipo visitante" },
        ].map(({ name, placeholder, type = "text" }) => (
          <div key={name} className="form-group">
            <input
              type={type}
              name={name}
              placeholder={placeholder}
              value={form[name]}
              onChange={handleChange}
              className={errores[name] ? "input-error" : ""}
            />
            {errores[name] && <span className="error-message">{errores[name]}</span>}
          </div>
        ))}

        <button onClick={handleSubmit}>
          {editandoId ? "Actualizar" : "Agregar"}
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>Sede</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Partido</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {encuentros.map((e) => (
            <tr key={e.id}>
              <td>{e.sede}</td>
              <td>{e.fecha}</td>
              <td>{e.hora}</td>
              <td>
                {e.local} vs {e.visitante}
              </td>
              <td>
                <button onClick={() => handleEditar(e)}>Editar</button>
                <button onClick={() => handleEliminar(e.id)}>Eliminar</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default EncuentroCrud;