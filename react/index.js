import "./index.css";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import {Home} from "./pages/Home";
import {Contact} from "./pages/Contact";
import {UserAccount} from "./pages/UserAccount";
import {Header} from "./components/Header";
import {RouteNotFound} from "./components/RouteNotFound";
import {ThemeContext} from "./context/ThemeContext";

ReactDOM.render(
    <BrowserRouter>
        <ThemeContext>
            <Header/>
            <Routes>
                <Route path="/" element={<Home/>}/>
                <Route path="contact" element={<Contact/>}/>
                <Route path="user-account" element={<UserAccount/>}/>
                <Route path="*" element={<RouteNotFound/>}/>
            </Routes>
        </ThemeContext>
    </BrowserRouter>,
    document.getElementById("root")
);



