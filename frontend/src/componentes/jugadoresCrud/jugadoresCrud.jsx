import React, { useEffect, useState } from "react";
import {
  getJugadores,
  createJugador,
  updateJugador,
  deleteJugador,
} from "../../api/JugadorService";
import "./JugadoresCrud.css";

const JugadoresCrud = () => {
  const [jugadores, setJugadores] = useState([]);
  const [form, setForm] = useState({
    nombre_jugador: "",
    numero_camiseta: "",
    edad: "",
    nombre_equipo: "",
    goles_a_favor: "",
  });
  const [editId, setEditId] = useState(null);
  const [errors, setErrors] = useState({});

  const fetchJugadores = async () => {
    const res = await getJugadores();
    setJugadores(res.data);
  };

  useEffect(() => {
    fetchJugadores();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const validateForm = () => {
    const newErrors = {};
    if (!form.nombre_jugador) {
      newErrors.nombre_jugador = "El nombre del jugador es obligatorio";
    }
    if (
      form.numero_camiseta === "" ||
      isNaN(form.numero_camiseta) ||
      form.numero_camiseta < 0 ||
      form.numero_camiseta > 99
    ) {
      newErrors.numero_camiseta = "El número de camiseta debe estar entre 0 y 99";
    }
    if (form.edad === "" || isNaN(form.edad) || form.edad < 15 || form.edad > 60) {
      newErrors.edad = "La edad debe estar entre 15 y 60 años";
    }
    if (!form.nombre_equipo) {
      newErrors.nombre_equipo = "El nombre del equipo es obligatorio";
    }
    if (
      form.goles_a_favor === "" ||
      isNaN(form.goles_a_favor) ||
      form.goles_a_favor < 0 ||
      form.goles_a_favor > 99
    ) {
      newErrors.goles_a_favor = "Los goles a favor deben estar entre 0 y 99";
    }
    return newErrors;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formErrors = validateForm();
    if (Object.keys(formErrors).length > 0) {
      setErrors(formErrors);
      return;
    }

    try {
      let response;
      if (editId) {
        response = await updateJugador(editId, form);
      } else {
        response = await createJugador(form);
      }

      if (response && response.data.errors) {
        setErrors(response.data.errors);
      } else {
        setForm({
          nombre_jugador: "",
          numero_camiseta: "",
          edad: "",
          nombre_equipo: "",
          goles_a_favor: "",
        });
        setEditId(null);
        setErrors({});
        fetchJugadores();
      }
    } catch (err) {
      console.error("Error al enviar el formulario:", err);
      if (err.response && err.response.data && err.response.data.errors) {
        setErrors(err.response.data.errors);
      } else {
        alert("Ocurrió un error inesperado al guardar el jugador.");
      }
    }
  };

  const handleEdit = (jugador) => {
    setForm(jugador);
    setEditId(jugador.id);
    setErrors({});
  };

  const handleDelete = async (id) => {
    if (window.confirm("¿Estás seguro de que quieres eliminar este jugador?")) {
      await deleteJugador(id);
      fetchJugadores();
    }
  };

  return (
    <div className="jugadores-crud">
      <h2>Jugadores</h2>
      <form onSubmit={handleSubmit} className="jugador-form">
        <input
          type="text"
          name="nombre_jugador"
          placeholder="Nombre del jugador"
          value={form.nombre_jugador}
          onChange={handleChange}
          className={errors.nombre_jugador ? "error" : ""}
        />
        {errors.nombre_jugador && <div className="error-message">{errors.nombre_jugador}</div>}

        <input
          type="number"
          name="numero_camiseta"
          placeholder="N° camiseta"
          value={form.numero_camiseta}
          onChange={handleChange}
          className={errors.numero_camiseta ? "error" : ""}
        />
        {errors.numero_camiseta && <div className="error-message">{errors.numero_camiseta}</div>}

        <input
          type="number"
          name="edad"
          placeholder="Edad"
          value={form.edad}
          onChange={handleChange}
          className={errors.edad ? "error" : ""}
        />
        {errors.edad && <div className="error-message">{errors.edad}</div>}

        <input
          type="text"
          name="nombre_equipo"
          placeholder="Nombre del equipo"
          value={form.nombre_equipo}
          onChange={handleChange}
          className={errors.nombre_equipo ? "error" : ""}
        />
        {errors.nombre_equipo && <div className="error-message">{errors.nombre_equipo}</div>}

        <input
          type="number"
          name="goles_a_favor"
          placeholder="Goles a favor"
          value={form.goles_a_favor}
          onChange={handleChange}
          className={errors.goles_a_favor ? "error" : ""}
        />
        {errors.goles_a_favor && <div className="error-message">{errors.goles_a_favor}</div>}

        <button type="submit">{editId ? "Actualizar" : "Crear"}</button>
      </form>

      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Camiseta</th>
            <th>Edad</th>
            <th>Equipo</th>
            <th>Goles</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {jugadores.length === 0 ? (
            <tr>
              <td colSpan="6" style={{ textAlign: "center", padding: "10px" }}>
                No hay jugadores registrados.
              </td>
            </tr>
          ) : (
            jugadores.map((j) => (
              <tr key={j.id}>
                <td>{j.nombre_jugador}</td>
                <td>{j.numero_camiseta}</td>
                <td>{j.edad}</td>
                <td>{j.nombre_equipo}</td>
                <td>{j.goles_a_favor}</td>
                <td>
                  <button onClick={() => handleEdit(j)}>Editar</button>
                  <button onClick={() => handleDelete(j.id)}>Eliminar</button>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default JugadoresCrud;