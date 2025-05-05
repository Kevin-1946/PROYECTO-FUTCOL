import React, { useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';
import './reset_contrasena.css';

const ResetContrasena = () => {
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);
  
  const { token } = useParams();
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    setError('');

    if (password !== confirmPassword) {
      setError('Las contraseñas no coinciden');
      setIsSubmitting(false);
      return;
    }

    try {
      await axios.post('http://localhost:8000/api/auth/reset-password', {
        token,
        password,
        password_confirmation: confirmPassword
      });
      setSuccess(true);
      setTimeout(() => navigate('/login'), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Error al restablecer la contraseña');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="reset-container">
      <div className="reset-card">
        <h2>Restablecer Contraseña</h2>
        {success ? (
          <div className="reset-success">
            <p>¡Contraseña actualizada correctamente!</p>
            <p>Redirigiendo al login...</p>
          </div>
        ) : (
          <form onSubmit={handleSubmit}>
            {error && <div className="reset-error">{error}</div>}
            <div className="form-group">
              <label>Nueva Contraseña:</label>
              <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                minLength="6"
              />
            </div>
            <div className="form-group">
              <label>Confirmar Contraseña:</label>
              <input
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
                minLength="6"
              />
            </div>
            <button type="submit" disabled={isSubmitting}>
              {isSubmitting ? 'Procesando...' : 'Restablecer Contraseña'}
            </button>
          </form>
        )}
      </div>
    </div>
  );
};

export default ResetContrasena;