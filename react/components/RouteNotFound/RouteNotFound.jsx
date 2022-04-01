import "./RouteNotFound.css";
import { useParams } from "react-router-dom";

export const RouteNotFound = function () {
  const params = useParams();

  return (
    <h1 className="title center">
      Erreur 404, la page <strong>{params["*"]}</strong> n'existe pas !
    </h1>
  );
};
