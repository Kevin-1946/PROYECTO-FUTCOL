import React, { useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import fondo_login from "../../assets/imagenes/fondo_login.png";
import "../../index.css";

const LoginParticipante = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [showForgotPassword, setShowForgotPassword] = useState(false);
  const [resetEmail, setResetEmail] = useState("");
  const [resetMessage, setResetMessage] = useState("");
  const [resetError, setResetError] = useState("");
  const [isSendingReset, setIsSendingReset] = useState(false);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post("http://localhost:8000/api/auth/login", {
        email,
        password,
      });

      if (response.data.access_token) {
        localStorage.setItem("token", response.data.access_token);
        alert("Inicio de sesión exitoso");
        navigate("/"); 
      } else {
        setError("Correo o contraseña incorrecta");
      }
    } catch (err) {
      console.error(err);
      if (err.response && err.response.status === 401) {
        setError("Correo o contraseña incorrecta");
      } else {
        setError("Ocurrió un error al iniciar sesión");
      }
    }
  };

  const handleForgotPassword = async (e) => {
    e.preventDefault();
    setIsSendingReset(true);
    setResetError("");
    setResetMessage("");

    try {
      const response = await axios.post("http://localhost:8000/api/auth/forgot-password", {
        email: resetEmail,
      });

      if (response.data.message) {
        setResetMessage(response.data.message);
        setResetEmail("");
        setShowForgotPassword(false);
      }
    } catch (err) {
      console.error(err);
      if (err.response && err.response.data.message) {
        setResetError(err.response.data.message);
      } else {
        setResetError("Ocurrió un error al solicitar el restablecimiento");
      }
    } finally {
      setIsSendingReset(false);
    }
  };

  return (
    <>
      <div
        style={{
          position: "relative",
          backgroundImage: `url(${fondo_login})`,
          backgroundSize: "cover",
          backgroundPosition: "center",
          minHeight: "100vh",
          paddingTop: "0.5cm",
        }}
      >
        {/* Capa de opacidad oscura */}
        <div
          style={{
            position: "absolute",
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            backgroundColor: "rgba(0, 0, 0, 0.5)",
            zIndex: 0,
          }}
        />

        <div
          className="d-flex justify-content-center align-items-center"
          style={{
            minHeight: "calc(100vh - 5cm)",
            position: "relative",
            zIndex: 1,
          }}
        >
          <div
            className="login-container p-4 rounded text-white"
            style={{
              backgroundColor: "rgba(0,0,0,0.6)",
              width: "100%",
              maxWidth: "400px",
            }}
          >
            {!showForgotPassword ? (
              <>
                <h2 className="text-center mb-4">Iniciar Sesión</h2>
                {error && <div className="alert alert-danger">{error}</div>}
                {resetMessage && <div className="alert alert-success">{resetMessage}</div>}

                <form onSubmit={handleSubmit}>
                  <div className="form-group mb-3">
                    <label>Email:</label>
                    <input
                      type="email"
                      className="form-control"
                      placeholder="Ingrese su email"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      required
                    />
                  </div>
                  <div className="form-group mb-3">
                    <label>Contraseña:</label>
                    <input
                      type="password"
                      className="form-control"
                      placeholder="Ingrese su contraseña"
                      value={password}
                      onChange={(e) => setPassword(e.target.value)}
                      required
                    />
                  </div>
                  <button type="submit" className="btn btn-primary w-100">
                    Iniciar Sesión
                  </button>
                </form>

                <div className="form-footer mt-3 text-center">
                  <p>
                    <button 
                      className="btn btn-link text-info p-0"
                      onClick={() => setShowForgotPassword(true)}
                    >
                      ¿Olvidaste tu contraseña?
                    </button>
                  </p>
                  <p>
                    ¿No tienes cuenta?{" "}
                    <Link to="/suscribirse" className="text-info">
                      Regístrate aquí
                    </Link>
                  </p>
                </div>
              </>
            ) : (
              <>
                <h2 className="text-center mb-4">Recuperar Contraseña</h2>
                {resetError && <div className="alert alert-danger">{resetError}</div>}

                <form onSubmit={handleForgotPassword}>
                  <div className="form-group mb-3">
                    <label>Ingresa tu email:</label>
                    <input
                      type="email"
                      className="form-control"
                      placeholder="Email registrado"
                      value={resetEmail}
                      onChange={(e) => setResetEmail(e.target.value)}
                      required
                    />
                  </div>
                  <button 
                    type="submit" 
                    className="btn btn-primary w-100"
                    disabled={isSendingReset}
                  >
                    {isSendingReset ? 'Enviando...' : 'Enviar Instrucciones'}
                  </button>
                </form>

                <div className="form-footer mt-3 text-center">
                  <button 
                    className="btn btn-link text-info"
                    onClick={() => setShowForgotPassword(false)}
                  >
                    Volver al inicio de sesión
                  </button>
                </div>
              </>
            )}
          </div>
        </div>
      </div>
    </>
  );
};

export default LoginParticipante;