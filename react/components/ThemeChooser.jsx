import styled from "styled-components";
import {ThemeContextProvider} from "../context/ThemeContext";
import {useContext} from "react";

export const ThemeChooser = function () {

    const {theme, toggleTheme} = useContext(ThemeContextProvider);

    return (
        <ButtonContainer>
            <button onClick={toggleTheme}>
                Mode {theme === "light" ? "dark" : "light"}
            </button>
        </ButtonContainer>
    );
}

const ButtonContainer = styled.div`
  padding: 20px 0;
  display: flex;
  justify-content: flex-end;
  flex-grow: 1;
  width: 7%;
  
  & > button {
    border: none;
    background-color: #5eb5e0;
    padding: 8px;
    border-radius: 10px;
    color: white;
  }
`;