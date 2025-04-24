import React, { useState } from "react";
import axios from 'axios';
import "bootstrap/dist/css/bootstrap.min.css";
import fondo_suscripcion from "../../assets/imagenes/fondo_suscripcion.png";
import "../../index.css";

const Suscribirse = () => {
  const [formData, setFormData] = useState({
    tipo_documento: "",
    numero_documento: "",
    genero: "",
    nombres: "",
    apellidos: "",
    edad: "",
    email: "",
    contrasena: "",
    confirmar_contrasena: "",
    tipo_torneo: "",
    forma_pago: "",
  });

  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    setError(null);

    if (formData.contrasena !== formData.confirmar_contrasena) {
      setError("Las contraseñas no coinciden.");
      setIsSubmitting(false);
      return;
    }

    try {
      const response = await axios.post('http://localhost:8000/api/suscripcion', formData);
      setSuccess(true);
      setFormData({
        tipo_documento: "",
        numero_documento: "",
        genero: "",
        nombres: "",
        apellidos: "",
        edad: "",
        email: "",
        contrasena: "",
        confirmar_contrasena: "",
        tipo_torneo: "",
        forma_pago: "",
      });
    } catch (err) {
      if (err.response) {
        if (err.response.data.errors) {
          const errorMessages = Object.values(err.response.data.errors).flat();
          setError(errorMessages.join(' '));
        } else {
          setError(err.response.data.message || 'Error al registrar');
        }
      } else {
        setError('Error de conexión con el servidor');
      }
      setSuccess(false);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div
      style={{
        position: "relative",
        backgroundImage: `url(${fondo_suscripcion})`,
        backgroundSize: "cover",
        backgroundPosition: "center",
        minHeight: "100vh",
        paddingTop: "0.5cm",
      }}
    >
      <div className="suscripcion-container">
        <form className="suscripcion bg-white p-4 rounded shadow" onSubmit={handleSubmit}>
          <h4 className="mb-4 text-center">Suscripción</h4>

          {error && <div className="alert alert-danger">{error}</div>}
          {success && <div className="alert alert-success">¡Registro exitoso! Gracias por suscribirte.</div>}

          {/* Tipo de documento */}
          <div className="mb-3">
            <label htmlFor="tipo_documento">Tipo de documento</label>
            <select
              name="tipo_documento"
              className="form-control"
              value={formData.tipo_documento}
              onChange={handleChange}
              id="tipo_documento"
              autoComplete="off"
            >
              <option value="">Seleccione una opción</option>
              <option value="Cedula de ciudadania">Cédula de ciudadanía</option>
              <option value="Tarjeta de identidad">Tarjeta de identidad</option>
            </select>
          </div>

          {/* Número de documento */}
          <div className="mb-3">
            <label htmlFor="numero_documento">Número de documento</label>
            <input
              type="text"
              name="numero_documento"
              id="numero_documento"
              className="form-control"
              placeholder="Ingrese número de documento"
              value={formData.numero_documento}
              onChange={handleChange}
              required
              minLength={8}
              maxLength={10}
              pattern="\d{8,10}"
              title="Debe contener entre 8 y 10 números"
              autoComplete="off"
            />
          </div>

          {/* Género */}
          <div className="mb-3">
            <label htmlFor="genero">Género</label>
            <select
              name="genero"
              className="form-control"
              value={formData.genero}
              onChange={handleChange}
              id="genero"
              autoComplete="off"
            >
              <option value="">Seleccione una opción</option>
              <option value="hombre">Hombre</option>
              <option value="mujer">Mujer</option>
              <option value="otro">Otro</option>
            </select>
          </div>

          {/* Nombres */}
          <div className="mb-3">
            <label htmlFor="nombres">Nombre</label>
            <input
              type="text"
              name="nombres"
              id="nombres"
              className="form-control"
              placeholder="Ingrese nombre"
              value={formData.nombres}
              onChange={handleChange}
              required
              autoComplete="given-name"
            />
          </div>

          {/* Apellidos */}
          <div className="mb-3">
            <label htmlFor="apellidos">Apellidos</label>
            <input
              type="text"
              name="apellidos"
              id="apellidos"
              className="form-control"
              placeholder="Ingrese apellidos"
              value={formData.apellidos}
              onChange={handleChange}
              required
              autoComplete="family-name"
            />
          </div>

          {/* Edad */}
          <div className="mb-3">
            <label htmlFor="edad">Edad</label>
            <input
              type="number"
              name="edad"
              id="edad"
              className="form-control"
              placeholder="Ingrese edad"
              value={formData.edad}
              onChange={handleChange}
              required
              min={15}
              max={60}
              autoComplete="off"
            />
          </div>

          {/* Tipo de Torneo */}
          <div className="mb-3">
            <label htmlFor="tipo_torneo">Tipo de Torneo</label>
            <select
              name="tipo_torneo"
              className="form-control"
              value={formData.tipo_torneo}
              onChange={handleChange}
              id="tipo_torneo"
              autoComplete="off"
            >
              <option value="">Seleccione una opción</option>
              <option value="Torneo Liga">Torneo Liga</option>
              <option value="Torneo Relámpago">Torneo Relámpago</option>
              <option value="Torneo de Categorías">Torneo de Categorías</option>
              <option value="Eliminación Directa">Eliminación Directa</option>
            </select>
          </div>

          {/* Forma de Pago */}
          <div className="mb-4">
            <label htmlFor="forma_pago">Forma de Pago</label>
            <select
              name="forma_pago"
              className="form-control"
              value={formData.forma_pago}
              onChange={handleChange}
              id="forma_pago"
              autoComplete="off"
            >
              <option value="">Seleccione una opción</option>
              <option value="Nequi">Nequi</option>
              <option value="Daviplata">Daviplata</option>
              <option value="PSE">PSE</option>
            </select>
          </div>

          {/* Email */}
          <div className="mb-3">
            <label htmlFor="email">Correo electrónico</label>
            <input
              type="email"
              name="email"
              id="email"
              className="form-control"
              placeholder="example@domain.com"
              value={formData.email}
              onChange={handleChange}
              required
              autoComplete="email"
            />
          </div>

          {/* Contraseña */}
          <div className="mb-3">
            <label htmlFor="contrasena">Crear contraseña</label>
            <input
              type="password"
              name="contrasena"
              id="contrasena"
              className="form-control"
              value={formData.contrasena}
              onChange={handleChange}
              required
              autoComplete="new-password"
            />
          </div>

          {/* Confirmar contraseña */}
          <div className="mb-3">
            <label htmlFor="confirmar_contrasena">Confirmar contraseña</label>
            <input
              type="password"
              name="confirmar_contrasena"
              id="confirmar_contrasena"
              className="form-control"
              value={formData.confirmar_contrasena}
              onChange={handleChange}
              required
              autoComplete="new-password"
            />
          </div>

          {/* Términos */}
          <p>
            Estoy de acuerdo con los{" "}
            <a href="#" target="_blank" rel="noreferrer">Términos y Condiciones</a>
          </p>

          <button 
            type="submit" 
            className="btn btn-primary w-100"
            disabled={isSubmitting}
          >
            {isSubmitting ? 'Registrando...' : 'Registrar'}
          </button>

          <p className="mt-3 text-center">
            <a href="/login_participante">¿Ya tengo cuenta?</a>
          </p>
        </form>
      </div>
    </div>
  );
};

export default Suscribirse;