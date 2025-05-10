import React, { useEffect, useState } from "react";
import {
  getEquipos,
  createEquipo,
  updateEquipo,
  deleteEquipo,
} from "../../api/EquipoService";
import "./EquiposCrud.css";

const EquiposCrud = () => {
  const [equipos, setEquipos] = useState([]);
  const [form, setForm] = useState({
    nombre_de_equipo: "",
    jugadores: [""],
  });
  const [editandoId, setEditandoId] = useState(null);
  const [error, setError] = useState({});

  const cargarDatos = async () => {
    try {
      const res = await getEquipos();
      const data = Array.isArray(res.data) ? res.data : res.data.data;
      setEquipos(data || []);
    } catch (err) {
      console.error("Error al cargar equipos:", err);
    }
  };

  useEffect(() => {
    cargarDatos();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (/^[\p{L}\d ]*$/u.test(value)) {
      setForm({ ...form, [name]: value });
      setError({ ...error, [name]: "" });
    }
  };

  const handleJugadorChange = (index, value) => {
    if (/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/.test(value)) {
      const nuevosJugadores = [...form.jugadores];
      nuevosJugadores[index] = value;
      setForm({ ...form, jugadores: nuevosJugadores });
      setError({ ...error, [`jugador_${index}`]: "" });
    }
  };

  const handleAgregarJugador = () => {
    if (form.jugadores.length < 9) {
      setForm({ ...form, jugadores: [...form.jugadores, ""] });
    }
  };

  const handleEliminarJugador = (index) => {
    const nuevosJugadores = [...form.jugadores];
    nuevosJugadores.splice(index, 1);
    setForm({ ...form, jugadores: nuevosJugadores });
  };

  const handleSubmit = async () => {
    const errores = {};

    if (!form.nombre_de_equipo.trim()) {
      errores.nombre_de_equipo = "El nombre del equipo es obligatorio";
    }

    const jugadores = form.jugadores.map((j) => j.trim());

    if (jugadores.length < 6) {
      errores.jugadores = "Debe haber al menos 6 jugadores";
    } else if (jugadores.length > 9) {
      errores.jugadores = "No puede haber más de 9 jugadores";
    }

    const nombresUnicos = new Set(jugadores.map((j) => j.toLowerCase()));
    if (nombresUnicos.size < jugadores.length) {
      errores.jugadores = "No se permiten nombres de jugador repetidos";
    }

    jugadores.forEach((nombre, index) => {
      if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/.test(nombre)) {
        errores[`jugador_${index}`] = "Solo se permiten letras y espacios";
      } else if (nombre.split(" ").length < 2) {
        errores[`jugador_${index}`] = "Debe ingresar al menos nombre y apellido";
      }
    });

    if (Object.keys(errores).length > 0) {
      setError(errores);
      return;
    }

    try {
      if (editandoId) {
        await updateEquipo(editandoId, { ...form, jugadores });
      } else {
        await createEquipo({ ...form, jugadores });
      }

      setForm({ nombre_de_equipo: "", jugadores: [""] });
      setEditandoId(null);
      setError({});
      await cargarDatos();
    } catch (err) {
      console.error("Error al guardar equipo:", err);
    }
  };

  const editarEquipo = (equipo) => {
    setForm({
      nombre_de_equipo: equipo.nombre_de_equipo,
      jugadores: equipo.jugadores || [""],
    });
    setEditandoId(equipo.id);
    setError({});
  };

  const eliminarEquipo = async (id) => {
    try {
      await deleteEquipo(id);
      await cargarDatos();
    } catch (err) {
      console.error("Error al eliminar equipo:", err);
    }
  };

  return (
    <div className="equipos-crud">
      <h2>Equipos Participantes</h2>

      <div className="formulario-doble">
        <div className="columna">
          <input
            name="nombre_de_equipo"
            placeholder="Nombre del equipo"
            value={form.nombre_de_equipo}
            onChange={handleChange}
            className={error.nombre_de_equipo ? "input-error" : ""}
          />
          <button onClick={handleSubmit}>
            {editandoId ? "Actualizar" : "Agregar equipo"}
          </button>
          {error.nombre_de_equipo && (
            <div className="error">{error.nombre_de_equipo}</div>
          )}
        </div>

        <div className="columna">
          {form.jugadores.map((jugador, index) => (
            <div key={index} className="jugador-input">
              <input
                value={jugador}
                onChange={(e) => handleJugadorChange(index, e.target.value)}
                placeholder={`Jugador ${index + 1}`}
                className={error[`jugador_${index}`] ? "input-error" : ""}
              />
              {form.jugadores.length > 1 && (
                <button
                  type="button"
                  className="eliminar-jugador"
                  onClick={() => handleEliminarJugador(index)}
                >
                  X
                </button>
              )}
              {error[`jugador_${index}`] && (
                <div className="error">{error[`jugador_${index}`]}</div>
              )}
            </div>
          ))}

          {form.jugadores.length < 9 && (
            <button
              type="button"
              className="agregar-jugador"
              onClick={handleAgregarJugador}
            >
              + Jugador
            </button>
          )}
          {error.jugadores && <div className="error">{error.jugadores}</div>}
        </div>
      </div>

      {/* Tabla de equipos */}
      <table>
        <thead>
          <tr>
            <th>Nombre de equipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {equipos.map((equipo) => (
            <tr key={equipo.id}>
              <td>
                <span className="equipo-nombre">{equipo.nombre_de_equipo}</span>
                <ul className="jugadores-lista">
                  {equipo.jugadores.map((jugador, index) => (
                    <li key={index}>{jugador}</li>
                  ))}
                </ul>
              </td>
              <td>
                <div className="botones-acciones">
                  <button className="editar" onClick={() => editarEquipo(equipo)}>
                    Editar
                  </button>
                  <button className="eliminar" onClick={() => eliminarEquipo(equipo.id)}>
                    Eliminar
                  </button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default EquiposCrud;