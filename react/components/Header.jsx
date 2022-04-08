import logo from "../../public/uploads/logo.png";
import {Link} from "react-router-dom";
import styled from "styled-components";
import {ThemeChooser} from "./ThemeChooser";

export const Header = function () {

    return (
        <ContainerHeader>
            <img src={logo} alt="Shop logo"/>
            <NavLinks>
                <CustomLink $background="coral" to="/">Accueil</CustomLink>
                <CustomLink to="user-account">User Account</CustomLink>
                <CustomLink to="contact">Contact</CustomLink>
            </NavLinks>
            <ThemeChooser />
        </ContainerHeader>
    );
};

const ContainerHeader = styled.header`
  width: 100%;
  margin: 0;
  padding: 10px;
  display: flex;
  flex-direction: row;
  align-items: center;
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 6px -1px, rgba(0, 0, 0, 0.06) 0 2px 4px -1px;

  & > img {
    width: 7%;
    padding-left: 20px;
  }
`;

const CustomLink = styled(Link)`
  margin-right: 10px;
  margin-left: 10px;
  text-decoration: none;
  font-size: 20px;
  color: ${({theme}) => theme.components.textColor};
  background-color: ${({$background}) => $background ? $background : "transparent"};

  &:hover {
    color: #1E64DD;
  }
`;

const NavLinks = styled.div`
  width: 90%;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: right;
`;