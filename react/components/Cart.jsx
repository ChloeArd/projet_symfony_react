import {CartItem} from "./CartItem";
import {useContext, useEffect, useState} from "react";
import {Loader} from "./Loader";
import styled from "styled-components";
import {CartContextProvider} from "../context/CartContext";
import {ThemeContextProvider} from "../context/ThemeContext";
import {getTheme} from "../theming";

export const Cart = function ()
{
    const [cartItems, setCartItems] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const {cartUpdated, setCartUpdated} = useContext(CartContextProvider);
    const {theme} = useContext(ThemeContextProvider);

    useEffect(() => {
        async function getCart() {
            setIsLoading(true);
            const response = await fetch('/api/cart');
            const data = await response.json();
            setCartItems(data.cartItems);
            setCartUpdated(false);
            setIsLoading(false);
        }
        getCart().catch(() => setIsLoading(false));
    }, [cartUpdated]);

    async function deleteCartClick() {
        await fetch("api/cart/delete", {method: "post"});
        setCartUpdated(true);
    }

    return (
        <ContainerCart theme={getTheme(theme)}>
            <Title theme={getTheme(theme)}>Vos articles</Title>
            {isLoading ? (
                <Loader />
            ) : (
            cartItems.map(cartItem => <CartItem key={cartItem.product.id} cartItem={cartItem}/>)
            )}

            <Button theme={getTheme(theme)} onClick={deleteCartClick}>Vider le panier</Button>
        </ContainerCart>
    );
}

const ContainerCart = styled.div`
    border-radius: 10px;
    width: 20%;
    padding: 15px;
    height: 800px;
    margin: 40px 15px 40px 40px;
    background-color: ${({theme}) => theme.components.background};
    box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px 0;

`;

const Title = styled.h1`
    color: ${({theme}) => theme.components.textColor};
    margin: 25px 0 25px 15px;
`;

const Button = styled.button`
    padding: 10px;
    font-size: 20px;
    background-color: transparent;
    border-radius: 10px;
    border: 1px solid #8C8E92;
    margin-left: 55%;
    color: ${({theme}) => theme.components.textColor};
    &:hover {
        background-color: #8C8E92;
        color: white;
    }
`;