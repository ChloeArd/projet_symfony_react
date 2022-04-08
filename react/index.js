import "./index.css";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import {Home} from "./pages/Home";
import {Contact} from "./pages/Contact";
import {UserAccount} from "./pages/UserAccount";
import {Header} from "./components/Header";
import {RouteNotFound} from "./components/RouteNotFound";
import {createGlobalStyle, ThemeProvider} from "styled-components";
import {getTheme} from "./theming";
import {ThemeContext} from "./context/ThemeContext";

const BodyStyle = createGlobalStyle`
  body {
    background-color: ${({theme}) => theme !== undefined && theme.body.background};
  }
`;

ReactDOM.render(
    <BrowserRouter>
        <ThemeContext >
            <BodyStyle />
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



