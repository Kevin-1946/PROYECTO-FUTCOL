import React, { useState, useEffect } from "react";
import "./encuentroCrud.css";
import TablaCrud from "../tablacrud/TablaCrud";
import {
  getEncuentros,
  createEncuentro,
  updateEncuentro,
  deleteEncuentro,
} from "../../api/encuentros";

const EncuentroCrud = () => {
  const [datos, setDatos] = useState([]);

  // Columnas visibles en la tabla
  const columnas = ["Sede", "Fecha", "Hora", "Partido"];

  // Obtener encuentros desde la API
  const fetchEncuentros = async () => {
    try {
      const res = await getEncuentros();
      const datosFormateados = res.data.map((encuentro) => ({
        id: encuentro.id,
        Sede: encuentro.sede,
        Fecha: encuentro.fecha,
        Hora: encuentro.hora,
        Partido: `${encuentro.local} vs ${encuentro.visitante}`,
        local: encuentro.local,
        visitante: encuentro.visitante,
      }));
      setDatos(datosFormateados);
    } catch (error) {
      console.error("Error al obtener los encuentros:", error);
    }
  };

  useEffect(() => {
    fetchEncuentros();
  }, []);

  // Crear nuevo encuentro
  const handleCrear = async (form) => {
    const [local, visitante] = (form.Partido || "").split(" vs ");
    if (!local || !visitante) {
      alert("El campo 'Partido' debe tener el formato: Equipo A vs Equipo B");
      return;
    }

    const nuevoEncuentro = {
      sede: form.Sede,
      fecha: form.Fecha,
      hora: form.Hora,
      local: local.trim(),
      visitante: visitante.trim(),
    };

    try {
      await createEncuentro(nuevoEncuentro);
      fetchEncuentros();
    } catch (error) {
      console.error("Error al crear encuentro:", error);
    }
  };

  // Editar encuentro existente
  const handleEditar = async (id, form) => {
    const [local, visitante] = (form.Partido || "").split(" vs ");
    if (!local || !visitante) {
      alert("El campo 'Partido' debe tener el formato: Equipo A vs Equipo B");
      return;
    }

    const encuentroActualizado = {
      sede: form.Sede,
      fecha: form.Fecha,
      hora: form.Hora,
      local: local.trim(),
      visitante: visitante.trim(),
    };

    try {
      await updateEncuentro(id, encuentroActualizado);
      fetchEncuentros();
    } catch (error) {
      console.error("Error al actualizar encuentro:", error);
    }
  };

  // Eliminar encuentro
  const handleEliminar = async (id) => {
    try {
      await deleteEncuentro(id);
      fetchEncuentros();
    } catch (error) {
      console.error("Error al eliminar encuentro:", error);
    }
  };

  return (
    <TablaCrud
      titulo="Encuentros"
      columnas={columnas}
      datos={datos}
      onCrear={handleCrear}
      onEditar={handleEditar}
      onEliminar={handleEliminar}
    />
  );
};

export default EncuentroCrud;