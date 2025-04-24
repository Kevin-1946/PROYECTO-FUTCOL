import React from "react";
import fondo from "../../assets/imagenes/fondo_inicio.jpeg";
import logo from "../../assets/imagenes/logo1.png";
import "../../index.css";

const Futcol = () => {
  return (
    <div className="futcol-container">
      <div className="hero-image-wrapper">
        <div 
          className="hero-image" 
          style={{ backgroundImage: `url(${fondo})` }}
        ></div>
      </div>
      
      <div className="hero-content">
        <h1 className="bienvenida">¡Bienvenido a FUTCOL!</h1>
        <img src={logo} alt="Logo Futcol" className="logo-central" />
        <p className="descripcion">
          Donde los torneos cobran vida y la pasión por el fútbol se vive al máximo.
        </p>
      </div>
    </div>
  );
};

export default Futcol;