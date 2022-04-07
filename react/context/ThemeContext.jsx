import {createContext, useState} from "react";
import {createGlobalStyle} from "styled-components";

export const ThemeContextProvider = createContext({});

export const ThemeContext = function ({children}) {
    const [theme, setTheme] = useState("light");

    function toggleTheme() {
        setTheme(theme === "light" ? "dark" : "light");
    }

    return(
      <ThemeContextProvider.Provider value={{theme, toggleTheme}}>
          <BodyStyle chosenTheme={theme} />
          {children}
      </ThemeContextProvider.Provider>
    );
}

const BodyStyle = createGlobalStyle`
  body {
    font-family: Roboto, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background-color: ${({chosenTheme}) => 
        chosenTheme === "light" ? "#F9F9FA" : "#313131"};
    width: 100%;
    display: flex;
    flex-direction: column;
  }
  
  div {
    font-size: 13px;
  }
`;