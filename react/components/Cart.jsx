import {CartItem} from "./CartItem/CartItem";
import {useEffect, useState} from "react";
import {Loader} from "./Loader/Loader";
import styled from "styled-components";

export const Cart = function ({cartUpdated, setCartUpdated})
{
    const [cartItems, setCartItems] = useState([]);
    const [isLoading, setIsLoading] = useState(false);

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
        <ContainerCart>
            <Title>Vos articles</Title>
            {isLoading ? (
                <Loader />
            ) : (
            cartItems.map(cartItem => <CartItem key={cartItem.product.id} cartItem={cartItem}/>)
            )}

            <Button onClick={deleteCartClick}>Vider le panier</Button>
        </ContainerCart>
    );
}

const ContainerCart = styled.div`
    border: 1px solid #F2F2F3;
    border-radius: 10px;
    width: 20%;
    padding: 15px;
    height: 800px;
    box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px 0;
    margin: 40px 15px 40px 40px;
`;

const Title = styled.h1`
    color: #5A6372;
    margin: 25px 0 25px 15px;
`;

const Button = styled.button`
    padding: 10px;
    font-size: 20px;
    background-color: transparent;
    border-radius: 10px;
    border: 1px solid #8C8E92;
    margin-left: 55%;
    &:hover {
        background-color: #8C8E92;
        color: white;
    }
`;