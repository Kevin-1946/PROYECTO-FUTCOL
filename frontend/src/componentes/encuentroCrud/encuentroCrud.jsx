import React, { useEffect, useState } from "react";
import {
  getEncuentros,
  createEncuentro,
  updateEncuentro,
  deleteEncuentro,
} from "../../services/encuentroService";
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

  const cargarDatos = async () => {
    const res = await getEncuentros();
    setEncuentros(res.data);
  };

  useEffect(() => {
    cargarDatos();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async () => {
    if (editandoId) {
      await updateEncuentro(editandoId, form);
    } else {
      await createEncuentro(form);
    }
    setForm({ sede: "", fecha: "", hora: "", local: "", visitante: "" });
    setEditandoId(null);
    await cargarDatos();
  };

  const handleEditar = (encuentro) => {
    setForm(encuentro);
    setEditandoId(encuentro.id);
  };

  const handleEliminar = async (id) => {
    await deleteEncuentro(id);
    await cargarDatos();
  };

  return (
    <div className="encuentro-crud">
      <h2>Gestión de Encuentros</h2>
      <div className="formulario">
        <input name="sede" placeholder="Sede" value={form.sede} onChange={handleChange} />
        <input type="date" name="fecha" value={form.fecha} onChange={handleChange} />
        <input type="time" name="hora" value={form.hora} onChange={handleChange} />
        <input name="local" placeholder="Local" value={form.local} onChange={handleChange} />
        <input name="visitante" placeholder="Visitante" value={form.visitante} onChange={handleChange} />
        <button onClick={handleSubmit}>{editandoId ? "Actualizar" : "Agregar"}</button>
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
              <td>{e.local} vs {e.visitante}</td>
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