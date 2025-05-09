// AmonestacionCrud.jsx
import React, { useEffect, useState } from "react";
import {
  getAmonestaciones,
  createAmonestacion,
  updateAmonestacion,
  deleteAmonestacion,
} from "../../api/amonestacionService";
import "./AmonestacionCrud.css";

const AmonestacionCrud = () => {
  const [datos, setDatos] = useState([]);
  const [editandoId, setEditandoId] = useState(null);
  const [nuevo, setNuevo] = useState({
    nombre: "",
    camiseta: "",
    equipo: "",
    encuentro: "",
    amarilla: "",
    azul: "",
    roja: "",
  });
  const [errores, setErrores] = useState({});

  useEffect(() => {
    cargarDatos();
  }, []);

  const cargarDatos = async () => {
    try {
      const response = await getAmonestaciones();
      if (Array.isArray(response.data)) {
        const datosFormateados = response.data.map((item) => ({
          id: item.id,
          nombre: item.nombre_jugador,
          camiseta: item.numero_camiseta,
          equipo: item.equipo,
          encuentro: item.encuentro_disputado,
          amarilla: item.tarjeta_amarilla,
          azul: item.tarjeta_azul,
          roja: item.tarjeta_roja,
        }));
        setDatos(datosFormateados);
      } else {
        setDatos([]);
      }
    } catch (error) {
      console.error("Error al obtener amonestaciones:", error);
    }
  };

  const validarCampos = () => {
    const nuevosErrores = {};
    const nombreRegex = /^[A-Za-z\s]+$/;
    const numeroRegex = /^\d{1,2}$/;
    const equipoRegex = /^[A-Za-z0-9\s]+$/;
    const tarjetaRegex = /^\d{1,2}$/;

    if (!nuevo.nombre || !nombreRegex.test(nuevo.nombre)) {
      nuevosErrores.nombre = "Solo letras";
    }

    if (!nuevo.camiseta || !numeroRegex.test(nuevo.camiseta)) {
      nuevosErrores.camiseta = "Solo números (máx. 2 cifras)";
    }

    if (!nuevo.equipo || !equipoRegex.test(nuevo.equipo)) {
      nuevosErrores.equipo = "Sin símbolos especiales";
    }

    if (!nuevo.encuentro) {
      nuevosErrores.encuentro = "Campo requerido";
    }

    if (
      (!nuevo.amarilla || !tarjetaRegex.test(nuevo.amarilla)) &&
      (!nuevo.azul || !tarjetaRegex.test(nuevo.azul)) &&
      (!nuevo.roja || !tarjetaRegex.test(nuevo.roja))
    ) {
      nuevosErrores.amarilla = "Al menos una tarjeta mayor a 0";
      nuevosErrores.azul = "Al menos una tarjeta mayor a 0";
      nuevosErrores.roja = "Al menos una tarjeta mayor a 0";
    }

    setErrores(nuevosErrores);
    return Object.keys(nuevosErrores).length === 0;
  };

  const manejarCrear = async () => {
    if (!validarCampos()) return;

    const dataParaEnviar = {
      nombre_jugador: nuevo.nombre,
      numero_camiseta: parseInt(nuevo.camiseta),
      equipo: nuevo.equipo,
      encuentro_disputado: nuevo.encuentro,
      tarjeta_amarilla: parseInt(nuevo.amarilla) || 0,
      tarjeta_azul: parseInt(nuevo.azul) || 0,
      tarjeta_roja: parseInt(nuevo.roja) || 0,
    };

    try {
      if (editandoId) {
        await updateAmonestacion(editandoId, dataParaEnviar);
      } else {
        await createAmonestacion(dataParaEnviar);
      }

      setNuevo({
        nombre: "",
        camiseta: "",
        equipo: "",
        encuentro: "",
        amarilla: "",
        azul: "",
        roja: "",
      });
      setEditandoId(null);
      setErrores({});
      await cargarDatos();
    } catch (error) {
      console.error("Error al guardar:", error.response?.data || error.message);
    }
  };

  const manejarEditar = (item) => {
    setNuevo({
      nombre: item.nombre,
      camiseta: item.camiseta,
      equipo: item.equipo,
      encuentro: item.encuentro,
      amarilla: item.amarilla,
      azul: item.azul,
      roja: item.roja,
    });
    setEditandoId(item.id);
    setErrores({});
  };

  const manejarEliminar = async (id) => {
    try {
      await deleteAmonestacion(id);
      await cargarDatos();
    } catch (error) {
      console.error("Error eliminando amonestación:", error);
    }
  };

  const handleInputChange = (e, campo) => {
    const valor = e.target.value;
    // Validaciones en tiempo real (opcional)
    setNuevo({ ...nuevo, [campo]: valor });
  };

  return (
    <div className="amonestacion-container">
      <h2 className="amonestacion-title">Amonestaciones</h2>

      <div className="form-row">
        {[
          { nombre: "nombre", placeholder: "Nombre del jugador" },
          { nombre: "camiseta", placeholder: "Número de camiseta" },
          { nombre: "equipo", placeholder: "Equipo que juega" },
          { nombre: "encuentro", placeholder: "Encuentro disputado" },
          { nombre: "amarilla", placeholder: "Amarilla" },
          { nombre: "azul", placeholder: "Azul" },
          { nombre: "roja", placeholder: "Roja" },
        ].map(({ nombre, placeholder }) => (
          <div key={nombre} style={{ display: "flex", flexDirection: "column" }}>
            <input
              placeholder={placeholder}
              value={nuevo[nombre]}
              onChange={(e) => handleInputChange(e, nombre)}
              className={`crud-input ${nombre.match(/amarilla|azul|roja/) ? "tarjeta" : ""} ${
                errores[nombre] ? "input-error" : ""
              }`}
            />
            {errores[nombre] && <span className="error-message">{errores[nombre]}</span>}
          </div>
        ))}

        <button onClick={manejarCrear} className="crud-button edit">
          {editandoId ? "Actualizar" : "Agregar"}
        </button>
      </div>

      <div className="crud-cards">
        {datos.map((item) => (
          <div key={item.id} className="crud-card">
            <div className="crud-fields-row">
              <div className="crud-field"><label>Jugador</label><div>{item.nombre}</div></div>
              <div className="crud-field"><label>Camiseta</label><div>{item.camiseta}</div></div>
              <div className="crud-field"><label>Equipo</label><div>{item.equipo}</div></div>
              <div className="crud-field"><label>Encuentro</label><div>{item.encuentro}</div></div>
              <div className="crud-field"><label>Amarilla</label><div>{item.amarilla}</div></div>
              <div className="crud-field"><label>Azul</label><div>{item.azul}</div></div>
              <div className="crud-field"><label>Roja</label><div>{item.roja}</div></div>
            </div>
            <div className="crud-actions">
              <button onClick={() => manejarEditar(item)} className="crud-button edit">Editar</button>
              <button onClick={() => manejarEliminar(item.id)} className="crud-button delete">Eliminar</button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default AmonestacionCrud;