import { useParams } from "react-router-dom";
import styled from "styled-components";

export const RouteNotFound = function () {
  const params = useParams();

  return (
    <Error>
      Erreur 404, la page <strong>{params["*"]}</strong> n'existe pas !
    </Error>
  );
};

const Error = styled.h1`
    font-size: 40px;
    text-align: center;
`;