import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import fondo_torneos from "../../assets/imagenes/fondo_torneos.jpg";
import liga from "../../assets/imagenes/torneo_liga.png";
import relampago from "../../assets/imagenes/torneo_relampago.png";
import categorias from "../../assets/imagenes/torneo_categorias.png";
import directa from "../../assets/imagenes/torneo_e_directa.png";
import { Link } from "react-router-dom";
import "../../index.css";

const torneosData = [
  {
    id: 1,
    titulo: "Torneo Liga",
    descripcion:
      "Un torneo que se extiende por varias semanas o meses, donde los equipos juegan entre sí en un formato de liga, acumulando puntos para determinar el campeón al final de la temporada.",
    imagen: liga,
  },
  {
    id: 2,
    titulo: "Torneo Relámpago",
    descripcion:
      "Un torneo de corta duración, ideal para solo un día o fin de semana, donde los equipos juegan partidos eliminatorios rápidos hasta que se define un campeón.",
    imagen: relampago,
  },
  {
    id: 3,
    titulo: "Torneo de Categorías",
    descripcion:
      "Torneos segmentados por edad, género, o por combinación de ambos, permitiendo la participación de diferentes grupos demográficos.",
    imagen: categorias,
  },
  {
    id: 4,
    titulo: "Eliminación Directa",
    descripcion:
      "Una competencia donde los equipos se enfrentan en partidos individuales, y el perdedor de cada encuentro queda eliminado. El ganador avanza hasta que solo quede un campeón.",
    imagen: directa,
  },
];

const Torneos = () => {
  return (
    <>
      <div
        style={{
          backgroundImage: `url(${fondo_torneos})`,
          backgroundSize: "cover",
          backgroundPosition: "center",
          minHeight: "100vh",
          padding: "40px 0",
        }}
      >
        <div className="container text-white">
          <h1 className="text-center mb-5">Torneos Disponibles</h1>

          <div className="row justify-content-center">
            {torneosData.map((torneo) => (
              <div key={torneo.id} className="col-md-6 col-lg-3 d-flex justify-content-center">
                <div className="torneo-card">
                  <img src={torneo.imagen} alt={torneo.titulo} className="img-fluid" />
                  <div className="descripcion-torneo">
                    <p>{torneo.descripcion}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Botón único centrado */}
          <div className="text-center mt-5">
            <Link to="/suscribirse">
              <button className="btn btn-lg btn-primary px-5 py-2">Suscribirse</button>
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default Torneos;