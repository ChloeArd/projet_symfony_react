import './Cart.css';

import {CartItem} from "../CartItem/CartItem";
import {useEffect, useState} from "react";

export const Cart = function ({cartUpdated, setCartUpdated})
{
    const [cartItems, setCartItems] = useState([]);
    useEffect(() => {
        /*const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/cart');
        xhr.responseType = 'json';
        xhr.onload = () => {setCartItems(xhr.response)};
        xhr.send();*/

        async function getCart() {
            const response = await fetch('/api/cart');
            const data = await response.json();
            setCartItems(data.cartItems);
            setCartUpdated(false);
        }
        getCart().catch(() => console.log("Erreur avec la récupération du panier !"));
    }, [cartUpdated]);

    function handleCartEmptyButtonClick() {
        cartItems.map(cartItem => cartItem.quantity = 0);
        setCartUpdated(true);
    }

    return (
        <div className="Cart">
            <h1 className="title">Vos articles</h1>
            {cartItems.map(cartItem => <CartItem key={cartItem.product.id} product={cartItem}/>)}
            <button className="empty" onClick={handleCartEmptyButtonClick}>Vider le panier</button>
        </div>
    );
}