import './Cart.css';

import {CartItem} from "../CartItem/CartItem";
import {useEffect, useState} from "react";
import loading from "../../../assets/images/waiting-texting.gif"

export const Cart = function ({cartUpdated, setCartUpdated})
{
    const [cartItems, setCartItems] = useState([]);
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        /*const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/cart');
        xhr.responseType = 'json';
        xhr.onload = () => {setCartItems(xhr.response)};
        xhr.send();*/

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

    function handleCartEmptyButtonClick() {
        cartItems.map(cartItem => cartItem.quantity = 0);
        setCartUpdated(true);
    }

    return (
        <div className="Cart">
            <h1 className="title">Vos articles</h1>
            {isLoading ? (
                <img id="loading" src={loading} alt="Le panier est en chargement" />
            ) : (
            cartItems.map(cartItem => <CartItem key={cartItem.product.id} cartItem={cartItem}/>)
            )}

            <button className="empty" onClick={handleCartEmptyButtonClick}>Vider le panier</button>
        </div>
    );
}