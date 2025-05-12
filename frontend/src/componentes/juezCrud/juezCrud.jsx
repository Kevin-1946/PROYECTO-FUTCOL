import React, { useEffect, useState } from "react";
import {
  getJueces,
  createJuez,
  updateJuez,
  deleteJuez,
} from "../../api/JuezService";
import { getEncuentros } from "../../api/EncuentrosService"; // Asegúrate de crear esto
import "./JuezCrud.css";

const JuezCrud = () => {
  const [jueces, setJueces] = useState([]);
  const [encuentros, setEncuentros] = useState([]);
  const [form, setForm] = useState({
    nombre: "",
    numero_de_contacto: "",
    sede: "",
    encuentros_id: "",
  });
  const [editId, setEditId] = useState(null);
  const [errors, setErrors] = useState({});

  const fetchJueces = async () => {
    try {
      const res = await getJueces();
      setJueces(res.data);
    } catch (err) {
      console.error("Error al cargar jueces:", err);
    }
  };

  const fetchEncuentros = async () => {
    try {
      const res = await getEncuentros();
      setEncuentros(res.data);
    } catch (err) {
      console.error("Error al cargar encuentros:", err);
    }
  };

  useEffect(() => {
    fetchJueces();
    fetchEncuentros();
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const validateForm = () => {
    const newErrors = {};

    if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ]+(?:\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)+$/.test(form.nombre)) {
      newErrors.nombre = "Debe contener solo letras y al menos dos palabras.";
    }

    if (!/^\d{7,10}$/.test(form.numero_de_contacto)) {
      newErrors.numero_de_contacto = "Solo números (7 a 10 dígitos, sin espacios).";
    }

    if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s]+$/.test(form.sede)) {
      newErrors.sede = "Solo letras, números y espacios.";
    }

    if (!form.encuentros_id) {
      newErrors.encuentros_id = "Debes seleccionar un encuentro.";
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
        response = await updateJuez(editId, form);
      } else {
        response = await createJuez(form);
      }

      if (response?.data?.errors) {
        setErrors(response.data.errors);
      } else {
        setForm({
          nombre: "",
          numero_de_contacto: "",
          sede: "",
          encuentros_id: "",
        });
        setEditId(null);
        setErrors({});
        fetchJueces();
      }
    } catch (err) {
      console.error("Error al guardar juez:", err);
      alert("Ocurrió un error inesperado.");
    }
  };

  const handleEdit = (juez) => {
    setForm({
      nombre: juez.nombre,
      numero_de_contacto: juez.numero_de_contacto,
      sede: juez.sede,
      encuentros_id: juez.encuentros_id,
    });
    setEditId(juez.id);
    setErrors({});
  };

  const handleDelete = async (id) => {
    if (window.confirm("¿Estás seguro de que quieres eliminar este juez?")) {
      await deleteJuez(id);
      fetchJueces();
    }
  };

  return (
    <div className="juez-crud">
      <h2>Jueces</h2>
      <form onSubmit={handleSubmit} className="juez-form">
        <input
          type="text"
          name="nombre"
          placeholder="Nombre completo"
          value={form.nombre}
          onChange={handleChange}
          className={errors.nombre ? "error" : ""}
        />
        {errors.nombre && <div className="error-message">{errors.nombre}</div>}

        <input
          type="text"
          name="numero_de_contacto"
          placeholder="Número de contacto"
          value={form.numero_de_contacto}
          onChange={handleChange}
          className={errors.numero_de_contacto ? "error" : ""}
        />
        {errors.numero_de_contacto && (
          <div className="error-message">{errors.numero_de_contacto}</div>
        )}

        <input
          type="text"
          name="sede"
          placeholder="Sede"
          value={form.sede}
          onChange={handleChange}
          className={errors.sede ? "error" : ""}
        />
        {errors.sede && <div className="error-message">{errors.sede}</div>}

        <select
          name="encuentros_id"
          value={form.encuentros_id}
          onChange={handleChange}
          className={errors.encuentros_id ? "error" : ""}
        >
          <option value="">Selecciona un encuentro</option>
          {encuentros.map((e) => (
            <option key={e.id} value={e.id}>
              {e.nombre || `Encuentro #${e.id}`} {/* Ajusta según tus datos */}
            </option>
          ))}
        </select>
        {errors.encuentros_id && (
          <div className="error-message">{errors.encuentros_id}</div>
        )}

        <button type="submit">{editId ? "Actualizar" : "Crear"}</button>
      </form>

      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Sede</th>
            <th>Encuentro</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {jueces.length === 0 ? (
            <tr>
              <td colSpan="5" style={{ textAlign: "center", padding: "10px" }}>
                No hay jueces registrados.
              </td>
            </tr>
          ) : (
            jueces.map((juez) => (
              <tr key={juez.id}>
                <td>{juez.nombre}</td>
                <td>{juez.numero_de_contacto}</td>
                <td>{juez.sede}</td>
                <td>{juez.encuentro?.nombre || `ID ${juez.encuentros_id}`}</td>
                <td>
                  <button onClick={() => handleEdit(juez)}>Editar</button>
                  <button onClick={() => handleDelete(juez.id)}>Eliminar</button>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default JuezCrud;