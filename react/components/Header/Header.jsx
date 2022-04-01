import "./Header.css";
import logo from "../../../assets/images/logo.png";
import { Link } from "react-router-dom";

export const Header = function () {
  return (
    <div className="Header">
      <img src={logo} alt="Shop logo" />
      <div className="nav-links">
        <Link to="/">Accueil</Link>
        <Link to="promotions?color=black">Promotions</Link>
        <Link to="user-account">User Account</Link>
        <Link to="contact">Contact</Link>
      </div>
    </div>
  );
};
