import './Cart.css';

import {CartItem} from "../CartItem/CartItem";
import {useEffect, useState} from "react";
import {Loader} from "../Loader/Loader";

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

    function handleCartEmptyButtonClick() {
        cartItems.map(cartItem => cartItem.quantity = 0);
        setCartUpdated(true);
    }

    return (
        <div className="Cart">
            <h1 className="title">Vos articles</h1>
            {isLoading ? (
                <Loader />
            ) : (
            cartItems.map(cartItem => <CartItem key={cartItem.product.id} cartItem={cartItem}/>)
            )}

            <button className="empty" onClick={handleCartEmptyButtonClick}>Vider le panier</button>
        </div>
    );
}