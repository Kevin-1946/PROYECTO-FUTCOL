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

  // Cargar los encuentros al montar el componente
  const cargarDatos = async () => {
    try {
      const res = await getEncuentros();

      // Verifica si es un array o viene envuelto en data
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

  // Maneja cambios en los inputs del formulario
  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  // Guardar o actualizar un encuentro
  const handleSubmit = async () => {
    try {
      // Asegurar que la hora esté en formato H:i:s agregando ":00" si falta
      const horaFormateada = form.hora.length === 5 ? `${form.hora}:00` : form.hora;

      // Crear objeto con datos formateados
      const datos = {
        ...form,
        hora: horaFormateada,
      };

      // Crear o actualizar según el estado
      if (editandoId) {
        await updateEncuentro(editandoId, datos);
      } else {
        await createEncuentro(datos);
      }

      // Limpiar formulario y recargar datos
      setForm({ sede: "", fecha: "", hora: "", local: "", visitante: "" });
      setEditandoId(null);
      await cargarDatos();
    } catch (error) {
      console.error("Error al guardar el encuentro:", error.response?.data || error.message);
    }
  };

  // Cargar datos del encuentro en el formulario para editar
  const handleEditar = (encuentro) => {
    setForm({
      sede: encuentro.sede,
      fecha: encuentro.fecha,
      hora: encuentro.hora.slice(0, 5), // Mostrar solo HH:mm
      local: encuentro.local,
      visitante: encuentro.visitante,
    });
    setEditandoId(encuentro.id);
  };

  // Eliminar un encuentro
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