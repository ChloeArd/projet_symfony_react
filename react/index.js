import "./index.css";
import reportWebVitals from "../assets/js/reportWebVitals";

import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Home } from "./pages/Home/Home";
import { Contact } from "./pages/Contact/Contact";
import { UserAccount } from "./pages/UserAccount/UserAccount";
import { Header } from "./components/Header/Header";
import { Promotions } from "./pages/Promotions/Promotions";
import { RouteNotFound } from "./components/RouteNotFound/RouteNotFound";

ReactDOM.render(
  <BrowserRouter>
    <Header />
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="contact" element={<Contact />} />
      <Route path="user-account" element={<UserAccount />} />
      <Route path="promotions" element={<Promotions />} />
      <Route path="*" element={<RouteNotFound />} />
    </Routes>
  </BrowserRouter>,
  document.getElementById("root")
);

reportWebVitals();
