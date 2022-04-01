import "./Promotions.css";
import { NavLink, Outlet, useSearchParams } from "react-router-dom";
import { useState } from "react";

export const Promotions = function () {
  const [searchParams, setSearchParams] = useSearchParams();
  const [promotions, setPromotions] = useState([]);

  return (
    <>
      <h1 className="center">Nos promotions du moment</h1>
      <table className="promotions-table">
        <tbody>
          <tr>
            <th>Nom</th>
            <th>Prix</th>
            <th>Description</th>
          </tr>
          {promotions.map((product) => (
            <tr key={product.id}>
              <td>{product.title}</td>
              <td>{product.price}</td>
              <td>
                <NavLink
                  style={({ isActive }) => {
                    return {
                      color: isActive ? "orange" : "mediumseagreen",
                      background: searchParams.get("color"),
                    };
                  }}
                  to={`/promotions/${product.id}`}
                >
                  Voir description
                </NavLink>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <Outlet />
    </>
  );
};
