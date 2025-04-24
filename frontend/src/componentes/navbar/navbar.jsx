import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import './navbar.css';

const Navbar = () => {
  const [activeMenu, setActiveMenu] = useState(null);

  const menuEstructurado = [
    { nombre: "Inicio", ruta: "/" },
    {
      nombre: "Torneos",
      ruta: "/torneos",
      subitems: [
        { nombre: "Amonestaciones", ruta: "/torneos/amonestacion" },
        { nombre: "Encuentros", ruta: "/torneos/encuentros" },
        { nombre: "Equipos", ruta: "/torneos/equipos" }
      ]
    },
    {
      nombre: "Administración",
      ruta: "/administracion",
      subitems: [
        { nombre: "Inscripciones", ruta: "/administracion/inscripciones" },
        { nombre: "Recibos", ruta: "/administracion/recibodepago" },
        { nombre: "Resultados", ruta: "/administracion/resultados" },
        { nombre: "Suscritos", ruta: "/administracion/suscritos" },
        { nombre: "Usuarios", ruta: "/administracion/usuarios" }
      ]
    },
    {
      nombre: "Participantes",
      ruta: "/participantes",
      subitems: [
        { nombre: "Jugadores", ruta: "/participantes/jugador" },
        { nombre: "Jueces", ruta: "/participantes/juez" }
      ]
    },
    {
      nombre: "Información",
      ruta: "/informacion/sobre_nosotros" // Redirige directamente
    }
  ];

  const menuDerecha = [
    { nombre: "Iniciar Sesión", ruta: "/login_participante" },
    { nombre: "Suscribirse", ruta: "/suscribirse" }
  ];

  return (
    <nav className="navbar-container">
      
      <div className="navbar-menu">
        {menuEstructurado.map((item, index) => (
          <div 
            key={index}
            className={`navbar-item ${item.subitems ? 'has-dropdown' : ''}`}
            onMouseEnter={() => item.subitems && setActiveMenu(index)}
            onMouseLeave={() => item.subitems && setActiveMenu(null)}
          >
            <Link to={item.ruta}>{item.nombre}</Link>
            {item.subitems && activeMenu === index && (
              <div className="navbar-dropdown">
                {item.subitems.map((subitem, subIndex) => (
                  <Link key={subIndex} to={subitem.ruta} className="dropdown-item">
                    {subitem.nombre}
                  </Link>
                ))}
              </div>
            )}
          </div>
        ))}
      </div>
      
      <div className="navbar-actions">
        {menuDerecha.map((item, index) => (
          <Link key={index} to={item.ruta} className="navbar-action-item">
            {item.nombre}
          </Link>
        ))}
      </div>
    </nav>
  );
};

export default Navbar;