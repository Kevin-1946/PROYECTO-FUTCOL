import { Routes, Route, useLocation } from "react-router-dom";
import Futcol from "./paginas/inicio/futcol";
import Torneos from "./paginas/torneos/torneos";
import Nosotros from "./paginas/informacion/sobre_nosotros";
import LoginParticipante from "./paginas/participantes/login_participante";
import Suscribirse from "./paginas/participantes/suscribirse";

import Amonestacion from "./paginas/torneos/amonestacion";
import Encuentros from "./paginas/torneos/encuentros";
import Equipos from "./paginas/torneos/equipos";
import Inscripcion from "./paginas/administracion/inscripciones";
import Juez from "./paginas/administracion/juez";
import Jugador from "./paginas/administracion/jugador";
import Recibo from "./paginas/administracion/recibo_de_pago";
import Resultados from "./paginas/administracion/resultados";
import Suscritos from "./paginas/administracion/lista_de_suscritos";
import Usuarios from "./paginas/administracion/usuarios";

import Navbar from "./componentes/navbar/navbar";

function App() {
  const location = useLocation();

  // Modificado para mostrar siempre Navbar (según tu requerimiento)
  const ocultarHeader = ["/", "/login", "/suscripcion"].includes(location.pathname);

  return (
    <>
      <Navbar /> {/* Siempre visible */}

      <Routes>
        <Route path="/" element={<Futcol />} />
        <Route path="/torneos" element={<Torneos />} />
        {/* Añadidas rutas anidadas para torneos */}
        <Route path="/torneos/amonestacion" element={<Amonestacion />} />
        <Route path="/torneos/encuentros" element={<Encuentros />} />
        <Route path="/torneos/equipos" element={<Equipos />} />
        
        <Route path="/informacion/sobre_nosotros" element={<Nosotros />} />
        <Route path="/login_participante" element={<LoginParticipante />} />
        <Route path="/suscribirse" element={<Suscribirse />} />

        {/* Rutas de administración */}
        <Route path="/administracion/inscripciones" element={<Inscripcion />} />
        <Route path="/administracion/recibodepago" element={<Recibo />} />
        <Route path="/administracion/resultados" element={<Resultados />} />
        <Route path="/administracion/suscritos" element={<Suscritos />} />
        <Route path="/administracion/usuarios" element={<Usuarios />} />

        {/* Rutas de participantes */}
        <Route path="/participantes/jugador" element={<Jugador />} />
        <Route path="/participantes/juez" element={<Juez />} />
      </Routes>
    </>
  );
}

export default App;